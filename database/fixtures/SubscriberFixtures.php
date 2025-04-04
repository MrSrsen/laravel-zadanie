<?php

namespace Database\Fixtures;

use App\Entities\Subscriber;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Provider\Person;

class SubscriberFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = (new \Faker\Factory())->create();
        $now = now();

        $assignedEmails = [];

        // For testing
        $staticSubscriber = new Subscriber(
            firstName: 'Static',
            lastName: 'Subscriber',
            email: 'static.subscriber@example.com',
        );
        $manager->persist($staticSubscriber);
        $assignedEmails[] = $staticSubscriber->getEmail();

        for ($i = 0; $i < 100; ++$i) {
            $gender = $faker->boolean() ? Person::GENDER_MALE : Person::GENDER_FEMALE;

            do {
                $email = $faker->email(); // avoid unique collisions
            } while (\in_array($email, $assignedEmails, true));
            $assignedEmails[] = $email;

            $subscriber = new Subscriber(
                firstName: $faker->firstName($gender),
                lastName: $faker->lastName($gender),
                email: $email,
            );

            if ($faker->boolean(2)) {
                // Generate some deleted subscribers
                $subscriber->setDeletedAt($now->subDays(random_int(10, 365))->toDateTimeImmutable());
            }

            $manager->persist($subscriber);
        }

        $manager->flush();
    }
}
