<?php

namespace NBGraphics\AdminBundle\Controller;

use NBGraphics\CoreBundle\Entity\Moderation;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\CoreBundle\Form\ModerationType;
use NBGraphics\CoreBundle\Form\ObservationFormType;
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
     * @Route("/list", name="observation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $observations = $em->getRepository('NBGraphicsCoreBundle:Observation')->findObservations();

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
     * @Route("/waiting", name="observation_waiting")
     * @Method("GET")
     */
    public function waitingAction()
    {
        $em = $this->getDoctrine()->getManager();

        $status = $em->getRepository('NBGraphicsCoreBundle:Status')->findByRole('DEFAULT');

        $observations = $em->getRepository('NBGraphicsCoreBundle:Observation')->findObservationsByStatusAndOrder($status);

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
     * @Route("/valided", name="observation_valided")
     * @Method("GET")
     */
    public function validedAction()
    {
        $em = $this->getDoctrine()->getManager();

        $status = $em->getRepository('NBGraphicsCoreBundle:Status')->findByRole('VALIDED');

        $observations = $em->getRepository('NBGraphicsCoreBundle:Observation')->findObservationsByStatusAndOrder($status);

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
     * @Route("/refused", name="observation_refused")
     * @Method("GET")
     */
    public function refusedAction()
    {
        $em = $this->getDoctrine()->getManager();

        $status = $em->getRepository('NBGraphicsCoreBundle:Status')->findByRole('REFUSED');

        $observations = $em->getRepository('NBGraphicsCoreBundle:Observation')->findObservationsByStatusAndOrder($status);

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
     * @Route("/moderate/{id}", name="observation_moderate")
     * @Method({"GET", "POST"})
     */
    public function moderateAction(Request $request, Observation $observation)
    {
        $deleteForm = $this->createDeleteForm($observation);

        $moderation = new Moderation();

        $moderationForm = $this->createForm(ModerationType::class, $moderation);

        $moderationForm->handleRequest($request);

        $user = $this->getUser();

        if ($moderationForm->isSubmitted() && $moderationForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $observation->setStatus($moderationForm->getData()->getStatus());
            $observation->addModeration($moderation);

            $user->addModeration($moderation);

            $moderation->setObservation($observation);
            $moderation->setUser($user);
            $moderation->setStatus($moderationForm->getData()->getStatus());

            $em->persist($observation);
            $em->persist($moderation);
            $em->flush();

            return $this->redirectToRoute('observation_show', array('id' => $observation->getId()));
        }

        return $this->render('NBGraphicsAdminBundle:Admin/observation:moderate.html.twig', array(
            'observation' => $observation,
            'delete_form' => $deleteForm->createView(),
            'moderation_form' => $moderationForm->createView()
        ));

    }

    /**
     * Export observation entities.
     *
     * @Route("/export", name="observation_export")
     * @Method("GET")
     */
    public function exportAction()
    {
        $exportWS = $this->get('app.export');

        $headers = array('id','Utilisateur','Date Observation','Heure Observation','Quantite','Maturage','Plumage','Nidification','Taxref','Departement','Latitude','Longitude','Commentaire','Statut','Date de creation');

        return $exportWS->export(new Observation(), $headers, 'exportAll', 'observation');
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
