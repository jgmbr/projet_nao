<?php

namespace NBGraphics\CoreBundle\Services\Email;


use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class EmailRegistrationFormSystem
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendEmail($user)
    {

        $mail = \Swift_Message::newInstance()
            ->setSubject('Nos Amis Les Oiseaux › Confirmation d\'inscription')
            ->setFrom('contact@nos-amis-les-oiseaux.fr')
            // Addresse e-mail à modifier pour celle du président
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    '@NBGraphicsFrontSite/emails/contactFormRegistration.html.twig', [
                        'user' => $user,
                    ]
                ),
                'text/html'
            );


        if ($this->mailer->send($mail))
            return true;
        else
            return false;


    }
}