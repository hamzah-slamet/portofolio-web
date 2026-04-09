<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    $projectId = $this->route('project')?->id;

    $slugRule = $projectId
        ? "unique:projects,slug,{$projectId}"
        : 'unique:projects,slug';

    return [
        'title'        => ['required', 'string', 'max:150'],
        'slug'         => ['nullable', 'string', 'max:160', $slugRule],
        'description'  => ['required', 'string'],
        'thumbnail'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'tech_stack'   => ['nullable', 'array'],
        'tech_stack.*' => ['string', 'max:50'],
        'github_url'   => ['nullable', 'url', 'max:255'],
        'live_url'     => ['nullable', 'url', 'max:255'],
        'is_featured'  => ['nullable', 'boolean'],
        'status'       => ['required', 'in:online,offline,development'],
        'sort_order'   => ['nullable', 'integer', 'min:0'],
    ];
}

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'sort_order'  => $this->input('sort_order', 0),
            'slug'        => $this->input('slug') ?: Str::slug($this->input('title', '')),
        ]);
    }
}
