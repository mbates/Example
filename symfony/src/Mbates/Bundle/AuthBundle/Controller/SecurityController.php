<?php
namespace Mbates\Bundle\AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
	/**
	 * @Route("/login")
	 *
	 * @param Request $request the request object
	 */
	public function loginAction(Request $request)
	{
		$session = $request->getSession();

		$error = '';
		if( $request->attributes->has( SecurityContext::AUTHENTICATION_ERROR ) )
		{
			$error = $request->attributes->get( SecurityContext::AUTHENTICATION_ERROR );
		}
		elseif( null !== $session && $session->has( SecurityContext::AUTHENTICATION_ERROR ) )
		{
			$error = $session->get( SecurityContext::AUTHENTICATION_ERROR );
			$session->remove( SecurityContext::AUTHENTICATION_ERROR );
		}

		if( !empty( $error ) )
		{
			$error = $error->getMessage(); // WARNING! Symfony source code identifies this line as a potential security threat.
		}

		$lastUsername = ( null === $session ) ? '' : $session->get( SecurityContext::LAST_USERNAME );

		return $this->render(
			'MbatesAuthBundle:Security:login.html.twig',
			array(
				'last_username' => $lastUsername,
				'error' => $error,
			)
		);
	}


	/**
	 * @param Request $request the request object
	 */
	public function loginCheckAction( Request $request )
	{

	}
}