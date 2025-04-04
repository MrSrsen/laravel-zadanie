<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|min:6|max:255',
            'summary' => 'nullable|string|min:6|max:20000',
            'content' => 'required|string|min:6|max:20000',
            'category' => 'required|uuid|exists:article_categories,id',
        ];
    }
}
