<?php
namespace Mbates\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Mbates\Bundle\UserBundle\Entity\Person;
use Mbates\Bundle\UserBundle\Form\PersonType;

class PeopleController extends Controller
{
    /**
     * Lists all People.
     *
     * @Route("/", name="person_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $page = array( 'title' => 'People' );

        $manager = $this->getDoctrine()->getManager();
        $people = $manager->getRepository('MbatesUserBundle:Person')->findAllPaginator();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $people,
            $this->get('request')->query->get('page', 1),
            5
        );

        return compact('page', 'pagination');
    }

    /**
     * Creates a new Person.
     *
     * @Route("/", name="person_create")
     * @Method("POST")
     * @Template("MbatesAdminBundle:Person:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $page = array( 'title' => 'Add Person' );

        $person = new Person();
        $form = $this->createCreateForm($person);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            return $this->redirect($this->generateUrl('person_show', array('id' => $person->getId())));
        }

        return compact('page', 'person', 'form');
    }

    /**
     * Creates a form to create a Person.
     *
     * @param Person $person Person entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Person $person)
    {
        $form = $this->createForm(new PersonType(), $person, array(
            'action' => $this->generateUrl('person_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Person.
     *
     * @Route("/new", name="person_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $page = array( 'title' => 'Add Person' );

        $person = new Person();
        $form   = $this->createCreateForm($person);

        return compact('page', 'person', 'form');
    }

    /**
     * Finds and displays a Person.
     *
     * @Route("/{id}", name="person_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $page = array( 'title' => 'View Person' );

        $em = $this->getDoctrine()->getManager();

        $person = $em->getRepository('MbatesUserBundle:Person')->find($id);

        if (!$person) {
            throw $this->createNotFoundException('Unable to find Person.');
        }

        return compact('page', 'person');
    }

    /**
     * Displays a form to edit an existing Person.
     *
     * @Route("/{id}/edit", name="person_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $page = array( 'title' => 'Edit Person' );

        $em = $this->getDoctrine()->getManager();

        $person = $em->getRepository('MbatesUserBundle:Person')->find($id);

        if (!$person) {
            throw $this->createNotFoundException('Unable to find Person.');
        }

        $edit_form = $this->createEditForm($person)->createView();

        return compact('page', 'person', 'edit_form');
    }

    /**
     * Creates a form to edit a Person.
     *
     * @param Person $person Person entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Person $person)
    {
        $form = $this->createForm(new PersonType(), $person, array(
            'action' => $this->generateUrl('person_update', array('id' => $person->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Person.
     *
     * @Route("/{id}", name="person_update")
     * @Method("PUT")
     * @Template("MbatesAdminBundle:Person:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $page = array( 'title' => 'Update Person' );

        $em = $this->getDoctrine()->getManager();

        $person = $em->getRepository('MbatesUserBundle:Person')->find($id);

        if (!$person) {
            throw $this->createNotFoundException('Unable to find Person.');
        }

        $editForm = $this->createEditForm($person);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('person_edit', array('id' => $id)));
        }

        return compact('page', 'person', 'edit_form');
    }
}
