<?php

namespace Seat\HermesDj\Industry\Models\Dogma;

enum DogmaIndustryModificationEnum: int
{
    case TIME_REDUCTION = 2593;
    case MATERIAL_REDUCTION = 2594;
    case COST_REDUCTION = 2595;
    case THUKKER_SPECIAL_MATERIAL_REDUCTION = 2653;

    case REACTION_TIME_BONUS = 2713;
    case REACTION_MATERIAL_BONUS = 2714;
}
