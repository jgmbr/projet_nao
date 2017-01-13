<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13/01/2017
 * Time: 16:18
 */

namespace NBGraphics\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class isHourTimeValidValidator extends ConstraintValidator
{
    public function validate($hourMinutesAt, Constraint $constraint)
    {
        // On définit les variables pour la date du jour
        $today = new \DateTime(null, new \DateTimeZone('Europe/Paris'));
        $todayTimestamp = $today->getTimestamp();
        $todayDayMonthYearFormat = date('Y-m-d', $todayTimestamp);
        $todayHourFormat = $today->format('H:i:s');

        // On récupère les variables et on les formatte
            // L'heure + minute de l'observation
        $hourMinutesObservationFormat = $hourMinutesAt->format('H:i:s');
            // Le jour de l'observation
        $daySelectedAt = $this->context->getRoot()->get('dateAt')->getData();
        $daySelectedDayMonthYearFormat = $daySelectedAt->format('Y-m-d');

        // On compare le tout
        if (($todayDayMonthYearFormat === $daySelectedDayMonthYearFormat) && ($hourMinutesObservationFormat > $todayHourFormat)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}