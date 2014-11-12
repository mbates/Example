<?php
namespace Mbates\Bundle\UserBundle\Handler;

use Mbates\Bundle\UserBundle\Model\UserInterface;

interface PersonHandlerInterface
{
    /**
     * Get a Person.
     *
     * @api
     *
     * @param mixed $id
     *
     * @return PersonInterface
     */
    public function get($id);

    /**
     * Get a list of People.
     *
     * @api
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all( $limit = 5, $offset = 0 );

    /**
     * Create a new Person.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return PersonInterface
     */
    public function post( array $parameters );
}