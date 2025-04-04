<?php

namespace Database\Fixtures;

use App\Entities\Article;
use App\Entities\ArticleCategory;
use App\Entities\Blogger;
use App\EntityRepositories\ArticleCategoryRepository;
use App\EntityRepositories\BloggerRepository;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var BloggerRepository $bloggerRepository */
        $bloggerRepository = $manager->getRepository(Blogger::class);
        /** @var ArticleCategoryRepository $categoryRepository */
        $categoryRepository = $manager->getRepository(ArticleCategory::class);
        $faker = (new \Faker\Factory())->create();

        $bloggers = $bloggerRepository->findAll();
        $categories = $categoryRepository->findAll();
        $now = now();

        foreach ($bloggers as $blogger) {
            $articlesCount = random_int(2, 10);
            for ($i = 1; $i <= $articlesCount; ++$i) {
                // TODO: Select only categories assigned to Blogger
                $randomCategory = $categories[array_rand($categories)];

                $article = new Article(
                    blogger: $blogger,
                    title: $faker->text(random_int(20, 100)),
                    content: $faker->randomHtml(2, random_int(2, 7)),
                    category: $randomCategory,
                );

                $article
                    ->setSubtitle($faker->boolean(50) ? $faker->text(random_int(70, 255)) : null)
                    ->setSummary($faker->boolean(70) ? $faker->text(random_int(200, 400)) : null)
                    ->setPublishedAt(
                        $faker->boolean(95)
                            ? $now->subDays(random_int(1, 365))->toDateTimeImmutable()
                            : null
                    );

                $manager->persist($article);
                $manager->flush();
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArticleCategoryFixtures::class,
            BloggerFixtures::class,
        ];
    }
}
