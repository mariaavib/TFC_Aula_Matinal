<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link https://phpdoc.org
 */

namespace phpDocumentor\Guides\Meta;

class InternalTarget implements Target
{
    private string $url;

    public function __construct(
        private readonly string $documentPath,
        protected string $anchorName,
        private readonly string|null $title = null,
    ) {
    }

    public function getDocumentPath(): string
    {
        return $this->documentPath;
    }

    public function getAnchor(): string
    {
        return $this->anchorName;
    }

    public function setAnchorName(string $anchorName): void
    {
        $this->anchorName = $anchorName;
    }

    public function getTitle(): string|null
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): InternalTarget
    {
        $this->url = $url;

        return $this;
    }
}
