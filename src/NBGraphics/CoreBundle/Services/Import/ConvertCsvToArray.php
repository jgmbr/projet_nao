<?php

namespace NBGraphics\CoreBundle\Services\Import;

use Doctrine\ORM\EntityManagerInterface;
use NBGraphics\CoreBundle\Entity\EntityInterface\ExportInterface;
use Symfony\Component\HttpFoundation\Response;

class ConvertCsvToArray
{
    public function __construct()
    {
        //
    }

    public function convert($filename, $delimiter = ',')
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = NULL;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if(!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
}
