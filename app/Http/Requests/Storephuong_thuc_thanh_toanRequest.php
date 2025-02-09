<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Storephuong_thuc_thanh_toanRequest extends FormRequest
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
            'kieu_thanh_toan' => 'required|unique:phuong_thuc_thanh_toans,kieu_thanh_toan',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'kieu_thanh_toan.required' => 'Bạn chưa chọn phương thức thanh toán ',
            'kieu_thanh_toan.unique' => 'Phương thức thanh toán đã tồn tại'
        ];
    }
}
