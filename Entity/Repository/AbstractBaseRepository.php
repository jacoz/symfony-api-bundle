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
        $this->flush();
    }

    /**
     * @param object $entity
     */
    public function flush($entity = null)
    {
        $this->getEntityManager()->flush($entity);
    }
}
