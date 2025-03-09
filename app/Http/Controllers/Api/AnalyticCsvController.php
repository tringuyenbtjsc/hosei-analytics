<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PositionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use SplFileObject;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticCsvController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $year, string $month, Request $request): StreamedResponse
    {
        return response()->streamDownload(
            function () use ($year, $month, $request) {
                $csv = new SplFileObject('php://output', 'w');

                $csv->fputcsv([
                    'x',
                    'y',
                    'device_id',
                    'detected',
                    'FAcheck',
                ]);

                $query = PositionLog::query();

                if ($request->hasAny(['limit', 'take'])) {
                    $query->take($request->limit ?? $request->take);
                }

                if ($request->has('latest')) {
                    $query->latest('detected');
                } elseif ($request->has('oldest')) {
                    $query->oldest('detected');
                }

                $query
                    ->whereYear('detected', $year)
                    ->whereMonth('detected', $month)
                    ->get(['x', 'y', 'device_id', 'detected'])
                    ->each(fn (PositionLog $position_log) => $csv->fputcsv([
                        $position_log->x,
                        $position_log->y,
                        $position_log->device_id,
                        $position_log->detected,
                        '',
                    ]));
            },
            sprintf(
                'AfterFACheckForHosei2_%s_%s_data.csv',
                Carbon::now()->format('Ymd'),
                1000
            ),
            ['Content-Type' => 'application/octet-stream']
        );
    }
}
