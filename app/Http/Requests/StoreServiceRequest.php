<?php

namespace App\Http\Requests;

use App\Enums\ServiceCurrency;
use App\Models\Feature;
use App\Models\ServiceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class StoreServiceRequest extends FormRequest
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
            'service_type_id' => ['required', 'exists:service_types,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', Rule::unique('services', 'code')],
            'base_price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', new Enum(ServiceCurrency::class)],
            'discount_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'is_active' => ['sometimes', 'boolean'],
            'feature_ids' => ['sometimes', 'array'],
            'feature_ids.*' => ['integer', 'exists:features,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $type = ServiceType::query()->with('serviceCategory')->find($this->integer('service_type_id'));
            if ($type === null || $type->serviceCategory === null) {
                return;
            }

            $slug = $type->serviceCategory->slug;
            $ids = $this->input('feature_ids', []);

            if (! is_array($ids) || $ids === []) {
                return;
            }

            $features = Feature::query()->whereIn('id', $ids)->get();

            foreach ($features as $feature) {
                if (! $feature->appliesToCategorySlug($slug)) {
                    $validator->errors()->add(
                        'feature_ids',
                        __('Feature :name is not compatible with this service category.', ['name' => $feature->name])
                    );
                }
            }
        });
    }
}
