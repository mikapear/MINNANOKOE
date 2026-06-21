<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'birth_year' => ['nullable', 'integer', 'min:1920', 'max:'.date('Y')],
            'birth_month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'diagnosed_year' => ['nullable', 'integer', 'min:1980', 'max:'.date('Y')],
            'diagnosed_month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'in:patient,family,friend,medical'],
            'treatment_status' => ['nullable', 'string', 'in:under_treatment,completed,recurrence,metastatic'],
            'treatment_types' => ['nullable', 'array'],
            'treatment_types.*' => ['string'],
        ];
    }
}
