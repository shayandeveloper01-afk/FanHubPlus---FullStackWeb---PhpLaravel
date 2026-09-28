<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'body'        => ['required', 'string'],
            'status'      => ['required', 'in:draft,published'],
            'genre'       => ['nullable', 'string', 'max:100'],
            'year'        => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 2)],
            'type'        => ['nullable', 'in:movie,series,anime,music,game,art,podcast,other'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'trailer_url' => ['nullable', 'url', 'max:2048'],
            'release_date' => ['nullable', 'date'],
        ];
    }
}
