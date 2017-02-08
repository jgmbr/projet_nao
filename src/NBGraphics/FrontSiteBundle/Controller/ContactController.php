<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/01/2017
 * Time: 19:53
 */

namespace NBGraphics\FrontSiteBundle\Controller;

use NBGraphics\CoreBundle\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact-us", name="nb_graphics_front_site_contactform")
     */
    public function contactFormAction(Request $request)
    {
        $contactForm = $this->createForm(ContactFormType::class);

        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $data = $contactForm->getData();
            $mail = $this->get('email.contact.form');
            $mail->sendEmail($data);
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('nb_graphics_front_site_homepage');
        }

        return $this->render('@NBGraphicsFrontSite/Contact/contactForm.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}