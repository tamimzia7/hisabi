<?php

namespace App\Services;

use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MessAccountingService
{
    /**
     * Categories eligible to be included in the meal rate based on workspace settings.
     *
     * @return array<int, string>
     */
    public function eligibleCategories(Workspace $workspace): array
    {
        $settings = $workspace->settings ?? [];
        $categories = ['market'];

        if (! empty($settings['include_rent'])) {
            $categories[] = 'rent';
        }
        if (! empty($settings['include_gas'])) {
            $categories[] = 'gas';
        }
        if (! empty($settings['include_electricity'])) {
            $categories[] = 'electricity';
        }
        if (! empty($settings['include_water'])) {
            $categories[] = 'water';
        }

        return $categories;
    }

    public function monthlyReport(Workspace $workspace, int $year, int $month): array
    {
        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end = $start->copy()->endOfMonth();

        $expenses = $workspace->messExpenses()
            ->whereBetween('expense_date', [$start->toDateString(), $end->toDateString()])
            ->get();

        $eligibleCategories = $this->eligibleCategories($workspace);
        $eligibleTotal = '0.00';
        foreach ($expenses as $expense) {
            if (in_array($expense->category, $eligibleCategories, true)) {
                $eligibleTotal = bcadd($eligibleTotal, (string) $expense->amount, 2);
            }
        }

        $meals = $workspace->messMeals()
            ->whereBetween('meal_date', [$start->toDateString(), $end->toDateString()])
            ->get();

        $totalMeals = 0;
        foreach ($meals as $meal) {
            $totalMeals += (int) $meal->breakfast + (int) $meal->lunch + (int) $meal->dinner;
        }

        $mealRate = $totalMeals > 0
            ? bcdiv($eligibleTotal, (string) $totalMeals, 4)
            : '0.0000';

        $deposits = $workspace->messDeposits()
            ->whereBetween('deposit_date', [$start->toDateString(), $end->toDateString()])
            ->get();

        $members = $workspace->members()->orderBy('name')->get();
        $memberRows = [];

        foreach ($members as $member) {
            $memberMealCount = 0;
            foreach ($meals as $meal) {
                if ((int) $meal->member_id === (int) $member->id) {
                    $memberMealCount += (int) $meal->breakfast + (int) $meal->lunch + (int) $meal->dinner;
                }
            }

            $charge = bcmul((string) $memberMealCount, $mealRate, 2);

            $memberDepositTotal = '0.00';
            foreach ($deposits as $deposit) {
                if ((int) $deposit->member_id === (int) $member->id) {
                    $memberDepositTotal = bcadd($memberDepositTotal, (string) $deposit->amount, 2);
                }
            }

            $balance = bcsub($memberDepositTotal, $charge, 2);

            $memberRows[] = [
                'member' => $member,
                'meals' => $memberMealCount,
                'charge' => $charge,
                'deposits' => $memberDepositTotal,
                'balance' => $balance,
            ];
        }

        $totalDeposits = '0.00';
        foreach ($deposits as $deposit) {
            $totalDeposits = bcadd($totalDeposits, (string) $deposit->amount, 2);
        }

        return [
            'year' => $year,
            'month' => $month,
            'start' => $start,
            'end' => $end,
            'eligible_total' => $eligibleTotal,
            'total_meals' => $totalMeals,
            'meal_rate' => $mealRate,
            'total_deposits' => $totalDeposits,
            'members' => $memberRows,
            'expenses' => $expenses,
        ];
    }
}
