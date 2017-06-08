<?php

namespace Welp\MailjetBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('welp_mailjet');

        $rootNode
            ->children()
                ->scalarNode('api_key')->isRequired()->info('Mailjet API key')->end()
                ->scalarNode('secret_key')->isRequired()->info('Mailjet API token')->end()
                ->scalarNode('event_endpoint_route')
                    ->defaultValue('welp_mailjet_event_endpoint')
                    ->info('Route name of the event API endpoint')
                ->end()
                ->scalarNode('event_endpoint_token')
                    ->defaultValue('123456789')
                    ->info('Security token to validate endpoint request with')
                ->end()
                // lists
                ->arrayNode('lists')
                    ->useAttributeAsKey('listId')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('contact_provider')->end()
                        ->end()
                    ->end()
                ->end()
                // ContactMetadata/ContactProperties
                ->arrayNode('contact_metadata')
                    ->prototype('array')
                        ->children()
                           ->scalarNode('name')
                               ->isRequired()
                           ->end()
                           ->scalarNode('datatype')
                               ->isRequired()
                           ->end()
                       ->end()
                   ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
