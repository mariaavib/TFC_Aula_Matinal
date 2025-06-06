<?php

declare(strict_types=1);

namespace phpDocumentor\Guides\Markdown\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

use function dirname;

class MarkdownExtension extends Extension implements PrependExtensionInterface, CompilerPassInterface
{
    /** @param mixed[] $configs */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader(
            $container,
            new FileLocator(dirname(__DIR__, 3) . '/resources/config'),
        );

        $loader->load('guides-markdown.php');
    }

    public function prepend(ContainerBuilder $container): void
    {
    }

    public function process(ContainerBuilder $container): void
    {
    }
}
