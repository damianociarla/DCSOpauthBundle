<?php

namespace DCS\OpauthBundle\DependencyInjection;

use DCS\OpauthBundle\Configuration\Factory;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private $strategies = array(
        'Basecamp',
        'Behance',
        'Bitbucket',
        'Bitly',
        'Disqus',
        'Do',
        'Dropbox',
        'Evernote',
        'Facebook',
        'Flickr',
        'Foursquare',
        'GitHub',
        'Google',
        'Harvest',
        'Instagram',
        'LinkedIn',
        'Live',
        'Mixi',
        'OpenID',
        'PayPal',
        'SinaWeibo',
        'Strava',
        'Tumblr',
        'Twitter',
        'Vimeo',
        'VKontakte',
        'Yahoojp',
        'Yammer',
        'ResourceGuru',
    );

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dcs_opauth');

        $rootNode
            ->children()
                ->booleanNode('debug_mode')
                    ->defaultFalse()
                ->end()
                ->scalarNode('callback_transport')
                    ->defaultValue('session')
                    ->validate()
                    ->ifNotInArray(array('session','post','get'))
                        ->thenInvalid('Value "%s" is not a valid callback_transport')
                    ->end()
                ->end()
                ->integerNode('security_iteration')
                    ->defaultValue(300)
                ->end()
                ->scalarNode('security_timeout')
                    ->defaultValue('2 minutes')
                ->end()
                ->arrayNode('authentication_roles')
                    ->defaultValue(array('ROLE_USER'))
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('redirect_after_response')
                    ->defaultNull()
                ->end()
                ->scalarNode('error_view')
                    ->cannotBeEmpty()
                    ->defaultValue('DCSOpauthBundle:Response:error.html.twig')
                ->end()
                ->arrayNode('logic')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('strategy_parser')
                            ->cannotBeEmpty()
                            ->defaultValue('dcs_opauth.configuration.strategy_parser.default')
                        ->end()
                        ->scalarNode('response_parser')
                            ->cannotBeEmpty()
                            ->defaultValue('dcs_opauth.response.response_parser.default')
                        ->end()
                        ->scalarNode('authenticator')
                            ->cannotBeEmpty()
                            ->defaultValue('dcs_opauth.security.authenticator.default')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('strategies')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('id')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('secret')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('strategy_class')
                                ->isRequired()
                                ->validate()
                                ->ifNotInArray($this->strategies)
                                    ->thenInvalid('Value "%s" is not a valid strategy')
                                ->end()
                            ->end()
                            ->variableNode('options')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
