<?php
namespace IndigoTest\ORM;

use Indigo\ORM\ConfigProvider;
use Indigo\ORM\Service\EntityRepositoryAbstractServiceFactory;
use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ServiceManager\ServiceManager;

$config = (new ConfigAggregator([
    ConfigProvider::class,
    new ArrayProvider([
        'dependencies' => [
            'abstract_factories' => [
                EntityRepositoryAbstractServiceFactory::class,
            ],
        ],
        'database' => [
            'driver' => 'pdo_sqlite',
            'path' => ':memory:',
        ],
        'orm' => [
            'dev_mode' => true,
            'entity_paths' => [
                __DIR__ . '/Entity',
            ],
        ],
    ]),
]))->getMergedConfig();

$config['dependencies']['services']['config'] = $config;
return new ServiceManager($config['dependencies']);
