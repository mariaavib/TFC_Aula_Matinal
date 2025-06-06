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

namespace phpDocumentor\Guides;

use League\Uri\UriInfo;

use function array_pop;
use function explode;
use function implode;
use function ltrim;
use function rtrim;
use function trim;

final class UrlGenerator implements UrlGeneratorInterface
{
    /**
     * Returns the absolute path, including prefixing '/'.
     *
     * This method will, by design, return an absolute path including the prefixing slash. The slash will make it clear
     * to the other URL generating methods that this need not be resolved and can stay the same.
     */
    public function absoluteUrl(string $basePath, string $url): string
    {
        $uri = UriFactory::createUri($url);
        if (UriInfo::isAbsolutePath($uri)) {
            return $url;
        }

        if ($basePath === '/') {
            return $basePath . $url;
        }

        return '/' . trim($basePath, '/') . '/' . $url;
    }

    /**
     * Returns the Path used in the Metas to find this file.
     *
     * The Metas collection, which is used to build the table of contents, uses these canonical paths as a unique
     * identifier to find the metadata for that file. Technically speaking, the canonical URL is the absolute URL
     * without the preceeding slash. But due to the many locations that this method is used; it will do its own
     * resolving.
     */
    public function canonicalUrl(string $basePath, string $url): string
    {
        if ($url[0] === '/') {
            return ltrim($url, '/');
        }

        $dirNameParts = explode('/', $basePath);
        $urlParts = explode('/', $url);
        $urlPass1 = [];

        foreach ($urlParts as $part) {
            if ($part === '.') {
                continue;
            }

            if ($part === '..') {
                array_pop($dirNameParts);
                continue;
            }

            $urlPass1[] = $part;
        }

        return ltrim(implode('/', $dirNameParts) . '/' . implode('/', $urlPass1), '/');
    }

    public function createFileUrl(string $filename, string $outputFormat = 'html', string|null $anchor = null): string
    {
        return $filename . '.' . $outputFormat .
            ($anchor !== null ? '#' . $anchor : '');
    }

    /**
     * Generate a canonical output URL with file extension, anchor and prefixed by
     * an absolute or relative path
     */
    public function generateOutputUrlFromDocumentPath(
        string $currentDirectory,
        string $destinationPath,
        string $linkedDocument,
        string $outputFormat,
        string|null $anchor = null,
    ): string {
        $canonicalUrl = $this->canonicalUrl(
            $currentDirectory,
            $linkedDocument,
        );

        $fileUrl = $this->createFileUrl($canonicalUrl, $outputFormat, $anchor);
        if ($destinationPath === '') {
            return $fileUrl;
        }

        return rtrim($destinationPath, '/') . '/' . $fileUrl;
    }
}
