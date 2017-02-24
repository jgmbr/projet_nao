<?php

namespace NBGraphics\AdminBundle\Controller;

use NBGraphics\CoreBundle\Entity\Newsletter;
use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ExportController extends Controller
{
    /**
     * Export observation entities.
     *
     * @Route("/export/observation", name="observation_export")
     * @Method("GET")
     */
    public function exportObservationAction()
    {
        $exportWS = $this->get('app.export');

        $headers = array('id','Utilisateur','Date Observation','Heure Observation','Quantite','Maturité','Plumage','Nidification','Taxref','Departement','Latitude','Longitude','Commentaire','Statut','Date de creation');

        return $exportWS->export(new Observation(), $headers, 'exportAll', 'observation');
    }

    /**
     * Export newsletter entities.
     *
     * @Route("/export/newsletter", name="newsletter_export")
     * @Method("GET")
     */
    public function exportNewsletterAction()
    {
        $exportWS = $this->get('app.export');

        return $exportWS->export(new Newsletter(), array('email'), 'exportAll', 'newsletter');
    }

    /**
     * @Route("/export/phones", name="user_export_phones")
     */
    public function exportPhonesAction()
    {
        $exportWS = $this->get('app.export');

        return $exportWS->export(new User(), array('phone'), 'exportAllPhoneAllowed', 'sms');
    }


}