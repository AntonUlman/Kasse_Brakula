<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\User;

class HomeController extends Controller
{
    public function __invoke()
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

        return Inertia('Home/Index', [
            "profitsByDate" => $profitsByDate
        ]);
    }
}
