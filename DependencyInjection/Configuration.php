<?php

namespace eSA\TeamSpeakBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('esa_team_speak');

        $rootNode
            ->children()
            ->scalarNode('host')->isRequired()->end()
            ->integerNode('port')->defaultValue(9987)->end()
            ->integerNode('query_port')->defaultValue(10011)->end()
            ->scalarNode('username')->isRequired()->end()
            ->scalarNode('password')->isRequired()->end()
            ->scalarNode('nickname')->end()
            ->scalarNode('timeout')->end()
            ->end();

        return $treeBuilder;
    }
}
