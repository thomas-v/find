<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\TypeContact;

class TypeContactFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $type = new TypeContact();
        $type->setName('Téléphonique');
        $manager->persist($type);
        
        $type = new TypeContact();
        $type->setName('Email');
        $manager->persist($type);
        
        $type = new TypeContact();
        $type->setName('Visio');
        $manager->persist($type);
        
        $type = new TypeContact();
        $type->setName('Entretient');
        $manager->persist($type);
        
        $manager->flush();
        
    }
}
