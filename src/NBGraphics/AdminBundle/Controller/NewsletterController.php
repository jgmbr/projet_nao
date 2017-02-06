<?php

namespace NBGraphics\AdminBundle\Controller;

use NBGraphics\CoreBundle\Entity\Newsletter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Newsletter controller.
 *
 * @Route("newsletter")
 */
class NewsletterController extends Controller
{
    /**
     * Lists all newsletter entities.
     *
     * @Route("/list", name="newsletter_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $newsletters = $em->getRepository('NBGraphicsCoreBundle:Newsletter')->findNewsletters();

        return $this->render('NBGraphicsAdminBundle:Admin/newsletter:index.html.twig', array(
            'newsletters' => $newsletters,
        ));
    }

    /**
     * Export newsletter entities.
     *
     * @Route("/export", name="newsletter_export")
     * @Method("GET")
     */
    public function exportAction()
    {
        $exportWS = $this->get('app.export');

        return $exportWS->export('NBGraphicsCoreBundle:Newsletter', array('id','email'), 'exportAll', 'newsletter');
    }

    /**
     * Deletes a newsletter entity.
     *
     * @Route("/{id}/delete", name="newsletter_delete")
     */
    public function deleteAction(Request $request, Newsletter $newsletter)
    {
        $form = $this->createDeleteForm($newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsletter);
            $em->flush($newsletter);
            $request->getSession()->getFlashBag()->add('success', 'Adresse email supprimée avec succès !');
            return $this->redirectToRoute('newsletter_index');
        }

        return $this->render('NBGraphicsAdminBundle:Admin/newsletter:delete.html.twig', array(
            'newsletter' => $newsletter,
            'delete_form'  => $form->createView(),
        ));

    }

    /**
     * Creates a form to delete a newsletter entity.
     *
     * @param Newsletter $newsletter The newsletter entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Newsletter $newsletter)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('newsletter_delete', array('id' => $newsletter->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
