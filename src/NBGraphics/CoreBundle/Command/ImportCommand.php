<?php

namespace NBGraphics\CoreBundle\Command;

use NBGraphics\CoreBundle\Entity\TAXREF;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('import:taxref')

            // the short description shown while running "php bin/console list"
            ->setDescription('Update TAXREF in database')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to update all TAXREF in database ..")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            '',
            '=====================',
            ' Start import TAXREF ',
            '=====================',
            '',
        ]);

        $now = new \DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        // Importing CSV on DB via Doctrine ORM
        $this->import($input, $output);

        $now = new \DateTime();
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        // outputs a message without adding a "\n" at the end of the line
        $output->writeln('You are about to update TAXREF in database');

        /*if ($response) {
            $output->writeln([
                '',
                'Routes loaded with success !',
                '',
            ]);
        }*/

        $output->writeln([
            '',
            '===================',
            ' End import TAXREF ',
            '===================',
            '',
        ]);
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        // Getting php array of data from CSV
        $data = $this->get($input, $output);

        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($data);
        $batchSize = 100;
        $i = 1;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        // Processing on each row of data
        foreach($data as $row) {

            $taxref = $em->getRepository(TAXREF::class)->findOneByCdNom($row['CD_NOM']);

            // If the taxref doest not exist we create one
            if(!is_object($taxref)){
                $taxref = new TAXREF();
                $taxref->setCdNom($row['CD_NOM']);
            }

            // Updating info
            $taxref->setRegne($row['REGNE']);
            $taxref->setPhylum($row['PHYLUM']);
            $taxref->setClasse($row['CLASSE']);
            $taxref->setOrdre($row['ORDRE']);
            $taxref->setFamille($row['FAMILLE']);
            $taxref->setCdTaxSup($row['CD_TAXSUP']);
            $taxref->setCdRef($row['CD_REF']);
            $taxref->setRang($row['RANG']);
            $taxref->setLbNom($row['LB_NOM']);
            $taxref->setLbAuteur($row['LB_AUTEUR']);
            $taxref->setNomComplet($row['NOM_COMPLET']);
            $taxref->setNomValide($row['NOM_VALIDE']);
            $taxref->setNomVern($row['NOM_VERN']);
            $taxref->setNomVernEng($row['NOM_VERN_ENG']);
            $taxref->setHabitat($row['HABITAT']);

            // Do stuff here !

            // Persisting the current user
            $em->persist($taxref);

            // Each 20 users persisted we flush everything
            if (($i % $batchSize) === 0) {

                $em->flush();
                // Detaches all objects from Doctrine for memory save
                $em->clear();

                // Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of TAXRED imported ... | ' . $now->format('d-m-Y G:i:s'));

            }

            $i++;

        }

        // Flushing and clear data on queue
        $em->flush();
        $em->clear();

        // Ending the progress bar process
        $progress->finish();
    }

    protected function get(InputInterface $input, OutputInterface $output)
    {
        // Getting the CSV from filesystem
        $fileName = 'web/uploads/import/TAXREF.csv';

        // Using service for converting CSV to PHP Array
        $converter = $this->getContainer()->get('app.import.csvtoarray');

        $data = $converter->convert($fileName, ';');

        return $data;
    }

}
