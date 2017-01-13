<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 13/01/2017
 * Time: 17:11
 */

namespace NBGraphics\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class isThisYearValid extends Constraint
{
    public $message = "Vous ne pouvez pas effectuer une observation datant de plus d'un an.";
}