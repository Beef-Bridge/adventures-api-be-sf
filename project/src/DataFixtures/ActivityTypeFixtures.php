<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\ActivityType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ActivityTypeFixtures extends Fixture implements OrderedFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->createActivityType(
                $this->faker->sentence(2),
                $manager
            );
        }

        $manager->flush();
    }

    public function createActivityType(string $name, ObjectManager $manager)
    {
        $activityType = new ActivityType();
        $activityType->setName($name);

        $manager->persist($activityType);

        return $activityType;
    }

    public function getOrder(): int
    {
        return 1;
    }
}
