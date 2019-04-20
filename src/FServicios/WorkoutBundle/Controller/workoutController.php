<?php

namespace FServicios\WorkoutBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FServicios\WorkoutBundle\Entity\workout;
use FServicios\WorkoutBundle\Form\workoutType;

/**
 * workout controller.
 *
 * @Route("/workout")
 */
class workoutController extends Controller
{

    /**
     * Lists all workout entities.
     *
     * @Route("/", name="workoutcrud")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FServiciosWorkoutBundle:workout')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new workout entity.
     *
     * @Route("/", name="workoutcrud_create")
     * @Method("POST")
     * @Template("FServiciosWorkoutBundle:workout:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new workout();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('workoutcrud_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a workout entity.
     *
     * @param workout $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(workout $entity)
    {
        $form = $this->createForm(new workoutType(), $entity, array(
            'action' => $this->generateUrl('workoutcrud_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new workout entity.
     *
     * @Route("/new", name="workoutcrud_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new workout();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a workout entity.
     *
     * @Route("/{id}", name="workoutcrud_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FServiciosWorkoutBundle:workout')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find workout entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing workout entity.
     *
     * @Route("/{id}/edit", name="workoutcrud_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FServiciosWorkoutBundle:workout')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find workout entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a workout entity.
    *
    * @param workout $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(workout $entity)
    {
        $form = $this->createForm(new workoutType(), $entity, array(
            'action' => $this->generateUrl('workoutcrud_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing workout entity.
     *
     * @Route("/{id}", name="workoutcrud_update")
     * @Method("PUT")
     * @Template("FServiciosWorkoutBundle:workout:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FServiciosWorkoutBundle:workout')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find workout entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('workoutcrud_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a workout entity.
     *
     * @Route("/{id}", name="workoutcrud_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FServiciosWorkoutBundle:workout')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find workout entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('workoutcrud'));
    }

    /**
     * Creates a form to delete a workout entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('workoutcrud_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
