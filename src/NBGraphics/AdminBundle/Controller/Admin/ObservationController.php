<?php

namespace NBGraphics\AdminBundle\Controller\Admin;

use NBGraphics\CoreBundle\Entity\Observation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Observation controller.
 *
 * @Route("observation")
 */
class ObservationController extends Controller
{
    /**
     * Lists all observation entities.
     *
     * @Route("/", name="observation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $observations = $em->getRepository('NBGraphicsCoreBundle:Observation')->findAll();

        $deleteForms = array();

        foreach ($observations as $observation) {
            $deleteForms[$observation->getId()] = $this->createDeleteForm($observation)->createView();
        }

        return $this->render('NBGraphicsAdminBundle:Admin/observation:index.html.twig', array(
            'observations' => $observations,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Creates a new observation entity.
     *
     * @Route("/new", name="observation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $observation = new Observation();
        $form = $this->createForm('NBGraphics\CoreBundle\Form\ObservationFormType', $observation);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $observation->setUser($user);
            $observation->setStatus('En attente');
            $observation->setPublic(true);
            $user->addObservation($observation);

            $em->persist($observation);
            $em->flush($observation);

            return $this->redirectToRoute('observation_show', array('id' => $observation->getId()));
        }

        return $this->render('NBGraphicsAdminBundle:Admin/observation:new.html.twig', array(
            'observation' => $observation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a observation entity.
     *
     * @Route("/{id}", name="observation_show")
     * @Method("GET")
     */
    public function showAction(Observation $observation)
    {
        $deleteForm = $this->createDeleteForm($observation);

        return $this->render('NBGraphicsAdminBundle:Admin/observation:show.html.twig', array(
            'observation' => $observation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing observation entity.
     *
     * @Route("/{id}/edit", name="observation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Observation $observation)
    {
        $deleteForm = $this->createDeleteForm($observation);
        $editForm = $this->createForm('NBGraphics\CoreBundle\Form\ObservationFormType', $observation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('observation_show', array('id' => $observation->getId()));
        }

        return $this->render('NBGraphicsAdminBundle:Admin/observation:edit.html.twig', array(
            'observation' => $observation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a observation entity.
     *
     * @Route("/{id}/delete", name="observation_delete")
     */
    public function deleteAction(Request $request, Observation $observation)
    {
        $form = $this->createDeleteForm($observation);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->removeObservation($observation);
            $em->remove($observation);
            $em->flush($observation);
            $request->getSession()->getFlashBag()->add('success', 'Observation supprimée avec succès !');
            return $this->redirectToRoute('observation_index');
        }

        return $this->render('NBGraphicsAdminBundle:Admin/observation:delete.html.twig', array(
            'observation' => $observation,
            'delete_form'  => $form->createView(),
        ));

    }

    /**
     * Creates a form to delete a observation entity.
     *
     * @param Observation $observation The observation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Observation $observation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('observation_delete', array('id' => $observation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
