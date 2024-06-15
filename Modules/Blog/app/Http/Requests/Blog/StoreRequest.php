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
                'writer' => 'required',
                'read' => 'required',
                'body' => 'required|string',
                'summary' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
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
