<?php

namespace App\DataFixtures;

use App\Entity\ProductOption;
use App\Repository\OptionRepository;
use App\Repository\ProductRepository;
use App\Traits\WordsGeneratingTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductOptionFixture extends Fixture
{
    use WordsGeneratingTrait;

    private $_productRepository;
    private $_optionRepository;

    public function __construct(ProductRepository $productRepository, OptionRepository $optionRepository)
    {
        $this->_productRepository = $productRepository;
        $this->_optionRepository = $optionRepository;
    }

    public function load(ObjectManager $manager)
    {
        $qb = $this->_productRepository->createQueryBuilder('p')
            ->select('count(p.id)');
        $products_count = $qb->getQuery()->getSingleScalarResult();
        $qb = $this->_optionRepository->createQueryBuilder('o')
            ->select('count(o.id)');
        $options_count = $qb->getQuery()->getSingleScalarResult();
        $products = $this->_productRepository->findAll();
        $options = $this->_optionRepository->findAll();
        for($i = 0; $i < 30; $i++){
            $productOption = new ProductOption();
            $productOption->setProductId($products[rand(0, $products_count - 1)]);
            $productOption->setOptionId($options[rand(0, $options_count - 1)]);
            $productOption->setValue(rand(1, 333));
            $manager->persist($productOption);
        }

        $manager->flush();
    }
}
