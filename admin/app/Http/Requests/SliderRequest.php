<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
            'name' => 'bail|required|unique:sliders|max:255',
            'description' => 'bail|nullable|string',
            'image_path' => 'bail|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Slider name is required',
            'image_path.required' => 'Slider image is required',
            'image_path.image' => 'Slider image must be an image file',
            'image_path.mimes' => 'Slider image must be a file of type: jpeg, png, jpg, gif, svg',
        ];
    }
}
