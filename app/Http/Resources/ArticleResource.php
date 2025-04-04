<?php

namespace App\Http\Resources;

use App\Entities\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var Article $article */
        $article = $this->resource;

        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'subtitle' => $article->getSubtitle(),
            'summary' => $article->getSummary(),
            'content' => $article->getContent(),
            'category' => $article->getCategory()->getId(),
            'publishedAt' => $article->getPublishedAt()?->format('c'),
            'createdAt' => $article->getCreatedAt()->format('c'),
        ];
    }
}
