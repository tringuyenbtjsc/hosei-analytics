<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PositionLog extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'pgsql';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'cluster_id',
        'device_id',
        'nearest',
        'x',
        'y',
        'h',
        'r',
        'detected',
    ];

    protected function getMonth(): array
    {
        return $this->select(
            DB::raw('EXTRACT(YEAR FROM detected) AS year'),
            DB::raw('EXTRACT(MONTH FROM detected) AS month'),
            DB::raw('COUNT(*) AS total_records')
        )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get('detected')
            ->toArray();
    }

    protected function getDay(): array
    {
        return $this->select(
            DB::raw("TO_CHAR(detected, 'YYYY-MM-DD') AS date"),
            DB::raw('COUNT(*) AS total_records')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get('detected')
            ->toArray();
    }

    protected function getHour(): array
    {
        return $this->select(
            DB::raw("TO_CHAR(detected, 'YYYY-MM-DD') AS date"),
            DB::raw('EXTRACT(HOUR FROM detected) AS hour'),
            DB::raw('COUNT(*) AS total_records')
        )
            ->groupBy('date', 'hour')
            ->orderBy('date')
            ->orderBy('hour')
            ->get('detected')
            ->toArray();
    }
}
