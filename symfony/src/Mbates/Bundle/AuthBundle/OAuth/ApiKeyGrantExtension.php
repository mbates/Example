<?php
namespace Mbates\Bundle\AuthBundle\OAuth;

use Mbates\Bundle\UserBundle\Security\UserProvider;
use FOS\OAuthServerBundle\Storage\GrantExtensionInterface;
use OAuth2\Model\IOAuth2Client;

class ApiKeyGrantExtension implements GrantExtensionInterface
{
	protected $userManager = null;

	public function __construct( UserProvider $userManager )
	{
	    $this->userManager = $userManager;
	}

	/**
	 * {@inheritdoc}
	 */
	public function checkGrantExtension( IOAuth2Client $client, array $inputData, array $authHeaders )
	{
		$user = $this->userManager->findUserByApiKey( $inputData[ 'api_key' ] );

		if( $user )
		{
			// Return access token with associated user
			return array(
				'data' => $user
			);

			// Return an anonymous user token
			return true;
		}

		return false;
	}
}