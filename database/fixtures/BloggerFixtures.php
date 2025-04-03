<?php

namespace Database\Fixtures;

use App\Entities\Blogger;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Illuminate\Support\Facades\Hash;

class BloggerFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $techBro = new Blogger(
            'TechBro',
            'tech.bro@example.com',
            Hash::make('pass123'),
        );
        $manager->persist($techBro);

        $jozko = new Blogger(
            'Jožko Mrkvička',
            'jozko.mrkvicka@example.sk',
            Hash::make('mrkvicka'),
        );
        $manager->persist($jozko);

        $manager->flush();
    }
}
