<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Traits\WordsGeneratingTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    use WordsGeneratingTrait;

    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setFirstName($this->generateWord());
            $user->setSecondName($this->generateWord());
            $user->setEmail($this->generateWord() . "@gmail.com");
            $user->setUsername($this->generateWord());
            $user->setPassword($this->encoder->hashPassword(
                $user,
                '123'
            ));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
