<?php

namespace NBGraphics\AdminBundle\Controller;

use NBGraphics\CoreBundle\Entity\Moderation;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Entity\Status;
use NBGraphics\CoreBundle\Form\ModerationType;
use NBGraphics\CoreBundle\Form\ObservationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Observation controller.
 *
 * @Route("observations")
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

        $observations = $em->getRepository(Observation::class)->findObservations();

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
     * Lists all observation waiting entities.
     *
     * @Route("/en-attente", name="observation_waiting")
     * @Method("GET")
     */
    public function waitingAction()
    {
        $em = $this->getDoctrine()->getManager();

        $status = $em->getRepository(Status::class)->findByRole('DEFAULT');

        $observations = $em->getRepository(Observation::class)->findObservationsByStatusAndOrder($status);

        $deleteForms = array();

        foreach ($observations as $observation) {
            $deleteForms[$observation->getId()] = $this->createDeleteForm($observation)->createView();
        }

        return $this->render('NBGraphicsAdminBundle:Admin/observation:waiting.html.twig', array(
            'observations' => $observations,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Lists all observation valided entities.
     *
     * @Route("/validees", name="observation_valided")
     * @Method("GET")
     */
    public function validedAction()
    {
        $em = $this->getDoctrine()->getManager();

        $status = $em->getRepository(Status::class)->findByRole('VALIDED');

        $observations = $em->getRepository(Observation::class)->findObservationsByStatusAndOrder($status);

        $deleteForms = array();

        foreach ($observations as $observation) {
            $deleteForms[$observation->getId()] = $this->createDeleteForm($observation)->createView();
        }

        return $this->render('NBGraphicsAdminBundle:Admin/observation:valided.html.twig', array(
            'observations' => $observations,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Lists all observation refused entities.
     *
     * @Route("/refusees", name="observation_refused")
     * @Method("GET")
     */
    public function refusedAction()
    {
        $em = $this->getDoctrine()->getManager();

        $status = $em->getRepository(Status::class)->findByRole('REFUSED');

        $observations = $em->getRepository(Observation::class)->findObservationsByStatusAndOrder($status);

        $deleteForms = array();

        foreach ($observations as $observation) {
            $deleteForms[$observation->getId()] = $this->createDeleteForm($observation)->createView();
        }

        return $this->render('NBGraphicsAdminBundle:Admin/observation:refused.html.twig', array(
            'observations' => $observations,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * Moderation observation.
     *
     * @Route("/moderation/{id}", name="observation_moderate")
     * @Method({"GET", "POST"})
     */
    public function moderateAction(Request $request, Observation $observation)
    {
        if (!$observation instanceof Observation)
            throw $this->createNotFoundException("Observation non reconnue");

        $deleteForm = $this->createDeleteForm($observation);

        $moderation = new Moderation();

        $moderationForm = $this->createForm(ModerationType::class, $moderation);

        $moderationForm->handleRequest($request);

        $user = $this->getUser();

        if ($moderationForm->isSubmitted() && $moderationForm->isValid()) {

            $response = $this->get('app.crud.update')->moderateObservation($observation, $user, $moderation, $moderationForm->getData()->getStatus());

            if ($response) {
                $this->addFlash('success','Observationn modérée avec succès !');
                return $this->redirectToRoute('observation_show', array('id' => $observation->getId()));
            } else {
                $this->addFlash('error','Erreur lors de la modération de l\'observation');
                return $this->redirectToRoute('observation_moderate', array('id' => $observation->getId()));
            }
        }

        return $this->render('NBGraphicsAdminBundle:Admin/observation:moderate.html.twig', array(
            'observation' => $observation,
            'delete_form' => $deleteForm->createView(),
            'moderation_form' => $moderationForm->createView()
        ));

    }

    /**
     * Finds and displays a observation entity.
     *
     * @Route("/fiche/{id}", name="observation_show")
     * @Method("GET")
     */
    public function showAction(Observation $observation)
    {
        if (!$observation instanceof Observation)
            throw $this->createNotFoundException("Observation non reconnue");

        $deleteForm = $this->createDeleteForm($observation);

        return $this->render('NBGraphicsAdminBundle:Admin/observation:show.html.twig', array(
            'observation' => $observation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing observation entity.
     *
     * @Route("/edition/{id}", name="observation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Observation $observation)
    {
        if (!$observation instanceof Observation)
            throw $this->createNotFoundException("Observation non reconnue");

        $deleteForm = $this->createDeleteForm($observation);
        $editForm = $this->createForm(ObservationFormType::class, $observation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $response = $this->get('app.crud.update')->updateObservation($observation);

            if ($response) {
                $this->addFlash('success', 'Observation modifiée avec succès !');
                return $this->redirectToRoute('observation_show', array('id' => $observation->getId()));
            } else {
                $this->addFlash('error', 'Erreur lors de la modification de l\'observation');
                return $this->redirectToRoute('observation_edit', array('id' => $observation->getId()));
            }

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
     * @Route("/suppression/{id}", name="observation_delete")
     */
    public function deleteAction(Request $request, Observation $observation)
    {
        if (!$observation instanceof Observation)
            throw $this->createNotFoundException("Observation non reconnue");

        $form = $this->createDeleteForm($observation);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $deleteObservation = $this->get('app.crud.delete')->deleteObservation($observation, $user);

            if ($deleteObservation)
                $this->addFlash('success', 'Observation supprimée avec succès !');
            else
                $this->addFlash('error', 'Erreur lors de la suppression de l\'observation !');

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
