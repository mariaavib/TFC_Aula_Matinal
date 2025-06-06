<?php

declare(strict_types=1);

namespace phpDocumentor\Guides\RestructuredText\DependencyInjection\Compiler;

use phpDocumentor\Guides\RestructuredText\TextRoles\TextRoleFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TextRolePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $textRoleFactory = $container->findDefinition(TextRoleFactory::class);
        $domains = [];
        $textRoles = [];

        foreach ($container->findTaggedServiceIds('phpdoc.guides.parser.rst.text_role') as $id => $tags) {
            foreach ($tags as $tag) {
                if (isset($tag['domain'])) {
                    $domains[$tag['domain']][] = new Reference($id);
                    continue;
                }

                $textRoles[] = new Reference($id);
            }
        }

        $textRoleFactory->setArgument('$textRoles', $textRoles);
        $textRoleFactory->setArgument('$domains', $domains);
    }
}
