<?php
namespace Indigo\ORM\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectRepository;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

/**
 * Class EntityRepositoryAbstractServiceFactory
 *
 * @package Indigo\ORM\Service
 * @author Danijel Fabijan <hipnaba@gmail.com>
 * @link https://github.com/hipnaba/indigo-orm
 */
final class EntityRepositoryAbstractServiceFactory implements AbstractFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return in_array(
            ObjectRepository::class,
            class_implements($requestedName)
        );
    }

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var EntityManager $em */
        $em = $container->get(EntityManagerInterface::class);
        /** @var ClassMetadata[] $metaData */
        $metaData = $em->getMetadataFactory()->getAllMetadata();

        foreach ($metaData as $metaDatum) {
            if (ltrim($metaDatum->customRepositoryClassName, '\\') === $requestedName) {
                return $em->getRepository($metaDatum->name);
            }
        }

        throw new ServiceNotCreatedException(sprintf(
            "%s: Could not find an entity associated with the repository class '%s'.",
            __METHOD__, $requestedName
        ));
    }
}
