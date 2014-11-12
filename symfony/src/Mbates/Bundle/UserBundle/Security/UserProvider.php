<?php
namespace Mbates\Bundle\UserBundle\Security;

use FOS\UserBundle\Security\UserProvider as FOSProvider;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FOS\UserBundle\Model\UserManagerInterface;

class UserProvider extends FOSProvider {

    /**
     *
     * @var ContainerInterface 
     */
    protected $container;


    public function __construct(UserManagerInterface $userManager, ContainerInterface $container) {
        parent::__construct($userManager);
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function findUserByApiKey($apiKey) {
        //return $this->userManager->findUserByApiKey($apiKey);

        $user = $this->userManager->findUserBy( array( 'api_key' => $apiKey ) );

        return $user;
    }

}