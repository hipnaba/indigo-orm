<?php
namespace Indigo\ORM\Service;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class EntityManagerFactory
 *
 * @package Indigo\ORM\Service
 * @author Danijel Fabijan <hipnaba@gmail.com>
 * @link https://github.com/hipnaba/indigo-orm
 */
final class EntityManagerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        try {
            return EntityManager::create(
                $container->get(Connection::class),
                $container->get(Configuration::class)
            );
        } catch (ORMException $e) {
            throw new ServiceNotCreatedException(sprintf(
                "%s: Could not create the entity manager.", __METHOD__
            ), 0, $e);
        }
    }
}
