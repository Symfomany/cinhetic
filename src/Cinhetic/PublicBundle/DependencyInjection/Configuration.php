<?php

namespace Cinhetic\PublicBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Cinhetic\PublicBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('cinhetic_public');

        $rootNode
            ->children()
                ->scalarNode('base_url')
                    ->defaultValue('/')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('URL de base /web')
                    ->example('http://localhost/cinhetic')
                ->end()
                ->scalarNode('nb_movies_per_page')
                    ->defaultValue(5)
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('Nb of movies per page')
                    ->example(5)
                ->end()
                ->scalarNode('nb_categories_per_page')
                    ->defaultValue(5)
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('Nb of categories per page')
                    ->example(5)
                ->end()
                ->scalarNode('nb_actors_per_page')
                    ->defaultValue(5)
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('Nb of actors per page')
                    ->example(5)
                ->end()
                ->scalarNode('nb_directors_per_page')
                    ->defaultValue(5)
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('Nb of directors per page')
                    ->example(5)
                ->end()
                ->scalarNode('nb_comments_per_page')
                    ->defaultValue(5)
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('Nb of comments per page')
                    ->example(5)
                ->end()
            ->end();

        return $treeBuilder;
    }
}
