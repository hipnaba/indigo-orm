<?php
namespace IndigoTest\ORM\Repository;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use Doctrine\Persistence\ObjectRepository;
use Indigo\ORM\Repository\EntityRepository;
use Indigo\ORM\Repository\EntityRepositoryInterface;
use IndigoTest\ORM\Entity\User;
use IndigoTest\ORM\OrmTestCase;

/**
 * Class EntityRepositoryTest
 *
 * @package IndigoTest\ORM\Repository
 * @author Danijel Fabijan <hipnaba@gmail.com>
 * @link https://github.com/hipnaba/indigo-orm
 */
final class EntityRepositoryTest extends OrmTestCase
{
    /**
     * @param string $entityName
     * @return EntityRepositoryInterface|ObjectRepository
     */
    private function getRepository(string $entityName): EntityRepositoryInterface
    {
        return $this->getEntityManager()->getRepository($entityName);
    }

    /**
     * @throws ToolsException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $em = $this->getEntityManager();

        $tool = new SchemaTool($em);
        $tool->createSchema($em->getMetadataFactory()->getAllMetadata());
    }


    public function testCorrectDefaultEntityRepositoryIsUsed()
    {
        $repo = $this->getRepository(User::class);
        $this->assertInstanceOf(EntityRepository::class, $repo);
    }

    public function testExistsWillReturnTrueIfTheEntityExists()
    {
        $em = $this->getEntityManager();
        $repo = $this->getRepository(User::class);

        $user = new User();
        $em->persist($user);
        $em->flush();

        $this->assertTrue($repo->exists(1));
    }

    public function testExistsWillReturnFalseIfTheEntityDoesntExist()
    {
        $repo = $this->getRepository(User::class);
        $this->assertFalse($repo->exists(1));
    }

    public function testContainerCanCreateTheRepository()
    {
        $container = $this->getContainer();

        $this->assertTrue($container->has(UserRepository::class));
        $this->assertInstanceOf(UserRepository::class, $container->get(UserRepository::class));
    }
}
