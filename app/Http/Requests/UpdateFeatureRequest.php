<?php

namespace App\Http\Requests;

use App\Enums\FeatureApplicableTo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateFeatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'applicable_to' => ['sometimes', new Enum(FeatureApplicableTo::class)],
        ];
    }
}
