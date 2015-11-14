<?php

namespace Acme\Bundle\WebUIBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AcmeWebUIExtension extends Extension
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $curlConfigFile   = __DIR__ . '/../Resources/config/ui_config.yml';
        $configs          = array_merge(Yaml::parse(file_get_contents($curlConfigFile)), $configs);
        if (!isset($configs['web_ui'])) throw new \RuntimeException('configuration ci_rest_client is missing.');

        $configuration  = new Configuration();
        $config         = $this->processConfiguration($configuration, $configs);

        if (!isset($config['homepage'])) throw new \RuntimeException('configuration ci_rest_client.curl is missing.');
        if (!isset($config['homepage']['titlebar'])) throw new \RuntimeException('configuration ci_rest_client.curl.defaults is missing.');

        $options = array();
        foreach ($config['homepage'] as $key => $value) {
            // $options[constant($key)] = $value;
            $options[$key] = $value;
        };

        // var_dump($options);

        $container->setParameter('web_ui.homepage', $options);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
