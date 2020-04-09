<?php
namespace IndigoTest\ORM;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * Class AbstractTestCase
 *
 * @package IndigoTest\ORM
 * @author Danijel Fabijan <hipnaba@gmail.com>
 * @link https://github.com/hipnaba/indigo-orm
 */
abstract class OrmTestCase extends TestCase
{
    private ContainerInterface $container;
    private EntityManagerInterface $em;

    /**
     * @return ContainerInterface
     */
    protected function getContainer(): ContainerInterface
    {
        if (!isset($this->container)) {
            $this->container = include __DIR__ . '/container.php';
        }

        return $this->container;
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        if (!isset($this->em)) {
            $container = $this->getContainer();
            $this->em = $container->get(EntityManagerInterface::class);
        }

        return $this->em;
    }
}
