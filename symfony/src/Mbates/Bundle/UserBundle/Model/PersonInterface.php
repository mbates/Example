<?php
namespace Mbates\Bundle\UserBundle\Model;

interface PersonInterface
{
   /**
     * Set created
     *
     * @param \DateTime $created
     * @return Person
     */
    public function setCreated($created);

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated();

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Person
     */
    public function setUpdated($updated);

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue();

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated();

    /**
     * Add games
     *
     * @param \Mbates\Bundle\GameBundle\Entity\Game $games
     * @return Person
     */
    public function addGame(\Mbates\Bundle\GameBundle\Entity\Game $games);

    /**
     * Remove games
     *
     * @param \Mbates\Bundle\GameBundle\Entity\Game $games
     */
    public function removeGame(\Mbates\Bundle\GameBundle\Entity\Game $games);

    /**
     * Get games
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGames();

    /**
     * Set title
     *
     * @param string $title
     * @return Person
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle();

    /**
     * Set given_name
     *
     * @param string $givenName
     * @return Person
     */
    public function setGivenName($givenName);

    /**
     * Get given_name
     *
     * @return string 
     */
    public function getGivenName();

    /**
     * Set family_name
     *
     * @param string $familyName
     * @return Person
     */
    public function setFamilyName($familyName);

    /**
     * Get family_name
     *
     * @return string 
     */
    public function getFamilyName();

    /**
     * Get full name
     *
     * @return string 
     */
    public function getFullName();

    /**
     * Set phone
     *
     * @param mixed $phone
     * @return Person
     */
    public function setPhone($phone);

    /**
     * Get phone
     * @return string
     */
    public function getPhone();
}
