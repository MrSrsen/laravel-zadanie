<?php

namespace Database\Fixtures;

use App\Entities\ArticleCategory;
use App\Entities\Blogger;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Illuminate\Support\Facades\Hash;

class BloggerFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public const TECH_BRO_EMAIL = 'tech.bro@example.com';

    public const JOZKO_MRKVICKA_EMAIL = 'jozko.mrkvicka@example.sk';

    public function load(ObjectManager $manager): void
    {
        $articleCategoryRepository = $manager->getRepository(ArticleCategory::class);

        $technology = $articleCategoryRepository->findOneBy(['title' => ArticleCategoryFixtures::TECHNOLOGY]);
        $lifestyle = $articleCategoryRepository->findOneBy(['title' => ArticleCategoryFixtures::LIFESTYLE]);
        $travel = $articleCategoryRepository->findOneBy(['title' => ArticleCategoryFixtures::TRAVEL]);
        $food = $articleCategoryRepository->findOneBy(['title' => ArticleCategoryFixtures::FOOD]);
        $history = $articleCategoryRepository->findOneBy(['title' => ArticleCategoryFixtures::HISTORY]);

        $techBro = new Blogger(
            title: 'TechBro',
            email: self::TECH_BRO_EMAIL,
            password: Hash::make('pass123'),
        );
        $techBro
            ->addArticleCategory($technology)
            ->addArticleCategory($lifestyle);
        $manager->persist($techBro);

        $jozko = new Blogger(
            title: 'Jožko Mrkvička',
            email: self::JOZKO_MRKVICKA_EMAIL,
            password: Hash::make('mrkvicka'),
        );
        $jozko
            ->addArticleCategory($travel)
            ->addArticleCategory($food)
            ->addArticleCategory($history);
        $manager->persist($jozko);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArticleCategoryFixtures::class,
        ];
    }
}
