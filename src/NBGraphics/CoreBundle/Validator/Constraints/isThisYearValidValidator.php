<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13/01/2017
 * Time: 17:03
 */

namespace NBGraphics\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class isThisYearValidValidator extends ConstraintValidator
{
    public function validate($dateAt, Constraint $constraint)
    {
        // On définit les variables pour la date du jour
        $today = new \DateTime(null, new \DateTimeZone('Europe/Paris'));

        // On effectue la différence
        $interval = date_diff($today, $dateAt);
        $yearDifference = $interval->format('%y');

        // On effectue la vérif
        if ($yearDifference >= 1) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}