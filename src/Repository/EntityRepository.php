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
     */
    public function exists($id): bool
    {
        $qb = $this->createQueryBuilder('e');
        $metaData = $this->getClassMetadata();

        try {
            $singleIdentifierFieldName = $metaData->getSingleIdentifierFieldName();
        } catch (MappingException $e) {
            $singleIdentifierFieldName = 'id';
        }

        $qb->select('1')
            ->where(
                $qb->expr()->eq('e.' . $singleIdentifierFieldName, ':id')
            );

        $query = $qb->getQuery();
        $query->setParameter('id', $id);

        $result = $query->getResult(Query::HYDRATE_SCALAR);
        return count($result) > 0;
    }
}
