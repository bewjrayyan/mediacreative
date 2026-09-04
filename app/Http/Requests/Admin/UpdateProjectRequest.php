<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $projectId = $this->route('project')?->id ?? $this->route('project');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($projectId)],
            'category' => ['required', 'string', 'max:100'],
            'client' => ['nullable', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'description' => ['required', 'string'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['nullable', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['nullable', Rule::in(['draft', 'published'])],
            'services' => ['nullable', 'array'],
            'services.*' => ['nullable', 'string'],
        ];
    }
}
