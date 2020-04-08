<?php
namespace Indigo\ORM\Service;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class ConnectionFactory
 *
 * @package Indigo\ORM\Service
 * @author Danijel Fabijan <hipnaba@gmail.com>
 * @link https://github.com/hipnaba/indigo-orm
 */
final class ConnectionFactory implements FactoryInterface
{
    const CONFIG_KEY = 'database';

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (($config = $container->get('config')[self::CONFIG_KEY] ?? null) === null) {
            throw new ServiceNotCreatedException(sprintf(
                "%s: Missing configuration key '%s'.",
                __METHOD__, self::CONFIG_KEY
            ));
        }

        try {
            return DriverManager::getConnection($config);
        } catch (DBALException $e) {
            throw new ServiceNotCreatedException(sprintf(
                "%s: Could not create database connection.", __METHOD__
            ), 0, $e);
        }
    }
}
