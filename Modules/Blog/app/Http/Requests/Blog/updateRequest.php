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
                'writer' => 'required',
                'read' => 'required',
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
