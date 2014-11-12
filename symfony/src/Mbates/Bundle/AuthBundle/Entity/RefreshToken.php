<?php
namespace Mbates\Bundle\AuthBundle\Entity;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;
use FOS\OAuthServerBundle\Model\ClientInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Rest_RefreshToken")
 */
class RefreshToken extends BaseRefreshToken
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Client")
	 * @ORM\JoinColumn(nullable=false)
	 */
	protected $client;

	/**
	 * @ORM\ManyToOne(targetEntity="Mbates\Bundle\UserBundle\Entity\Person")
	 */
	protected $user;

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
	 * Set client
	 *
	 * @param ClientInterface $client
	 * @return RefreshToken
	 */
	public function setClient(ClientInterface $client)
	{
		$this->client = $client;

		return $this;
	}

	/**
	 * Get client
	 *
	 * @return \Mbates\Bundle\AuthBundle\Entity\Client 
	 */
	public function getClient()
	{
		return $this->client;
	}

	/**
	 * Set user
	 *
	 * @param UserInterface $user
	 * @return RefreshToken
	 */
	public function setUser(UserInterface $user = null)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return \Mbates\Bundle\UserBundle\Entity\Person 
	 */
	public function getUser()
	{
		return $this->user;
	}
}
