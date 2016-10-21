<?php

namespace Jacoz\Symfony\ApiBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractBaseRepository extends EntityRepository
{
    /**
     * @param object $entity
     */
    public function persist($entity)
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     * @param object $entity
     */
    public function destroy($entity)
    {
        $this->getEntityManager()->remove($entity);
    }

    /**
     * @param object $entity
     */
    public function flush($entity = null)
    {
        $this->getEntityManager()->flush($entity);
    }

    public function beginTransaction()
    {
        $this->getEntityManager()->beginTransaction();
    }

    public function commit()
    {
        $this->getEntityManager()->commit();
    }

    public function rollback()
    {
        $this->getEntityManager()->rollback();
    }
}
