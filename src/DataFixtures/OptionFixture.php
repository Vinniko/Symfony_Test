<?php

namespace App\DataFixtures;

use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Traits\WordsGeneratingTrait;

class OptionFixture extends Fixture
{
    use WordsGeneratingTrait;

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 30; $i++){
            $option = new Option();
            $option->setTitle($this->generateWord());
            $manager->persist($option );
        }
        $manager->flush();
    }
}
