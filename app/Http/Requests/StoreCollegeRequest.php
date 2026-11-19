<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollegeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Simplified for this project
    }

    public function rules(): array
    {
        return [
            'state_id' => 'required|exists:states,id',
            'college_type' => 'required|integer|in:0,1,2',
            'college_name' => 'required|string|max:255|unique:colleges,college_name',
            'college_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'college_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'place' => 'nullable|string|max:255',
            'about_us' => 'nullable|string|max:500',
            'college_description' => 'nullable|string',
            'courses' => 'nullable|string|max:255',
            'year_of_inspection' => 'nullable|string|max:4',
            'seo_text' => 'nullable|string|max:500',
            'is_active' => 'required|integer|in:0,1',
        ];
    }
}
