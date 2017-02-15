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

        $header = array(
            'REGNE','PHYLUM','CLASSE','ORDRE','FAMILLE','CD_NOM','CD_TAXSUP','CD_REF','RANG','LB_NOM','LB_AUTEUR','NOM_COMPLET','NOM_VALIDE','NOM_VERN','NOM_VERN_ENG','HABITAT','FR','GF','MAR','GUA','SM','SB','SPM','MAY','EPA','REU','TAAF','NC','WF','PF','CLI','APHIA_ID'
        );
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
