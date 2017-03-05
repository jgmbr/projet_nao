<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 08/02/2017
 * Time: 18:55
 */

namespace NBGraphics\CoreBundle\Services\Email;


use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class EmailContactFormSystem
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendEmail($messageData)
    {
        if (!$messageData)
            return false;

        $emailAddress = $messageData['emailAddress'];

        $mail = \Swift_Message::newInstance()
            ->setSubject('Nos Amis Les Oiseaux › Nouveau message')
            ->setFrom('nao@boudetnature.com')
            // Addresse e-mail à modifier pour celle du président
            ->setTo('Thomas.dimnet@gmail.com')
            ->setBody(
                $this->templating->render(
                    '@NBGraphicsFrontSite/emails/contactFormEmail.html.twig', [
                        'message' => $messageData,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($mail);

        $mailUser = \Swift_Message::newInstance()
            ->setSubject('Nos Amis Les Oiseaux › Confirmation demande de contact')
            ->setFrom('nao@boudetnature.com')
            ->setTo($emailAddress)
            ->setBody(
                $this->templating->render(
                    '@NBGraphicsFrontSite/emails/contactFormEmailCopie.html.twig', [
                        'message' => $messageData,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($mailUser);

        return true;
    }
}