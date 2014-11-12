<?php
namespace Mbates\Bundle\AuthBundle\Controller;

use FOS\OAuthServerBundle\Controller\TokenController as BaseTokenController;
use Symfony\Component\HttpFoundation\Request;
use OAuth2\OAuth2;
use OAuth2\OAuth2ServerException;

class TokenController extends BaseTokenController
{
    /**
     * @var OAuth2
     */
    protected $server;

    /**
     * @param OAuth2 $server
     */
    public function __construct(OAuth2 $server)
    {
        $this->server = $server;
    }

    /**
     * @param Request $request
     * @return type
     */
    public function tokenAction( Request $request )
    {
        try
        {
            if( !empty( $request->query->get( 'callback' ) ) )
            {
                $response = $this->server->grantAccessToken( $request );

                $response->setContent( sprintf( '%s(%s)', $request->query->get( 'callback' ), $response->getContent() ) );

                return $response;
            }
            else
            {
                return $this->server->grantAccessToken( $request );
            }
        }
        catch( OAuth2ServerException $e )
        {
            return $e->getHttpResponse();
        }
    }
}
