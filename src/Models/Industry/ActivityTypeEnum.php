<?php

namespace Seat\HermesDj\Industry\Models\Industry;

enum ActivityTypeEnum: int
{
    case MANUFACTURING = 1;
    case RESEARCH_TE = 3;
    case RESEARCH_ME = 4;
    case COPY = 5;
    case INVENTION = 8;
    case REACTION = 11;
}
