<?php

namespace Acme\Bundle\MobileBundle\DependencyInjection;

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
class AcmeMobileExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $mobileConfigFile = __DIR__ . '/../Resources/config/mobile_config.yml';
        $configs          = array_merge(Yaml::parse(file_get_contents($mobileConfigFile)), $configs);
        if (!isset($configs['api_school'])) throw new \RuntimeException('configuration api_school is missing.');        

        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        if (!isset($config['urls'])) throw new \RuntimeException('configuration api_school.urls is missing.');

        $options = array();
        foreach ($config['urls'] as $key => $value) {
            $options[$key] = $value;
        };

        $teacherOptions = array();
        foreach ($config['html_nodes'] as $key => $value) {
            $teacherOptions[$key] = $value;
        };

        $resultOptions = array();
        foreach ($config['result_message'] as $key => $value) {
            $resultOptions[$key] = $value;
        };


        $container->setParameter('api_school.urls', $options);
        $container->setParameter('api_school.html_nodes', $teacherOptions);
        $container->setParameter('api_school.result_message', $resultOptions);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
