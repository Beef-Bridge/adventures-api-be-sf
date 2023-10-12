<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Activity;
use App\Entity\ActivityType;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ActivityFixtures extends Fixture implements OrderedFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $listActivityType = $manager->getRepository(ActivityType::class)->findAll();

        for ($i = 0; $i < 20; $i++) {
            $this->createActivity(
                $this->faker->sentence(4),
                $this->faker->slug(4),
                $this->faker->paragraph,
                $listActivityType[array_rand($listActivityType)],
                $manager
            );
        }

        $manager->flush();
    }

    public function createActivity(
        string $name,
        string $slug,
        string $description,
        ActivityType $activityType,
        ObjectManager $manager
    ) {
        $date = DateTimeImmutable::createFromMutable(
            $this->faker->dateTimeBetween('-1 months')
        );

        $activity = new Activity();
        $activity->setName($name);
        $activity->setSlug($slug);
        $activity->setDescription($description);
        $activity->setCarriedOut($date);
        $activity->setActivityTypeId($activityType);

        $manager->persist($activity);

        return $activity;
    }

    public function getOrder(): int
    {
        return 2;
    }
}
