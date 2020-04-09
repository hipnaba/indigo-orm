<?php
namespace Indigo\ORM\Service;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Indigo\ORM\Repository\EntityRepository;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class ConfigurationFactory
 *
 * @package Indigo\ORM\Service
 * @author Danijel Fabijan <hipnaba@gmail.com>
 * @link https://github.com/hipnaba/indigo-orm
 */
final class ConfigurationFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config')['orm'] ?? [];

        if (is_string($config['cache'] ?? null) && !empty($config['cache'])) {
            $config['cache'] = $container->get($config['cache']);
        }

        try {
            $configuration = Setup::createAnnotationMetadataConfiguration(
                $config['entity_paths'] ?? [],
                $config['dev_mode'] ?? false,
                $config['proxy_dir'] ?? null,
                $config['cache'] ?? null,
                false
            );

            $configuration->setDefaultRepositoryClassName(EntityRepository::class);

            return $configuration;
        } catch (ORMException $e) {
            throw new ServiceNotCreatedException(sprintf(
                "%s: Could not create the entity manager configuraton.", __METHOD__
            ));
        }
    }
}
