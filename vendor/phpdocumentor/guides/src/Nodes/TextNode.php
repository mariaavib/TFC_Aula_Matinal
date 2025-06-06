<?php

declare(strict_types=1);

namespace phpDocumentor\Guides\Nodes;

use function implode;
use function strlen;
use function substr;
use function trim;

/** @extends AbstractNode<string> */
abstract class TextNode extends AbstractNode
{
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    /** @param string[] $lines */
    protected static function normalizeLines(array $lines): string
    {
        if ($lines !== []) {
            $firstLine = $lines[0];

            $length = strlen($firstLine);
            $offset = 0;
            for (; $offset < $length; $offset++) {
                if (trim($firstLine[$offset]) !== '') {
                    break;
                }
            }

            foreach ($lines as &$line) {
                $line = substr($line, $offset);
            }
        }

        return implode("\n", $lines);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
