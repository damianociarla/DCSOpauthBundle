<?php

namespace DCS\OpauthBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class DCSOpauthExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('dcs_opauth.call_params', array(
            'debug_mode' => $config['debug_mode'],
            'callback_transport' => $config['callback_transport'],
            'security_iteration' => $config['security_iteration'],
            'security_timeout' => $config['security_timeout'],
        ));
        $container->setParameter('dcs_opauth.authentication_roles', $config['authentication_roles']);
        $container->setParameter('dcs_opauth.redirect_after_response', $config['redirect_after_response']);
        $container->setParameter('dcs_opauth.error_view', $config['error_view']);

        $container->setAlias('dcs_opauth.strategy_parser', $config['logic']['strategy_parser']);
        $container->setAlias('dcs_opauth.response_parser', $config['logic']['response_parser']);
        $container->setAlias('dcs_opauth.authenticator', $config['logic']['authenticator']);

        $strategies = $this->buildStrategiesKey($config['strategies']);
        $container->setParameter('dcs_opauth.strategies', $strategies);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * Converts the key id and secret in the keys suitable for every strategy
     *
     * @param $strategies
     * @return array
     */
    private function buildStrategiesKey($strategies)
    {
        foreach ($strategies as $name => $config) {
            switch ($config['strategy_class']) {
                case 'Basecamp':
                case 'Behance':
                case 'Bitly':
                case 'Do':
                case 'Dropbox':
                case 'Evernote':
                case 'Foursquare':
                case 'GitHub':
                case 'Google':
                case 'Harvest':
                case 'Instagram':
                case 'Live':
                case 'Mixi':
                case 'Strava':
                case 'Yahoojp':
                case 'Yammer':
                case 'ResourceGuru':
                    $config['client_id'] = $config['id'];
                    $config['client_secret'] = $config['secret'];
                    break;
                case 'Bitbucket':
                case 'Flickr':
                case 'SinaWeibo':
                case 'Twitter':
                case 'Vimeo':
                    $config['key'] = $config['id'];
                    $config['secret'] = $config['secret'];
                    break;
                case 'Disqus':
                    $config['api_key'] = $config['id'];
                    $config['api_secret'] = $config['secret'];
                    break;
                case 'LinkedIn':
                    $config['api_key'] = $config['id'];
                    $config['secret_key'] = $config['secret'];
                    break;
                case 'Facebook':
                case 'PayPal':
                case 'VKontakte':
                    $config['app_id'] = $config['id'];
                    $config['app_secret'] = $config['secret'];
                    break;
                case 'Tumblr':
                    $config['consumer_key'] = $config['id'];
                    $config['consumer_secret'] = $config['secret'];
                    break;
            }
            // Remove unused parameters
            unset($config['id']);
            unset($config['secret']);
            // Set new configuration
            $strategies[$name] = $config;
        }

        return $strategies;
    }
}
