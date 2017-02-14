<?php

namespace NBGraphics\SeoBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class SeoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('seo:load-routes')

            // the short description shown while running "php bin/console list"
            ->setDescription('Load routes for SEO')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to load routes for Seo CRUD ..")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            '',
            '=====================',
            'Start SEO load routes',
            '=====================',
            '',
        ]);

        // outputs a message without adding a "\n" at the end of the line
        $output->writeln('You are about to load routes for SEO');

        $response = $this->getContainer()->get('seo.routes.load')->loadRoutes();

        if ($response) {
            $output->writeln([
                '',
                'Routes loaded with success !',
                '',
            ]);
        }

        $output->writeln([
            '',
            '===================',
            'End SEO load routes',
            '===================',
            '',
        ]);
    }
}
