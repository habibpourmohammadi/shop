<?php

namespace App\Http\Requests\Admin\Appearance\Slider;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "slider_path" => ["nullable", "image", "mimes:png,jpg,jpeg,gif", "max:1024"],
            "url" => ["required", 'regex:#^(https?://)?([\da-z\.-]+)\.([a-z\.]{2,6})([/\w\.-]*)*/?#'],
            "title" => ["required", "max:255"],
        ];
    }

    public function attributes()
    {
        return [
            "url" => "آدرس اسلایدر"
        ];
    }
}
