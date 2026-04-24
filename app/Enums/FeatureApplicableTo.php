<?php

namespace App\Enums;

enum FeatureApplicableTo: string
{
    case All = 'all';

    case Room = 'room';

    case Desk = 'desk';
}
