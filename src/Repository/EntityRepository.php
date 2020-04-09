<?php
namespace Indigo\ORM\Repository;

use Doctrine\ORM\EntityRepository as BaseEntityRepository;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\ORM\Query;

/**
 * Class EntityRepository
 *
 * @package Indigo\ORM\Repository
 * @author Danijel Fabijan <hipnaba@gmail.com>
 * @link https://github.com/hipnaba/indigo-orm
 */
class EntityRepository extends BaseEntityRepository implements EntityRepositoryInterface
{
    /**
     * @inheritDoc
     * @throws MappingException
     */
    public function exists($id): bool
    {
        $qb = $this->createQueryBuilder('e');
        $metaData = $this->getClassMetadata();

        $qb->select('1')
            ->where(
                $qb->expr()->eq('e.' . $metaData->getSingleIdentifierFieldName(), ':id')
            );

        $query = $qb->getQuery();
        $query->setParameter('id', $id);

        $result = $query->getResult(Query::HYDRATE_SCALAR);
        return count($result) > 0;
    }
}
