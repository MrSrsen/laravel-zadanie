<?php

namespace App\Http\Controllers;

use App\Entities\ArticleCategory;
use App\EntityRepositories\ArticleCategoryRepository;
use App\Http\Resources\ArticleCategoryResource;
use App\Utils\DoctrinePaginator;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class ArticleCategoryController
{
    private ArticleCategoryRepository $articleCategoryRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->articleCategoryRepository = $entityManager->getRepository(ArticleCategory::class);
    }

    public function show(Request $request, string $articleCategory): JsonResponse
    {
        $category = $this->articleCategoryRepository->find($articleCategory)
            ?? throw new NotFoundHttpException('ArticleCategory not found');

        return new JsonResponse(ArticleCategoryResource::make($category)->toArray($request));
    }

    public function index(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $page = max(1, $page);

        $items = $request->query->getInt('items', 50);
        $items = max(100, min($items, 10));

        $query = $this->articleCategoryRepository->getAllSortedQuery();

        return new JsonResponse(
            (new DoctrinePaginator($query))
                ->paginate($page, $items)
                ->map(fn (ArticleCategory $category) => ArticleCategoryResource::make($category)->toArray($request))
                ->toArray()
        );
    }
}
