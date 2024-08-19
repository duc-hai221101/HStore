<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|unique:products|max:255',
            'price' => 'required|numeric',
            'contents' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'feature_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255'
        ];
    }
    public function messages(): array
{
    return [
        'name.required' => 'Không bỏ trống tên.',
        'contents.required' => 'Không bỏ trống nội dung',
        'category_id.required' => 'Không bỏ trống danh mục',
        'name.unique' => 'Đã trùng tên.',
        'name.max' => 'Tên không vượt quá 255 ký tự.',
        'price.required' => 'Không bỏ trống giá tiền.',
        'price.numeric' => 'Giá phải là số',
    ];
}
}
