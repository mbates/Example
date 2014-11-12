<?php
namespace Mbates\Bundle\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Mbates\Bundle\GameBundle\Model\GameInterface;

/**
 * @ORM\Entity(repositoryClass="Mbates\Bundle\GameBundle\Entity\Repository\GameRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Game implements GameInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Mbates\Bundle\UserBundle\Entity\Person", mappedBy="games")
     */
    protected $owners;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $notes;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->owners = new \Doctrine\Common\Collections\ArrayCollection();

        $this->setCreated( new \DateTime() );
        $this->setUpdated( new \DateTime() );
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Game
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Game
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Game
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Game
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Game
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
    }

    /**
     * Add owners
     *
     * @param \Mbates\Bundle\UserBundle\Entity\Person $owners
     * @return Game
     */
    public function addOwner(\Mbates\Bundle\UserBundle\Entity\Person $owners)
    {
        $this->owners[] = $owners;

        return $this;
    }

    /**
     * Remove owners
     *
     * @param \Mbates\Bundle\UserBundle\Entity\Person $owners
     */
    public function removeOwner(\Mbates\Bundle\UserBundle\Entity\Person $owners)
    {
        $this->owners->removeElement($owners);
    }

    /**
     * Get owners
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwners()
    {
        return $this->owners;
    }
}
