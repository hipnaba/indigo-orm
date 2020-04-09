<?php
namespace Indigo\ORM\Repository;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Persistence\ObjectRepository;

/**
 * Interface EntityRepositoryInterface
 *
 * @package Indigo\ORM\Repository
 * @author Danijel Fabijan <hipnaba@gmail.com>
 * @link https://github.com/hipnaba/indigo-orm
 */
interface EntityRepositoryInterface extends ObjectRepository, Selectable
{
    /**
     * Returns TRUE if an entity with the given $id exists.
     *
     * @param mixed $id
     * @return bool
     */
    public function exists($id): bool;
}
