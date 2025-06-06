<?php

declare(strict_types=1);

namespace phpDocumentor\Guides\RestructuredText\Parser\Productions\Table;

use Exception;
use LogicException;
use phpDocumentor\Guides\Exception\InvalidTableStructure;
use phpDocumentor\Guides\Nodes\ParagraphNode;
use phpDocumentor\Guides\Nodes\Table\TableColumn;
use phpDocumentor\Guides\Nodes\Table\TableRow;
use phpDocumentor\Guides\Nodes\TableNode;
use phpDocumentor\Guides\RestructuredText\Parser\BlockContext;
use phpDocumentor\Guides\RestructuredText\Parser\Productions\RuleContainer;
use Psr\Log\LoggerInterface;

use function array_reverse;
use function count;
use function mb_strlen;
use function mb_substr;
use function preg_match;
use function sprintf;
use function str_contains;
use function str_repeat;
use function trim;

class GridTableBuilder
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    protected function compile(ParserContext $context): TableNode
    {
        $columnRanges = $context->getColumnRanges();
        $finalHeadersRow = $context->getHeaderRows();

        /** @var TableRow[] $rows */
        $rows = [];
        $partialSeparatorRows = $this->findRowSpans($context);
        $currentSpan = 1;

        foreach ($context->getDataLines() as $rowIndex => $line) {
            $row = new TableRow();
            $currentColumnStart = null;
            $previousColumnEnd = null;
            foreach ($columnRanges as $start => $end) {
                $this->assertColumnEnded($currentColumnStart, $previousColumnEnd);

                if ($currentColumnStart !== null) {
                    $cellText = mb_substr($line, $previousColumnEnd, $start - $previousColumnEnd);
                    if (!str_contains($cellText, '|') && !str_contains($cellText, '+')) {
                        // text continued through the "gap". This is a colspan
                        // "+" is an odd character - it's usually "|", but "+" can
                        // happen in row-span situations
                        $currentSpan++;
                        $previousColumnEnd = $end;
                        continue;
                    }

                    // we just hit a proper "gap" record the line up until now
                    $row->addColumn(
                        $this->createColumn($line, $currentColumnStart, $previousColumnEnd, $currentSpan),
                    );
                    $currentSpan = 1;
                    $currentColumnStart = null;
                }

                // if the current column start is null, then set it
                // otherwise, leave it - this is a colspan, and eventually
                // we want to get all the text starting here
                $currentColumnStart = $start;

                $previousColumnEnd = $end;
            }

            // record the last column
            $this->assertColumnEnded($currentColumnStart, $previousColumnEnd);

            if ($currentColumnStart !== null) {
                $row->addColumn(
                    $this->createColumn($line, $currentColumnStart, $previousColumnEnd, $currentSpan),
                );
            }

            $rows[$rowIndex] = $row;
        }

        $columnIndexesCurrentlyInRowspan = [];
        foreach ($rows as $rowIndex => $row) {
            if (isset($partialSeparatorRows[$rowIndex])) {
                // this row is part content, part separator due to a rowspan
                // for each column that contains content, we need to
                // push it onto the last real row's content and record
                // that this column in the next row should also be
                // included in that previous row's content
                foreach ($row->getColumns() as $columnIndex => $column) {
                    if (
                        !$column->isCompletelyEmpty()
                        && str_repeat(
                            '-',
                            mb_strlen($column->getContent()),
                        ) === $column->getContent()
                    ) {
                        // only a line separator in this column - not content!
                        continue;
                    }

                    $prevTargetColumn = $this->findColumnInPreviousRows((int) $columnIndex, $rows, (int) $rowIndex);
                    $prevTargetColumn->addContent("\n" . $column->getContent());
                    $prevTargetColumn->incrementRowSpan();
                    // mark that this column on the next row should also be added
                    // to the previous row
                    $columnIndexesCurrentlyInRowspan[] = $columnIndex;
                }

                // remove the row - it's not real
                unset($rows[$rowIndex]);

                continue;
            }

            // check if the previous row was a partial separator row, and
            // we need to take some columns and add them to a previous row's content
            foreach ($columnIndexesCurrentlyInRowspan as $columnIndex) {
                $prevTargetColumn = $this->findColumnInPreviousRows($columnIndex, $rows, (int) $rowIndex);
                $columnInRowspan = $row->getColumn($columnIndex);
                if ($columnInRowspan === null) {
                    throw new LogicException('Cannot find column for index "%s"', $columnIndex);
                }

                $prevTargetColumn->addContent("\n" . $columnInRowspan->getContent());

                // now this column actually needs to be removed from this row,
                // as it's not a real column that needs to be printed
                $row->removeColumn($columnIndex);
            }

            $columnIndexesCurrentlyInRowspan = [];

            // if the next row is just $i+1, it means there
            // was no "separator" and this is really just a
            // continuation of this row.
            $nextRowCounter = 1;
            while (isset($rows[(int) $rowIndex + $nextRowCounter])) {
                // but if the next line is actually a partial separator, then
                // it is not a continuation of the content - quit now
                if (isset($partialSeparatorRows[(int) $rowIndex + $nextRowCounter])) {
                    break;
                }

                $targetRow = $rows[(int) $rowIndex + $nextRowCounter];
                unset($rows[(int) $rowIndex + $nextRowCounter]);

                try {
                    $row->absorbRowContent($targetRow);
                } catch (InvalidTableStructure $e) {
                    $this->logger->error($e->getMessage());
                }

                $nextRowCounter++;
            }
        }

        $headers = [];
        // one more loop to set headers
        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex > $finalHeadersRow) {
                break;
            }

            $headers[] = $row;
            unset($rows[$rowIndex]);
        }

        return new TableNode($rows, $headers);
    }

    /** @param TableRow[] $rows */
    private function findColumnInPreviousRows(int $columnIndex, array $rows, int $currentRowIndex): TableColumn
    {
        /** @var TableRow[] $reversedRows */
        $reversedRows = array_reverse($rows, true);

        // go through the rows backwards to find the last/previous
        // row that actually had a real column at this position
        foreach ($reversedRows as $k => $row) {
            // start by skipping any future rows, as we go backward
            if ($k >= $currentRowIndex) {
                continue;
            }

            $prevTargetColumn = $row->getColumn($columnIndex);
            if ($prevTargetColumn !== null) {
                return $prevTargetColumn;
            }
        }

        throw new Exception('Could not find column in any previous rows');
    }

    public function buildNode(
        ParserContext $tableParserContext,
        BlockContext $blockContext,
        RuleContainer $productions,
    ): TableNode|null {
        $tableNode = $this->compile($tableParserContext);

        if ($tableParserContext->hasErrors()) {
            $tableAsString = $tableParserContext->getTableAsString();
            foreach ($tableParserContext->getErrors() as $error) {
                $message = sprintf(
                    "%s\nin file %s\n\n%s",
                    $error,
                    $blockContext->getDocumentParserContext()->getContext()->getCurrentFileName(),
                    $tableAsString,
                );
                $this->logger->error($message, $blockContext->getLoggerInformation());
            }

            return null;
        }

        $headers = [];
        foreach ($tableNode->getHeaders() as $row) {
            $headers[] = $this->buildRow($row, $blockContext, $productions);
        }

        $rows = [];
        foreach ($tableNode->getData() as $row) {
            $rows[] = $this->buildRow($row, $blockContext, $productions);
        }

        return new TableNode($rows, $headers);
    }

    private function buildRow(
        TableRow $row,
        BlockContext $blockContext,
        RuleContainer $productions,
    ): TableRow {
        $newRow = new TableRow();
        foreach ($row->getColumns() as $col) {
            $newRow->addColumn($this->buildColumn($col, $blockContext, $productions));
        }

        return $newRow;
    }

    private function buildColumn(
        TableColumn $col,
        BlockContext $blockContext,
        RuleContainer $productions,
    ): TableColumn {
        $content = $col->getContent();
        $subContext = new BlockContext($blockContext->getDocumentParserContext(), $content, false, $blockContext->getDocumentIterator()->key());
        while ($subContext->getDocumentIterator()->valid()) {
            $productions->apply($subContext, $col);
        }

        $nodes = $col->getChildren();
        if (count($nodes) > 1) {
            return $col;
        }

        // the list item offset is determined by the offset of the first text
        $firstNode = $nodes[0] ?? null;
        if ($firstNode instanceof ParagraphNode) {
            return new TableColumn(trim($content), $col->getColSpan(), $firstNode->getChildren(), $col->getRowSpan());
        }

        return $col;
    }

    private function createColumn(
        string $line,
        int $currentColumnStart,
        int|null $previousColumnEnd,
        int $currentSpan,
    ): TableColumn {
        return new TableColumn(
            mb_substr($line, $currentColumnStart, $previousColumnEnd - $currentColumnStart),
            $currentSpan,
        );
    }

    /** @phpstan-assert int $previousColumnEnd */
    private function assertColumnEnded(int|null $currentColumnStart, int|null $previousColumnEnd): void
    {
        if (($currentColumnStart !== null) && $previousColumnEnd === null) {
            throw new LogicException('The previous column end is not set yet');
        }
    }

    /** @return array<int, bool> */
    private function findRowSpans(ParserContext $context): array
    {
        $partialSeparatorRows = [];

        foreach ($context->getDataLines() as $rowIndex => $line) {
            // if the row is part separator row, part content, this
            // is a rowspan situation - e.g.
            // |           +----------------+----------------------------+
            // look for +-----+ pattern
            if (!$this->hasRowSpan($line)) {
                continue;
            }

            $partialSeparatorRows[$rowIndex] = true;
        }

        return $partialSeparatorRows;
    }

    private function hasRowSpan(string $line): bool
    {
        return preg_match('/\+[-]+\+/', $line) === 1;
    }
}
