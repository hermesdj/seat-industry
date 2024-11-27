<?php

namespace Seat\HermesDj\Industry\Helpers\Industry\Skills;

use Illuminate\Support\Collection;

class IndustrySkillResult
{
    public Collection $skills;
    public Collection $missingSkills;

    public function __construct()
    {
        $this->skills = collect();
        $this->missingSkills = collect();
    }
}