<?php

namespace Seat\HermesDj\Industry\database\seeds;

use Illuminate\Support\Facades\DB;

class IndustryAttributeSeeder
{
    protected array $attributes = [
        [
            'activity_type' => 1,
            'production_type' => 'EQUIPMENT',
            'bonus_type' => 1,
            'attribute_id' => 2538
        ],
        [
            'activity_type' => 1,
            'production_type' => 'EQUIPMENT',
            'bonus_type' => 2,
            'attribute_id' => 2539
        ],
        [
            'activity_type' => 1,
            'production_type' => 'AMMO',
            'bonus_type' => 1,
            'attribute_id' => 2540
        ],
        [
            'activity_type' => 1,
            'production_type' => 'AMMO',
            'bonus_type' => 2,
            'attribute_id' => 2541
        ],
        [
            'activity_type' => 1,
            'production_type' => 'DRONES',
            'bonus_type' => 1,
            'attribute_id' => 2542
        ],
        [
            'activity_type' => 1,
            'production_type' => 'DRONES',
            'bonus_type' => 2,
            'attribute_id' => 2543
        ],
        [
            'activity_type' => 1,
            'production_type' => 'BASIC_SMALL_SHIPS',
            'bonus_type' => 1,
            'attribute_id' => 2542
        ],
        [
            'activity_type' => 1,
            'production_type' => 'BASIC_SMALL_SHIPS',
            'bonus_type' => 2,
            'attribute_id' => 2543
        ],
        [
            'activity_type' => 1,
            'production_type' => 'BASIC_MEDIUM_SHIPS',
            'bonus_type' => 1,
            'attribute_id' => 2546
        ],
        [
            'activity_type' => 1,
            'production_type' => 'BASIC_MEDIUM_SHIPS',
            'bonus_type' => 2,
            'attribute_id' => 2547
        ],
        [
            'activity_type' => 1,
            'production_type' => 'BASIC_LARGE_SHIPS',
            'bonus_type' => 1,
            'attribute_id' => 2548
        ],
        [
            'activity_type' => 1,
            'production_type' => 'BASIC_LARGE_SHIPS',
            'bonus_type' => 2,
            'attribute_id' => 2549
        ],
        [
            'activity_type' => 1,
            'production_type' => 'SMALL_SHIPS',
            'bonus_type' => 1,
            'attribute_id' => 2550
        ],
        [
            'activity_type' => 1,
            'production_type' => 'SMALL_SHIPS',
            'bonus_type' => 2,
            'attribute_id' => 2551
        ],
        [
            'activity_type' => 1,
            'production_type' => 'MEDIUM_SHIPS',
            'bonus_type' => 1,
            'attribute_id' => 2552
        ],
        [
            'activity_type' => 1,
            'production_type' => 'MEDIUM_SHIPS',
            'bonus_type' => 2,
            'attribute_id' => 2553
        ],
        [
            'activity_type' => 1,
            'production_type' => 'LARGE_SHIPS',
            'bonus_type' => 1,
            'attribute_id' => 2555
        ],
        [
            'activity_type' => 1,
            'production_type' => 'LARGE_SHIPS',
            'bonus_type' => 2,
            'attribute_id' => 2556
        ],
        [
            'activity_type' => 1,
            'production_type' => 'ADVANCED_COMPONENTS',
            'bonus_type' => 1,
            'attribute_id' => 2557
        ],
        [
            'activity_type' => 1,
            'production_type' => 'ADVANCED_COMPONENTS',
            'bonus_type' => 2,
            'attribute_id' => 2558
        ],
        [
            'activity_type' => 1,
            'production_type' => 'CAPITAL_COMPONENTS',
            'bonus_type' => 1,
            'attribute_id' => 2559
        ],
        [
            'activity_type' => 1,
            'production_type' => 'CAPITAL_COMPONENTS',
            'bonus_type' => 2,
            'attribute_id' => 2560
        ],
        [
            'activity_type' => 1,
            'production_type' => 'STRUCTURE',
            'bonus_type' => 1,
            'attribute_id' => 2561
        ],
        [
            'activity_type' => 1,
            'production_type' => 'STRUCTURE',
            'bonus_type' => 2,
            'attribute_id' => 2562
        ],
        [
            'activity_type' => 1,
            'production_type' => 'CAPITAL_SHIPS',
            'bonus_type' => 1,
            'attribute_id' => 2575
        ],
        [
            'activity_type' => 1,
            'production_type' => 'CAPITAL_SHIPS',
            'bonus_type' => 2,
            'attribute_id' => 2576
        ],
        [
            'activity_type' => 1,
            'production_type' => 'CAPITAL_ADVANCED_COMPONENTS',
            'bonus_type' => 1,
            'attribute_id' => 2658
        ],
        [
            'activity_type' => 1,
            'production_type' => 'CAPITAL_ADVANCED_COMPONENTS',
            'bonus_type' => 2,
            'attribute_id' => 2659
        ],
        [
            'activity_type' => 8,
            'production_type' => 'INVENTION',
            'bonus_type' => 3,
            'attribute_id' => 2563
        ],
        [
            'activity_type' => 8,
            'production_type' => 'INVENTION',
            'bonus_type' => 2,
            'attribute_id' => 2564
        ],
        [
            'activity_type' => 4,
            'production_type' => 'RESEARCH_ME',
            'bonus_type' => 3,
            'attribute_id' => 2565
        ],
        [
            'activity_type' => 4,
            'production_type' => 'RESEARCH_ME',
            'bonus_type' => 2,
            'attribute_id' => 2566
        ],
        [
            'activity_type' => 3,
            'production_type' => 'RESEARCH_TE',
            'bonus_type' => 3,
            'attribute_id' => 2567
        ],
        [
            'activity_type' => 3,
            'production_type' => 'RESEARCH_TE',
            'bonus_type' => 2,
            'attribute_id' => 2568
        ],
        [
            'activity_type' => 5,
            'production_type' => 'COPY',
            'bonus_type' => 3,
            'attribute_id' => 2569
        ],
        [
            'activity_type' => 5,
            'production_type' => 'COPY',
            'bonus_type' => 2,
            'attribute_id' => 2570
        ],
        [
            'activity_type' => 1,
            'production_type' => 'ALL_SHIPS',
            'bonus_type' => 2,
            'attribute_id' => 2591
        ],
        [
            'activity_type' => 1,
            'production_type' => 'ALL_SHIPS',
            'bonus_type' => 1,
            'attribute_id' => 2592
        ],
        [
            'activity_type' => 11,
            'production_type' => 'HYBRID_REACTION',
            'bonus_type' => 2,
            'attribute_id' => 2715
        ],
        [
            'activity_type' => 11,
            'production_type' => 'HYBRID_REACTION',
            'bonus_type' => 1,
            'attribute_id' => 2716
        ],
        [
            'activity_type' => 11,
            'production_type' => 'COMPOSITE_REACTION',
            'bonus_type' => 2,
            'attribute_id' => 2717
        ],
        [
            'activity_type' => 11,
            'production_type' => 'COMPOSITE_REACTION',
            'bonus_type' => 1,
            'attribute_id' => 2718
        ],
        [
            'activity_type' => 11,
            'production_type' => 'BIOCHEMICAL_REACTION',
            'bonus_type' => 2,
            'attribute_id' => 2719
        ],
        [
            'activity_type' => 11,
            'production_type' => 'BIOCHEMICAL_REACTION',
            'bonus_type' => 1,
            'attribute_id' => 2720
        ],
    ];

    public function run(): void
    {
        $table = DB::table('seat_industry_attributes');

        $table->truncate();

        foreach ($this->attributes as $attribute) {
            $table->insert($attribute);
        }
    }
}