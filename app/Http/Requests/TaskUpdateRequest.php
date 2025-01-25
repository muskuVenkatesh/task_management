<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
            'assigned_to' => 'nullable|exists:users,id|role:Team Member',
            'status' => 'nullable|in:pending,ongoing,completed',
        ];
    }
}
