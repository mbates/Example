<?php
namespace Mbates\Bundle\GameBundle\Model;

interface GameInterface
{
    /**
     * Set title
     *
     * @param string $title
     * @return Game
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle();

    /**
     * Set image
     *
     * @param string $image
     * @return Game
     */
    public function setImage($image);

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage();

    /**
     * Set notes
     *
     * @param string $notes
     * @return Game
     */
    public function setNotes($notes);

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes();

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Game
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
     * @return Game
     */
    public function setUpdated($updated);

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated();


    public function setUpdatedValue();

    /**
     * Add owners
     *
     * @param \Mbates\Bundle\UserBundle\Entity\Person $owners
     * @return Game
     */
    public function addOwner(\Mbates\Bundle\UserBundle\Entity\Person $owners);

    /**
     * Remove owners
     *
     * @param \Mbates\Bundle\UserBundle\Entity\Person $owners
     */
    public function removeOwner(\Mbates\Bundle\UserBundle\Entity\Person $owners);

    /**
     * Get owners
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwners();
}
