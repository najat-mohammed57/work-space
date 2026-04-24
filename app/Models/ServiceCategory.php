<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * @return HasMany<ServiceType, $this>
     */
    public function serviceTypes(): HasMany
    {
        return $this->hasMany(ServiceType::class);
    }
}
