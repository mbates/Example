<?php
namespace Mbates\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\GroupableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Mbates\Bundle\UserBundle\Model\PersonInterface;

/**
 * @ORM\Entity(repositoryClass="Mbates\Bundle\UserBundle\Entity\Repository\PersonRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Person extends BaseUser implements PersonInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Mbates\Bundle\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="PersonPersonType",
     *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @ORM\ManyToMany(targetEntity="Mbates\Bundle\GameBundle\Entity\Game", inversedBy="owners")
     * @ORM\JoinTable(name="GamesOwned",
     *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="game_id", referencedColumnName="id")}
     * )
     */
    protected $games;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     */
    protected $given_name;

    /**
     * @ORM\Column(type="string")
     */
    protected $family_name;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->games = new \Doctrine\Common\Collections\ArrayCollection();

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
     * Set created
     *
     * @param \DateTime $created
     * @return Person
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
     * @return Person
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
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
     * Add games
     *
     * @param \Mbates\Bundle\GameBundle\Entity\Game $games
     * @return Person
     */
    public function addGame(\Mbates\Bundle\GameBundle\Entity\Game $games)
    {
        $this->games[] = $games;

        return $this;
    }

    /**
     * Remove games
     *
     * @param \Mbates\Bundle\GameBundle\Entity\Game $games
     */
    public function removeGame(\Mbates\Bundle\GameBundle\Entity\Game $games)
    {
        $this->games->removeElement($games);
    }

    /**
     * Get games
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Person
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
     * Set given_name
     *
     * @param string $givenName
     * @return Person
     */
    public function setGivenName($givenName)
    {
        $this->given_name = $givenName;

        return $this;
    }

    /**
     * Get given_name
     *
     * @return string 
     */
    public function getGivenName()
    {
        return $this->given_name;
    }

    /**
     * Set family_name
     *
     * @param string $familyName
     * @return Person
     */
    public function setFamilyName($familyName)
    {
        $this->family_name = $familyName;

        return $this;
    }

    /**
     * Get family_name
     *
     * @return string 
     */
    public function getFamilyName()
    {
        return $this->family_name;
    }

    /**
     * Get full name
     *
     * @return string 
     */
    public function getFullName()
    {
        return $this->given_name . ' ' . $this->family_name;
    }

    /**
     * Set phone
     *
     * @param mixed $phone
     * @return Person
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
