<?php

namespace App\Http\Controllers\Api;

use App\Enums\PositionType;
use App\Http\Controllers\Controller;
use App\Models\PositionLog;
use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    public function __invoke(PositionType $position_type, Request $request)
    {
        return match ($position_type) {
            PositionType::MONTH => PositionLog::getMonth(),
            PositionType::DAY => PositionLog::getDay(),
            PositionType::HOUR => PositionLog::getHour()
        };
    }
}
