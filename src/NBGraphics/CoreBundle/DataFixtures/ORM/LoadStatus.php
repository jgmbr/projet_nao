<?php

namespace JG\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NBGraphics\CoreBundle\Entity\Status;

class LoadStatus implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
        $status1 = new Status();
        $status1->setName('En attente');
        $status1->setIcon('fa-clock-o');
        $status1->setRole('DEFAULT');
		$manager->persist($status1);

        $status2 = new Status();
        $status2->setName('Validée');
        $status2->setIcon('fa-check');
        $status2->setRole('VALIDED');
        $manager->persist($status2);

        $status3 = new Status();
        $status3->setName('Refusée');
        $status3->setIcon('fa-times');
        $status3->setRole('REFUSED');
        $manager->persist($status3);

		$manager->flush();
	}
	
	public function getOrder()
	{ 
		return 1;
	}
}
