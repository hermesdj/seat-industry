<?php

namespace Seat\HermesDj\Industry\database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustryStructureBonusSeeder extends Seeder
{
    protected array $bonuses = [
        [
            'structure_type_id' => 35836,
            'activity_type' => 11,
            'bonus_type' => 2,
            'float_value' => 0.25,
        ],
        [
            'structure_type_id' => 35825,
            'activity_type' => 1,
            'bonus_type' => 1,
            'float_value' => 0.01,
        ],
        [
            'structure_type_id' => 35825,
            'activity_type' => 1,
            'bonus_type' => 2,
            'float_value' => 0.15,
        ],
        [
            'structure_type_id' => 35825,
            'activity_type' => 1,
            'bonus_type' => 3,
            'float_value' => 0.03,
        ],
        [
            'structure_type_id' => 35825,
            'activity_type' => 3,
            'bonus_type' => 2,
            'float_value' => 0.15,
        ],
        [
            'structure_type_id' => 35825,
            'activity_type' => 3,
            'bonus_type' => 3,
            'float_value' => 0.03,
        ],
        [
            'structure_type_id' => 35825,
            'activity_type' => 4,
            'bonus_type' => 2,
            'float_value' => 0.15,
        ],
        [
            'structure_type_id' => 35825,
            'activity_type' => 4,
            'bonus_type' => 3,
            'float_value' => 0.03,
        ],
        [
            'structure_type_id' => 35825,
            'activity_type' => 5,
            'bonus_type' => 2,
            'float_value' => 0.15,
        ],
        [
            'structure_type_id' => 35825,
            'activity_type' => 5,
            'bonus_type' => 3,
            'float_value' => 0.03,
        ],
        [
            'structure_type_id' => 35826,
            'activity_type' => 1,
            'bonus_type' => 1,
            'float_value' => 0.01,
        ],
        [
            'structure_type_id' => 35826,
            'activity_type' => 1,
            'bonus_type' => 2,
            'float_value' => 0.20,
        ],
        [
            'structure_type_id' => 35826,
            'activity_type' => 1,
            'bonus_type' => 3,
            'float_value' => 0.04,
        ],
        [
            'structure_type_id' => 35826,
            'activity_type' => 3,
            'bonus_type' => 2,
            'float_value' => 0.20,
        ],
        [
            'structure_type_id' => 35826,
            'activity_type' => 3,
            'bonus_type' => 3,
            'float_value' => 0.04,
        ],
        [
            'structure_type_id' => 35826,
            'activity_type' => 4,
            'bonus_type' => 2,
            'float_value' => 0.20,
        ],
        [
            'structure_type_id' => 35826,
            'activity_type' => 4,
            'bonus_type' => 3,
            'float_value' => 0.04,
        ],
        [
            'structure_type_id' => 35826,
            'activity_type' => 5,
            'bonus_type' => 2,
            'float_value' => 0.20,
        ],
        [
            'structure_type_id' => 35826,
            'activity_type' => 5,
            'bonus_type' => 3,
            'float_value' => 0.04,
        ],
        [
            'structure_type_id' => 35827,
            'activity_type' => 1,
            'bonus_type' => 1,
            'float_value' => 0.01,
        ],
        [
            'structure_type_id' => 35827,
            'activity_type' => 1,
            'bonus_type' => 2,
            'float_value' => 0.30,
        ],
        [
            'structure_type_id' => 35827,
            'activity_type' => 1,
            'bonus_type' => 3,
            'float_value' => 0.05,
        ],
        [
            'structure_type_id' => 35827,
            'activity_type' => 3,
            'bonus_type' => 2,
            'float_value' => 0.30,
        ],
        [
            'structure_type_id' => 35827,
            'activity_type' => 3,
            'bonus_type' => 3,
            'float_value' => 0.05,
        ],
        [
            'structure_type_id' => 35827,
            'activity_type' => 4,
            'bonus_type' => 2,
            'float_value' => 0.30,
        ],
        [
            'structure_type_id' => 35827,
            'activity_type' => 4,
            'bonus_type' => 3,
            'float_value' => 0.05,
        ],
        [
            'structure_type_id' => 35827,
            'activity_type' => 5,
            'bonus_type' => 2,
            'float_value' => 0.30,
        ],
        [
            'structure_type_id' => 35827,
            'activity_type' => 5,
            'bonus_type' => 3,
            'float_value' => 0.05,
        ],
    ];

    public function run(): void
    {
        $table = DB::table('seat_industry_structure_bonuses');

        $table->truncate();

        foreach ($this->bonuses as $bonus) {
            $table->insert($bonus);
        }
    }
}
