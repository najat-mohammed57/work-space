<?php

namespace App\Models;

use App\Enums\FeatureApplicableTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'applicable_to',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'applicable_to' => FeatureApplicableTo::class,
        ];
    }

    /**
     * @return BelongsToMany<Service, $this>
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)->withTimestamps();
    }

    public function appliesToCategorySlug(string $categorySlug): bool
    {
        return match ($this->applicable_to) {
            FeatureApplicableTo::All => true,
            FeatureApplicableTo::Room => $categorySlug === 'room',
            FeatureApplicableTo::Desk => $categorySlug === 'desk',
        };
    }
}
