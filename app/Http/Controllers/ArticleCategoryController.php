<?php

namespace App\Http\Controllers;

use App\Entities\ArticleCategory;
use App\EntityRepositories\ArticleCategoryRepository;
use App\Http\Resources\ArticleCategoryResource;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

readonly class ArticleCategoryController
{
    private ArticleCategoryRepository $articleCategoryRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        $this->articleCategoryRepository = $entityManager->getRepository(ArticleCategory::class);
    }

    public function index(): AnonymousResourceCollection
    {
        $articles = $this->articleCategoryRepository->findAllSorted();

        return ArticleCategoryResource::collection($articles);
    }
}
