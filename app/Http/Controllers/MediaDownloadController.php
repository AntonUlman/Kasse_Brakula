<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProfitsByDateExport;
use PDF;

class MediaDownloadController extends Controller
{
    public function exportExcel()
    {
        $checkouts = Checkout::with('user')->get();

        $profitsByDate = $checkouts->groupBy(function ($item) {
            return $item->created_at->format('d.m.Y');
        })->map(function ($group, $date) {
            $dailyProfit = $group->sum('profit');
            $formattedDailyProfit = number_format($dailyProfit, 2, '.', '');
            $usersInvolved = $group->pluck('user')->unique('id')->values()->pluck('name');
            return [
                'date' => $date,
                'daily_profit' => $formattedDailyProfit,
                'users_involved' => $usersInvolved
            ];
        })->values();

        return Excel::download(new ProfitsByDateExport(collect($profitsByDate)), 'profits_by_date.xlsx');
    }

    public function exportPDF()
    {
        $checkouts = Checkout::with('user')->get();

        $profitsByDate = $checkouts->groupBy(function ($item) {
            return $item->created_at->format('d.m.Y');
        })->map(function ($group, $date) {
            $dailyProfit = $group->sum('profit');
            $formattedDailyProfit = number_format($dailyProfit, 2, '.', '');
            $usersInvolved = $group->pluck('user')->unique('id')->values();
            $userNames = $usersInvolved->map(function ($user) {
                return $user->name;
            });
            return [
                'date' => $date,
                'daily_profit' => $formattedDailyProfit,
                'users_involved' => $userNames
            ];

        })->values()->all();
        $pdf = PDF::loadView('pdf.profits', ['profitsByDate' => $profitsByDate]);
        return $pdf->download('profits.pdf');
    }
}
