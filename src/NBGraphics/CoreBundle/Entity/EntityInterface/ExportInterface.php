<?php

namespace NBGraphics\CoreBundle\Entity\EntityInterface;

interface ExportInterface
{
    /**
     * @return array
     */
    public function toCsvArray();
}