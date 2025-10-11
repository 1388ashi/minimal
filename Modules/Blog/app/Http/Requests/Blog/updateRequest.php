<?php
namespace Modules\Blog\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class updateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
                'title' => 'required',
                'slug' => 'required',
                'image_alt' => 'nullable',
                'canonical_tag' => 'nullable|string',
                'title_page' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'writer' => 'required',
                'read' => 'required',
                'body' => 'required|string',
                'summary' => 'required|string',
                'image' => 'nullable',
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
