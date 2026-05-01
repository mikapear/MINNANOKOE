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
        $treatmentKeys = array_keys(config('minnanokoe.treatment_types', []));

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
            'birth_date' => ['nullable', 'date', 'before:today'],
            'diagnosed_at' => ['nullable', 'date'],
            'treatment_types' => ['nullable', 'array'],
            'treatment_types.*' => ['string', Rule::in($treatmentKeys)],
        ];
    }
}
