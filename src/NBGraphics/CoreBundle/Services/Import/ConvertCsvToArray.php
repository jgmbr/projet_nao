<?php

namespace NBGraphics\CoreBundle\Services\Import;

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
