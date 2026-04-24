<?php

namespace App\Http\Requests;

use App\Enums\FeatureApplicableTo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreFeatureRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'applicable_to' => ['required', new Enum(FeatureApplicableTo::class)],
        ];
    }
}
