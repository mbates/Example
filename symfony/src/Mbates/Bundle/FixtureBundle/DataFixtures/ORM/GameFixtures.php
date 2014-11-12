<?php
namespace Mbates\Bundle\FixtureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mbates\Bundle\GameBundle\Entity\Game;

class SurgeryFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load( ObjectManager $manager )
    {
        $game = new Game();
        $game->addOwner( $manager->merge( $this->getReference( 'mark-bates' ) ) )
             ->setTitle( 'Fifa Soccer 2014' )
             ->setNotes( 'Generated Game' )
             ->setCreated( new \DateTime() )
             ->setUpdated( $game->getCreated() );
        $manager->persist( $game );

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}