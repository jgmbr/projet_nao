<?php

namespace NBGraphics\AdminBundle\Controller;

use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Entity\Status;
use NBGraphics\CoreBundle\Form\ObservationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Observation controller.
 *
 * @Route("my_observation")
 */
class MyObservationController extends Controller
{
    /**
     * Lists all observation entities.
     *
     * @Route("/list", name="my_observation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $observations = $em->getRepository(Observation::class)->findMyObservations($user);

        $deleteForms = array();

        foreach ($observations as $observation) {
            $deleteForms[$observation->getId()] = $this->createDeleteForm($observation)->createView();
        }

        return $this->render('NBGraphicsAdminBundle:Account/observation:index.html.twig', array(
            'observations' => $observations,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Finds and displays a observation entity.
     *
     * @Route("/{id}/show", name="my_observation_show")
     * @Method("GET")
     */
    public function showAction(Observation $observation)
    {
        if (!$observation instanceof Observation)
            throw $this->createNotFoundException("Observation non reconnue");

        $deleteForm = $this->createDeleteForm($observation);

        return $this->render('NBGraphicsAdminBundle:Account/observation:show.html.twig', array(
            'observation' => $observation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing observation entity.
     *
     * @Route("/{id}/edit", name="my_observation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Observation $observation)
    {
        if (!$observation instanceof Observation)
            throw $this->createNotFoundException("Observation non reconnue");

        if ("VALIDED" === $observation->getStatus()->getRole())
            throw $this->createNotFoundException("L'observation n'est pas autorisée à être éditée !");

        $deleteForm = $this->createDeleteForm($observation);
        $editForm = $this->createForm(ObservationFormType::class, $observation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $response = $this->get('app.crud.update')->updateObservation($observation);

            if ($response) {
                $this->addFlash('success', 'Observation modifiée avec succès !');
                return $this->redirectToRoute('my_observation_show', array('id' => $observation->getId()));
            } else {
                $this->addFlash('error', 'Erreur lors de la modification de l\'observation');
                return $this->redirectToRoute('my_observation_edit', array('id' => $observation->getId()));
            }

        }

        return $this->render('NBGraphicsAdminBundle:Account/observation:edit.html.twig', array(
            'observation' => $observation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a observation entity.
     *
     * @Route("/{id}/delete", name="my_observation_delete")
     */
    public function deleteAction(Request $request, Observation $observation)
    {
        if (!$observation instanceof Observation)
            throw $this->createNotFoundException("Observation non reconnue");

        $form = $this->createDeleteForm($observation);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $this->get('app.crud.delete')->deleteObservation($observation, $user);

            if ($response)
                $this->addFlash('success', 'Observation supprimée avec succès !');
            $this->addFlash('error', 'Erreur lors de la suppression de l\'observation !');

            return $this->redirectToRoute('my_observation_index');
        }

        return $this->render('NBGraphicsAdminBundle:Account/observation:delete.html.twig', array(
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
            ->setAction($this->generateUrl('my_observation_delete', array('id' => $observation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
