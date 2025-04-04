<?php

namespace App\Http\Resources;

use App\Entities\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleCategoryResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var ArticleCategory $articleCategory */
        $articleCategory = $this->resource;

        return [
            'id' => $articleCategory->getId(),
            'title' => $articleCategory->getTitle(),
        ];
    }
}
