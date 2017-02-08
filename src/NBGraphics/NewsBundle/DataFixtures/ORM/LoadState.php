<?php

namespace NBGraphics\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NBGraphics\NewsBundle\Entity\State;

class LoadState implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
        if (!is_object($manager->getRepository(State::class)->findOneByRole('DEFAULT'))) {
            $status1 = new State();
            $status1->setName('Brouillon');
            $status1->setRole('DEFAULT');
            $manager->persist($status1);
        }

        if (!is_object($manager->getRepository(State::class)->findOneByRole('PUBLISH'))) {
            $status2 = new State();
            $status2->setName('Publié');
            $status2->setRole('PUBLISH');
            $manager->persist($status2);
        }

		$manager->flush();
	}
	
	public function getOrder()
	{ 
		return 1;
	}
}
