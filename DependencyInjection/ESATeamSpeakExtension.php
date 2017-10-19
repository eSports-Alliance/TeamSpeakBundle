<?php

namespace eSA\TeamSpeakBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class ESATeamSpeakExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $container->setParameter('esa_team_speak.host', $config["host"]);
        $container->setParameter('esa_team_speak.port', $config["port"]);
        $container->setParameter('esa_team_speak.query_port', $config["query_port"]);
        $container->setParameter('esa_team_speak.username', $config["username"]);
        $container->setParameter('esa_team_speak.password', $config["password"]);
        $container->setParameter('esa_team_speak.nickname', $config["nickname"]);
        $container->setParameter('esa_team_speak.timeout', $config["timeout"]);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}
