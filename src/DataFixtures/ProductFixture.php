<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Traits\WordsGeneratingTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    use WordsGeneratingTrait;


    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 30; $i++){
            $product = new Product();
            $product->setTitle($this->generateWord());
            $product->setPrice(rand(1, 333));
            $product->setQty(rand(1, 333));
            $manager->persist($product);
        }
        $manager->flush();
    }
}
