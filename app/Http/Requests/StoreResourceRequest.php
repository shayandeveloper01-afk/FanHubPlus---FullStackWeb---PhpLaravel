<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResourceRequest extends FormRequest
{
    public function authorize(): bool { return $this->user() !== null; }

    public function rules(): array
    {
        return [
            'content_id' => ['nullable', 'exists:contents,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'type' => ['required', 'in:wallpaper,fanart,fanfic,subtitle,theme,audio'],
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif,pdf,mp3,wav,srt,zip', 'max:51200'],
            'license' => ['nullable', 'string', 'max:100'],
        ];
    }
}
