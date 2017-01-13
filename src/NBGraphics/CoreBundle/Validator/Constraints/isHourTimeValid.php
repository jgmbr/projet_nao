<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13/01/2017
 * Time: 16:17
 */

namespace NBGraphics\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class isHourTimeValid extends Constraint
{
    public $message = "Vous ne pouvez pas effectuer une observation ultérieure à l'heure actuelle.";
}