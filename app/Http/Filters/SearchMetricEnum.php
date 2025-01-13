<?php

namespace App\Http\Filters;

interface SearchMetricEnum
{
    /** @var int the average radius of the earth */
    public const METERS = 6371000;
    public const KILOMETERS = 6371;
    public const MILES = 3956;
}
