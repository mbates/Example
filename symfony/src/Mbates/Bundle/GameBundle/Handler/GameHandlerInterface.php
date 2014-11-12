<?php
namespace Mbates\Bundle\GameBundle\Handler;

use Mbates\Bundle\GameBundle\Model\GameInterface;
use Mbates\Bundle\UserBundle\Entity\Person;

interface GameHandlerInterface
{
    /**
     * Get a Game.
     *
     * @param mixed $id
     *
     * @return GameInterface
     */
    public function get($id);

    /**
     * Get a list of Games.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all( $limit = 5, $offset = 0 );

    /**
     * Create a new Game.
     *
     * @param array $parameters
     *
     * @return GameInterface
     */
    public function post( array $parameters );

    /**
     * Edit a Game.
     *
     * @param GameInterface $game
     * @param array            $parameters
     *
     * @return GameInterface
     */
    public function put( GameInterface $game, array $parameters );

    /**
     * Partially update a Game.
     *
     * @param GameInterface $game
     * @param array            $parameters
     *
     * @return GameInterface
     */
    public function patch( GameInterface $game, array $parameters );
}