<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

class SettingRequestAdd extends FormRequest
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

    public function rules()
    {
        // Lấy ID của thiết lập hiện tại từ route
        $settingId = $this->route('id');
    
        return [
            'config_key' => [
                'required',
                Rule::unique('settings')->ignore($settingId),
            ],
            'config_value' => 'required',
            'type' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'config_key.required' => 'Không bỏ trống tên.',
            'config_value.required' => 'Không bỏ trống nội dung',
            'config_key.max' => 'Không bỏ trống danh mục',
            
        ];
    }
}
