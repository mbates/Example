<?php
namespace Mbates\Bundle\UserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PersonRepository
 */
class PersonRepository extends EntityRepository
{
    /**
     * Get all people
     *
     * Call this with knp_pagination
     */
    public function findAllPaginator()
    {
        return $this->createQueryBuilder("person");
    }
}