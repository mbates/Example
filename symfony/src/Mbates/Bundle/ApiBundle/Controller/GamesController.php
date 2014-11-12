<?php
namespace Mbates\Bundle\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\RouteRedirectView;

use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Mbates\Bundle\GameBundle\Entity\Game;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class GamesController extends FOSRestController
{

    const SESSION_CONTEXT_NOTE = 'games';

    /**
     * Get all Games.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Game for a given id",
     *   output = "Mbates\Bundle\GameBundle\Entity\Game",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the game is not found"
     *   }
     * )
     *
     *
     * @return array
     *
     * @throws NotFoundHttpException when game does not exist
     */
    public function getGamesAction( Request $request )
    {
        if( $request->getRequestFormat() == 'json' and !empty( $request->query->get( 'callback' ) ) )
        {
            $request->setRequestFormat( 'jsonp' );
        }

        $games = $this->container->get( 'mbates_game.game.handler' )
                ->all();

        return $games;
    }

    /**
     * Get single Game.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Game for a given id",
     *   output = "Mbates\Bundle\GameBundle\Entity\Game",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the game is not found"
     *   }
     * )
     *
     * @param int     $id      the game id
     *
     * @return array
     *
     * @throws NotFoundHttpException when game does not exist
     */
    public function getGameAction( Request $request, $id )
    {
        if( $request->getRequestFormat() == 'json' and !empty( $request->query->get( 'callback' ) ) )
        {
            $request->setRequestFormat( 'jsonp' );
        }

        $game = $this->getOr404( $id );

        return $game;
    }

    /**
     * Create a Game from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new game from the submitted data.",
     *   input = "Mbates\Bundle\GameBundle\Form\GameType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Method({"POST"})
     *
     * @param Request $request the request object
     *
     * return Respone $response the response object
     * @return FormTypeInterface|View
     */
    public function postGameAction( Request $request )
    {
        try
        {
            $manager = $this->getDoctrine()->getManager();

            $user = $this->get( 'security.context' )->getToken()->getUser();

            $game = $this->container->get( 'mbates_game.game.handler' )
                ->post( $request->request->all() );

            $encoders = array(new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());
            $serializer = new Serializer($normalizers, $encoders);
            $responseContent = $serializer->serialize(array('id' => $game->getId()), 'json');

            $response = new Response();
            $response->setStatusCode(201);
            $response->setContent($responseContent);

            return $response;

        }
        catch( InvalidFormException $exception )
        {
            return $exception->getForm();
        }
    }

    /**
     * Update existing Game from the submitted data or create a new Game.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Mbates\Bundle\GameBundle\Form\GameType",
     *   statusCodes = {
     *     201 = "Returned when the Game is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the page id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when game does not exist
     */
    public function putGameAction( Request $request, $id )
    {
        try {
            $manager = $this->getDoctrine()->getManager();

            $user = $this->get( 'security.context' )->getToken()->getUser();

            if (!($game = $this->container->get('mbates_game.game.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;

                $game = $this->container->get('mbates_game.game.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;

                $game = $this->container->get('mbates_game.game.handler')->put(
                    $game,
                    $request->request->all()
                );
            }

            $encoders = array(new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());
            $serializer = new Serializer($normalizers, $encoders);
            $responseContent = $serializer->serialize(array('id' => $game->getId()), 'json');

            $response = new Response();
            $response->setStatusCode($statusCode);
            $response->setContent($responseContent);

            return $response;

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing SURGERY from the submitted data
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Incompass\ApiBundle\Form\GameType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the game id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function patchGameAction( Request $request, $id )
    {
        try {
            $user = $this->get( 'security.context' )->getToken()->getUser();

            $statusCode = Codes::HTTP_NO_CONTENT;

            $game = $this->container->get('mbates_game.game.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $encoders = array(new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());
            $serializer = new Serializer($normalizers, $encoders);
            $responseContent = $serializer->serialize(array('id' => $game->getId()), 'json');
            
            $response = new Response();
            $response->setStatusCode($statusCode);
            $response->setContent($responseContent);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Fetch a Game or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return GameInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404( $id )
    {
        if( !( $game = $this->container->get( 'mbates_game.game.handler' )->get( $id ) ) )
        {
            throw new NotFoundHttpException( sprintf( 'The resource \'%s\' was not found.', $id ) );
        }

        return $game;
    }
}