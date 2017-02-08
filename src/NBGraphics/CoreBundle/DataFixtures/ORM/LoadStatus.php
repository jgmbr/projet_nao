<?php

namespace NBGraphics\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NBGraphics\CoreBundle\Entity\Status;

class LoadStatus implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
        if (!is_object($manager->getRepository(Status::class)->findOneByRole('DEFAULT'))) {
            $status1 = new Status();
            $status1->setName('En attente');
            $status1->setIcon('fa-clock-o');
            $status1->setRole('DEFAULT');
            $manager->persist($status1);
        }

        if (!is_object($manager->getRepository(Status::class)->findOneByRole('VALIDED'))) {
            $status2 = new Status();
            $status2->setName('Validée');
            $status2->setIcon('fa-check');
            $status2->setRole('VALIDED');
            $manager->persist($status2);
        }

        if (!is_object($manager->getRepository(Status::class)->findOneByRole('REFUSED'))) {
            $status3 = new Status();
            $status3->setName('Refusée');
            $status3->setIcon('fa-times');
            $status3->setRole('REFUSED');
            $manager->persist($status3);
        }

		$manager->flush();
	}
	
	public function getOrder()
	{ 
		return 1;
	}
}
