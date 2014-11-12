<?php
namespace Mbates\Bundle\FixtureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Mbates\Bundle\UserBundle\Entity\Person;
use Mbates\Bundle\UserBundle\Entity\Group;

class PersonFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer( ContainerInterface $container = null )
    {
        $this->container = $container;
    }

    public function load( ObjectManager $manager )
    {
        $sysAdminGroup = new Group( 'System Admin', [ 'ROLE_SUPER_ADMIN' ] );
        $manager->persist( $sysAdminGroup );

        $adminGroup = new Group( 'Admin', [ 'ROLE_ADMIN' ] );
        $manager->persist( $adminGroup );

        $playerGroup = new Group( 'Player', [ 'ROLE_USER' ] );
        $manager->persist( $playerGroup );

        $manager->flush();

        $encoder = $this->container->get( 'security.encoder_factory' )->getEncoder( new Person() );
        $userManager = $this->container->get( 'fos_user.user_manager' );

        // SYSTEM ADMIN
        $user = $userManager->createUser();
        $user->setUsername( 'mikebates' )
             ->setTitle( 'Mr' )
             ->setGivenName( 'Mike' )
             ->setFamilyName( 'Bates' )
             ->setEmail( 'mikeybates@gmail.com' )
             ->setPassword( $encoder->encodePassword( 'secret', $user->getSalt() ) )
             ->setEnabled( true )
             ->setCreated( new \DateTime() )
             ->setUpdated( $user->getCreated() )
             ->addGroup( $sysAdminGroup );
        $userManager->updateUser( $user, true );
        $this->addReference( 'mike-bates', $user );

        $user = $userManager->createUser();
        $user->setUsername( 'mattbates' )
             ->setTitle( 'Mr' )
             ->setGivenName( 'Matt' )
             ->setFamilyName( 'Bates' )
             ->setEmail( 'info@mbates.net' )
             ->setPassword( $encoder->encodePassword( 'secret', $user->getSalt() ) )
             ->setEnabled( true )
             ->setCreated( new \DateTime() )
             ->setUpdated( $user->getCreated() )
             ->addGroup( $adminGroup );
        $userManager->updateUser( $user, true );
        $this->addReference( 'matt-bates', $user );

        $user = $userManager->createUser();
        $user->setUsername( 'markbates' )
             ->setTitle( 'Mr' )
             ->setGivenName( 'Mark' )
             ->setFamilyName( 'Bates' )
             ->setEmail( 'mbates@opskwan.com' )
             ->setPassword( $encoder->encodePassword( 'secret', $user->getSalt() ) )
             ->setEnabled( true )
             ->setCreated( new \DateTime() )
             ->setUpdated( $user->getCreated() )
             ->addGroup( $playerGroup );
        $userManager->updateUser( $user, true );
        $this->addReference( 'mark-bates', $user );
    }

    public function getOrder()
    {
        return 1;
    }

}