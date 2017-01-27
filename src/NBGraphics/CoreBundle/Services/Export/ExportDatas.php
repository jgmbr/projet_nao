<?php

namespace NBGraphics\CoreBundle\Services\Export;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ExportDatas
{
    /**
    * @var EntityManagerInterface
    */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function export($entity, $headers, $query = null, $file, $method = "toArray")
    {
        $delimiter = ";";

        $iterableResult = $this->em->getRepository($entity)->$query();

        $handle = fopen('php://memory', 'r+');

        fputcsv($handle, $headers, $delimiter);

        while (false !== ($row = $iterableResult->next())) {
            fputcsv($handle, $row[0]->$method(), $delimiter);
            $this->em->detach($row[0]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return new Response($content, 200, array(
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="export-'.$file.'-'.date('YmdHis').'.csv"'
        ));

    }
}
