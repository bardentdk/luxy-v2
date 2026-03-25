<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:255'],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'content'          => ['nullable', 'string'],
            'category'         => ['nullable', 'string', 'max:100'],
            'tags'             => ['nullable', 'array'],
            'tags.*'           => ['string', 'max:50'],
            'is_published'     => ['boolean'],
            'is_featured'      => ['boolean'],
            'read_time'        => ['nullable', 'integer', 'min:1'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'published_at'     => ['nullable', 'date'],
            'thumbnail'        => ['nullable', 'image', 'max:4096'],
            'banner'           => ['nullable', 'image', 'max:6144'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => "Le titre de l'article est obligatoire.",
            'title.max'      => 'Le titre ne peut pas dépasser 255 caractères.',
            'thumbnail.image'=> 'La miniature doit être une image.',
            'thumbnail.max'  => 'La miniature ne doit pas dépasser 4 Mo.',
            'banner.image'   => 'La bannière doit être une image.',
            'banner.max'     => 'La bannière ne doit pas dépasser 6 Mo.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
            'is_featured'  => $this->boolean('is_featured'),
        ]);
    }
}