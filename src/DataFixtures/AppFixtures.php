<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0;$i<10;$i++){
            $contact = new Contact();
            $contact->setFullName($this->faker->name())
                    ->setEmail($this->faker->email())
                    ->setSubject('Demande de renseignement n° ' . $i)
                    ->setMessage($this->faker->text());
            $manager->persist($contact);
        }
        $manager->flush();
    }
}
