<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Support\EventLocations;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'          => ['required', 'string', 'max:255'],
            'category_id'    => ['nullable', 'integer', Rule::exists('categories', 'id')->where('status', 'active')],
            'content_id'     => ['nullable', 'integer', 'exists:contents,id'],
            'description'    => ['nullable', 'string', 'max:5000'],
            'venue_name'     => ['required', 'string', 'max:255'],
            'address'        => ['nullable', 'string', 'max:255'],
            'country'        => ['required', 'string', Rule::in(EventLocations::countryNames())],
            'city'           => ['required', 'string', 'max:100'],
            'custom_location' => ['nullable', 'boolean'],
            'latitude'       => ['nullable', 'numeric', 'between:-90,90', 'required_with:longitude'],
            'longitude'      => ['nullable', 'numeric', 'between:-180,180', 'required_with:latitude'],
            'start_datetime' => ['required', 'date'],
            'end_datetime'   => ['nullable', 'date', 'after:start_datetime'],
            'ticket_link'    => ['nullable', 'url', 'max:255', function (string $attribute, mixed $value, \Closure $fail): void {
                if ($value && ! in_array(strtolower((string) parse_url($value, PHP_URL_SCHEME)), ['http', 'https'], true)) {
                    $fail('The ticket link must use HTTP or HTTPS.');
                }
            }],
            'cover_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ];
    }
}
