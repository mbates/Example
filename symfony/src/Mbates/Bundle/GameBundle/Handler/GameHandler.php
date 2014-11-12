<?php
namespace Mbates\Bundle\GameBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

use Mbates\Bundle\GameBundle\Model\GameInterface;
use Mbates\Bundle\GameBundle\Form\GameType;
use Mbates\Bundle\UserBundle\Entity\Person;
use Mbates\Bundle\ApiBundle\Exception\InvalidFormException;

class GameHandler implements GameHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct( ObjectManager $om, $entityClass, FormFactoryInterface $formFactory )
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository( $this->entityClass );
        $this->formFactory = $formFactory;
    }


    /**
     * Get a Game.
     *
     * @param mixed $id
     *
     * @return GameInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }


    /**
     * Get a list of Games.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all( $limit = 5, $offset = 0 )
    {
        return $this->repository->findBy( array(), null, $limit, $offset );
    }

    /**
     * Create a new Game.
     *
     * @param array $parameters
     *
     * @return GameInterface
     */
    public function post( array $parameters )
    {
        $game = $this->createGame();

        return $this->processForm( $game, $parameters, 'POST' );
    }

    /**
     * Edit a Game.
     *
     * @param GameInterface $game
     * @param array            $parameters
     *
     * @return GameInterface
     */
    public function put( GameInterface $game, array $parameters )
    {
        return $this->processForm( $game, $parameters, 'PUT' );
    }

    /**
     * Partially update a Game.
     *
     * @param GameInterface $game
     * @param array            $parameters
     *
     * @return GameInterface
     */
    public function patch( GameInterface $game, array $parameters )
    {
        return $this->processForm( $game, $parameters, 'PATCH' );
    }

    /**
     * Processes the form.
     *
     * @param GameInterface $game
     * @param array            $parameters
     * @param String           $method
     *
     * @return GameInterface
     *
     * @throws \Mbates\Bundle\ApiBundle\Exception\InvalidFormException
     */
    private function processForm( GameInterface $game, array $parameters, $method = "PUT" )
    {

        $form = $this->formFactory->create( new GameType(), $game, array( 'method' => $method, 'csrf_protection' => false ) );
        $form->submit( $parameters, 'PATCH' !== $method );

        $errors = $form->getErrorsAsString();
        if( !empty( $errors ) )
        {
            throw new InvalidFormException( 'Submitted data has errors || ' . serialize( $errors ) . ' || ' . serialize( $parameters ), $form );
        }

        elseif( $form->isValid() )
        {
            $game = $form->getData();

            $this->om->persist( $game );
            $this->om->flush( $game );

            return $game;
        }

        throw new InvalidFormException( 'Invalid submitted data : ' . serialize( $parameters ), $form );
    }

    private function createGame()
    {
        return new $this->entityClass();
    }

}