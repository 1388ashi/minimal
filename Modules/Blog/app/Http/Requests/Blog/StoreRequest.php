<?php

namespace Modules\Blog\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
                'title' => 'required|unique:posts,title',
                'slug' => 'required|unique:posts,slug',
                'image_alt' => 'nullable',
                'writer' => 'required',
                'read' => 'required',
                'type' => 'required',
                'body' => 'required|string',
                'summary' => 'required|string',
                'image' => 'nullable|image',
                'category_id' => 'required|integer|exists:blog_categories,id',
                'published_at' => 'nullable|date',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
