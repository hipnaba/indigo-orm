<?php
namespace Indigo\ORM;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Connection as ConnectionInterface;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ConfigProvider
 *
 * @package Indigo\ORM
 * @author Danijel Fabijan <hipnaba@gmail.com>
 * @link https://github.com/hipnaba/indigo-orm
 */
final class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'orm' => $this->getOrmConfig(),
        ];
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'aliases' => [
                ConnectionInterface::class => Connection::class,
                EntityManagerInterface::class => EntityManager::class,
            ],

            'factories' => [
                Configuration::class => Service\ConfigurationFactory::class,
                Connection::class => Service\ConnectionFactory::class,
                EntityManager::class => Service\EntityManagerFactory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getOrmConfig(): array
    {
        return [
            'cache' => null,
            'dev_mode' => false,
            'entity_paths' => [],
            'proxy_dir' => null,
        ];
    }
}
