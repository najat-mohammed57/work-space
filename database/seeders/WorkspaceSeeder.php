<?php

namespace Database\Seeders;

use App\Enums\FeatureApplicableTo;
use App\Enums\ServiceCurrency;
use App\Models\Feature;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WorkspaceSeeder extends Seeder
{
    /**
     * Seed workspace defaults. Manager login: manager@example.com / password (override with MANAGER_PASSWORD in .env).
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Workspace Manager',
                'password' => Hash::make((string) env('MANAGER_PASSWORD', 'password')),
            ],
        );

        $room = ServiceCategory::query()->updateOrCreate(
            ['slug' => 'room'],
            ['name' => 'Room'],
        );

        $desk = ServiceCategory::query()->updateOrCreate(
            ['slug' => 'desk'],
            ['name' => 'Desk'],
        );

        $meeting = ServiceType::query()->firstOrCreate(
            ['service_category_id' => $room->id, 'name' => 'Meeting room'],
        );

        $workRoom = ServiceType::query()->firstOrCreate(
            ['service_category_id' => $room->id, 'name' => 'Work room'],
        );

        $training = ServiceType::query()->firstOrCreate(
            ['service_category_id' => $room->id, 'name' => 'Training room'],
        );

        $smallDesk = ServiceType::query()->firstOrCreate(
            ['service_category_id' => $desk->id, 'name' => 'Small desk'],
        );

        $largeDesk = ServiceType::query()->firstOrCreate(
            ['service_category_id' => $desk->id, 'name' => 'Large desk'],
        );

        $features = [
            ['name' => 'TV / display', 'applicable_to' => FeatureApplicableTo::Room],
            ['name' => 'Whiteboard', 'applicable_to' => FeatureApplicableTo::Room],
            ['name' => 'Video conferencing', 'applicable_to' => FeatureApplicableTo::All],
            ['name' => 'Power outlets', 'applicable_to' => FeatureApplicableTo::All],
            ['name' => 'Ergonomic chair', 'applicable_to' => FeatureApplicableTo::Desk],
            ['name' => 'Dual monitor mount', 'applicable_to' => FeatureApplicableTo::Desk],
        ];

        foreach ($features as $row) {
            Feature::query()->firstOrCreate(
                ['name' => $row['name']],
                ['applicable_to' => $row['applicable_to']],
            );
        }

        $roomService = Service::query()->firstOrCreate(
            ['code' => 'ROOM-01'],
            [
                'service_type_id' => $meeting->id,
                'name' => 'Meeting room 1',
                'base_price' => 120.00,
                'currency' => ServiceCurrency::Usd,
                'discount_percent' => 0,
                'is_active' => true,
            ],
        );

        $deskService = Service::query()->firstOrCreate(
            ['code' => 'DESK-S-01'],
            [
                'service_type_id' => $smallDesk->id,
                'name' => 'Small desk A3',
                'base_price' => 35.00,
                'currency' => ServiceCurrency::Ils,
                'discount_percent' => 10,
                'is_active' => true,
            ],
        );

        $this->assignRandomFeaturesForCategory($roomService, $room->slug);
        $this->assignRandomFeaturesForCategory($deskService, $desk->slug);
    }

    /**
     * Attach a random subset of features compatible with the category; always at least one when any exist.
     */
    private function assignRandomFeaturesForCategory(Service $service, string $categorySlug): void
    {
        $applicableIds = Feature::query()
            ->get()
            ->filter(fn (Feature $feature) => $feature->appliesToCategorySlug($categorySlug))
            ->pluck('id')
            ->all();

        if ($applicableIds === []) {
            return;
        }

        $count = fake()->numberBetween(1, count($applicableIds));
        $chosen = collect($applicableIds)->shuffle()->take($count)->values()->all();

        $service->features()->sync($chosen);
    }
}
