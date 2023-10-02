<?php

namespace App\DataFixtures;

use App\Entity\ContractType;
use App\Entity\Department;
use App\Entity\Sector;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const CONTRACT_TYPES = ["CDI","CDD","Intérim"];

    private const SECTORS = ["RH", "Informatique", "Comptabilité", "Direction"];

    private const NB_EMPLOYEES = 5;

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $contractTypes = [];
   
        foreach (self::CONTRACT_TYPES as $contractTypeName) {
          $contractType = new ContractType;
          $contractType->setTitle($contractTypeName);
          $manager->persist($contractType);
          $contractTypes[] = $contractType;
        }

        $sectors = [];
        
        foreach (self::SECTORS as $sectorName) {
            $sector = new Sector;
            $sector->setTitle($sectorName);
            $manager->persist($sector);
            $sectors[] = $sector;
        }

        $admin = new User();
        $admin
        ->setEmail('rh@hb.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($this->hasher->hashPassword($admin, 'azerty123'))
        ->setFirstname('Jean')
        ->setLastname('Admin')
        ->setPicture('https://static.nationalgeographic.fr/files/styles/image_3200/public/75552.ngsversion.1422285553360.jpg?w=1600&h=900')
        ->setContractType($faker->randomElement($contractTypes))
        ->setSector($faker->randomElement($sectors))
        ->setEndDate($faker->dateTimeBetween('now', '+2 years'));

        $manager->persist($admin);

        for ($i = 0; $i < self::NB_EMPLOYEES; $i++) {
        $user = new User();
        $user
        ->setEmail($faker->email())
        ->setPassword($this->hasher->hashPassword($user, 'test'))
        ->setFirstname($faker->firstName())
        ->setLastname($faker->lastName())
        ->setPicture($faker->imageUrl())
        ->setRoles(['ROLE_USER'])
        ->setContractType($faker->randomElement($contractTypes))
        ->setSector($faker->randomElement($sectors))
        ->setEndDate($faker->dateTimeBetween('now', '+2 years'));
        
        $manager->persist($user);}

        $manager->flush();
    }
}