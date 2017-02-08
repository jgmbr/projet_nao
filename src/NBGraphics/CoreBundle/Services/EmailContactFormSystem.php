<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 08/02/2017
 * Time: 18:55
 */

namespace NBGraphics\CoreBundle\Services;


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

        $mail = \Swift_Message::newInstance()
            ->setSubject('Nos Amis Les Oiseaux : nouveau message')
            ->setFrom('messagerie@nao.fr')
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


    }
}