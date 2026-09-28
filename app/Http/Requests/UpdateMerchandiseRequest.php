<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMerchandiseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('merchandise'));
    }

    public function rules(): array
    {
        return [
            'title'                  => ['required', 'string', 'max:255'],
            'category_id'            => ['required', 'integer', 'exists:categories,id'],
            'content_id'             => ['nullable', 'integer', 'exists:contents,id'],
            'description'            => ['nullable', 'string', 'max:5000'],
            'price'                  => ['required', 'numeric', 'min:0', 'max:999999'],
            'currency'               => ['required', 'string', 'size:3'],
            'status'                 => ['required', 'in:active,inactive'],
            'external_purchase_link' => ['nullable', 'url', 'max:500'],
            'image'                  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery.*'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery'                => ['nullable', 'array', 'max:6'],
            'tags'                   => ['nullable', 'array'],
            'tags.*'                 => ['integer', 'exists:merchandise_tags,id'],
        ];
    }
}
