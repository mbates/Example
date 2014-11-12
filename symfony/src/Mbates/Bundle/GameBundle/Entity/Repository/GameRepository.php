<?php

namespace Mbates\Bundle\GameBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * GameRepository
 */
class GameRepository extends EntityRepository
{
	/**
	 * Get list of games based on offset and limit
	 */
	public function getGameIndex( $offset, $limit )
	{
		$queryBuilder = $this->createQueryBuilder('g')
							 ->select('g')
							 ->addOrderBy('g.title', 'ASC');

		if( false === is_null( $offset ) )
		{
		   	$queryBuilder->setFirstResult( $offset );
		}

		if( false === is_null( $limit ) )
		{
			$queryBuilder->setMaxResults( $limit );
		}

		return $queryBuilder->getQuery()->getArrayResult();
	}
}
