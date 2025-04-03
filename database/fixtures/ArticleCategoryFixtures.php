<?php

namespace Database\Fixtures;

use App\Entities\ArticleCategory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class ArticleCategoryFixtures extends AbstractFixture
{
    public const TECHNOLOGY = 'Technology';
    public const POLITICS = 'Politics';
    public const BUSINESS = 'Business';
    public const ENTERTAINMENT = 'Entertainment';
    public const SPORTS = 'Sports';
    public const TRAVEL = 'Travel';
    public const FOOD = 'Food';
    public const LIFESTYLE = 'Lifestyle';
    public const FINANCE = 'Finance';
    public const HISTORY = 'History';
    public const FASHION = 'Fashion';

    public function load(ObjectManager $manager): void
    {
        $categories = [
            self::TECHNOLOGY,
            self::POLITICS,
            self::BUSINESS,
            self::ENTERTAINMENT,
            self::SPORTS,
            self::TRAVEL,
            self::FOOD,
            self::LIFESTYLE,
            self::FINANCE,
            self::HISTORY,
            self::FASHION,
        ];

        foreach ($categories as $categoryName) {
            $category = new ArticleCategory($categoryName);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
