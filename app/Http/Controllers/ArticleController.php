<?php

namespace App\Http\Controllers;

use App\Entities\Article;
use App\Entities\ArticleCategory;
use App\EntityRepositories\ArticleCategoryRepository;
use App\EntityRepositories\ArticleRepository;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Utils\DoctrinePaginator;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class ArticleController
{
    private ArticleRepository $articleRepository;
    private ArticleCategoryRepository $articleCategoryRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->articleRepository = $entityManager->getRepository(Article::class);
        $this->articleCategoryRepository = $this->entityManager->getRepository(ArticleCategory::class);
    }

    public function list(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $page = max(1, $page);

        $items = $request->query->getInt('items', 50);
        $items = max(100, min($items, 3));

        $user = auth()->user();
        $articlesQuery = $this->articleRepository->getBloggersArticlesQuery($user);

        return new JsonResponse(
            (new DoctrinePaginator($articlesQuery))
                ->paginate($page, $items)
                ->map(fn (Article $article) => ArticleResource::make($article)->toArray($request))
                ->toArray()
        );
    }

    public function show(Request $request, string $article): JsonResponse
    {
        $article = $this->articleRepository->find($article)
            ?? throw new NotFoundHttpException('Article not found.');

        $user = auth()->user();
        if ($article->getBlogger()->getId() !== $user->getId()) {
            throw new AccessDeniedHttpException('Cannot view article. Only authors can view articles.');
        }

        return new JsonResponse(ArticleResource::make($article)->toArray($request));
    }

    public function create(CreateArticleRequest $request): JsonResponse
    {
        $user = auth()->user();

        $category = $this->articleCategoryRepository->find($request->validated('category'))
            ?? throw new BadRequestHttpException('ArticleCategory not found.');

        if (!$user->getArticleCategories()->contains($category)) {
            throw new BadRequestHttpException('Cannot create Article in unassigned ArticleCategory.');
        }

        $article = new Article(
            blogger: $user,
            title: $request->validated('title'),
            content: $request->validated('content'),
            category: $category,
        );

        $article
            ->setSubtitle($request->validated('subtitle'))
            ->setSummary($request->validated('summary'));

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return new JsonResponse(ArticleResource::make($article)->toArray($request));
    }

    public function update(UpdateArticleRequest $request, string $article): JsonResponse
    {
        $article = $this->articleRepository->find($article)
            ?? throw new NotFoundHttpException('Article not found.');

        $user = auth()->user();
        if ($article->getBlogger()->getId() !== $user->getId()) {
            throw new AccessDeniedHttpException('Cannot edit article. Only author can edit articles');
        }

        if (null !== $article->getPublishedAt() && $article->getPublishedAt() >= now()) {
            throw new BadRequestHttpException('Cannot edit article. Article is already published.');
        }

        $category = $this->articleCategoryRepository->find($request->validated('category'))
            ?? throw new BadRequestHttpException('ArticleCategory not found.');

        $article
            ->setTitle($request->validated('title'))
            ->setSubtitle($request->validated('subtitle'))
            ->setSummary($request->validated('summary'))
            ->setContent($request->validated('content'))
            ->setCategory($category);

        $this->entityManager->flush();

        return new JsonResponse(ArticleResource::make($article)->toArray($request));
    }

    public function delete(string $article): Response
    {
        $article = $this->articleRepository->find($article)
            ?? throw new NotFoundHttpException('Article not found.');

        $user = auth()->user();
        if ($article->getBlogger()->getId() !== $user->getId()) {
            throw new AccessDeniedHttpException('Cannot delete article. Only author can delete articles.');
        }

        if (null !== $article->getPublishedAt() && $article->getPublishedAt() >= now()) {
            throw new BadRequestHttpException('Cannot delete article. Article is already published.');
        }

        $this->entityManager->remove($article);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
