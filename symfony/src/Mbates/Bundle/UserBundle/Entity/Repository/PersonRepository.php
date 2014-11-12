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
    public function findAll()
    {
        return $this->createQueryBuilder("person");
    }
}