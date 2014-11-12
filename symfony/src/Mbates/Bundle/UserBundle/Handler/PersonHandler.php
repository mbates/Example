<?php
namespace Mbates\Bundle\UserBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

use Mbates\Bundle\UserBundle\Model\PersonInterface;
use Mbates\Bundle\UserBundle\Form\PersonType;
use Mbates\Bundle\ApiBundle\Exception\InvalidFormException;

class PersonHandler implements PersonHandlerInterface
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
     * Get a Person.
     *
     * @param mixed $id
     *
     * @return PersonInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get a list of People.
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
     * Create a new Person.
     *
     * @param array $parameters
     *
     * @return PersonInterface
     */
    public function post( array $parameters )
    {
        $person = $this->createPerson();

        return $this->processForm( $person, $parameters, 'POST' );
    }

    /**
     * Edit a Person.
     *
     * @param PersonInterface $person
     * @param array            $parameters
     *
     * @return PersonInterface
     */
    public function put( PersonInterface $person, array $parameters )
    {
        return $this->processForm( $person, $parameters, 'PUT' );
    }

    /**
     * Partially update a Person.
     *
     * @param PersonInterface $person
     * @param array            $parameters
     *
     * @return PersonInterface
     */
    public function patch( PersonInterface $person, array $parameters )
    {
        return $this->processForm( $person, $parameters, 'PATCH' );
    }

    /**
     * Processes the form.
     *
     * @param PersonInterface $person
     * @param array            $parameters
     * @param String           $method
     *
     * @return PersonInterface
     *
     * @throws \Mbates\Bundle\ApiBundle\Exception\InvalidFormException
     */
    private function processForm( PersonInterface $person, array $parameters, $method = "PUT" )
    {
        $form = $this->formFactory->create( new PersonType(), $person, array( 'method' => $method, 'csrf_protection' => false ) );
        $form->submit( $parameters, 'PATCH' !== $method );

        $errors = $form->getErrorsAsString();
        if( !empty( $errors ) )
        {
            throw new InvalidFormException( 'Submitted data has errors : ' . serialize( $errors ) . ' : ' . serialize( $parameters ), $form );
        }

        elseif( $form->isValid() )
        {
            $person = $form->getData();
            $this->om->persist( $person );
            $this->om->flush( $person );

            return $person;
        }

        throw new InvalidFormException( 'Invalid submitted data : ' . serialize( $parameters ), $form );
    }

    private function createPerson()
    {
        return new $this->entityClass();
    }
}