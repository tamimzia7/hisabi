<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $data = ['user' => $user];

        if (in_array($user->account_type, ['personal', 'business'], true)) {
            $income = Transaction::where('user_id', $user->id)->where('type', 'income')->sum('amount');
            $expense = Transaction::where('user_id', $user->id)->where('type', 'expense')->sum('amount');
            $data['totals'] = [
                'income' => (string) $income,
                'expense' => (string) $expense,
                'balance' => bcsub((string) $income, (string) $expense, 2),
            ];
            $data['recent'] = Transaction::where('user_id', $user->id)->latest('transaction_date')->latest('id')->take(5)->get();
        }

        if ($user->account_type === 'mess') {
            $data['workspaces'] = $user->workspaces()->where('type', 'mess')->latest()->get();
        }

        return view('dashboard', $data);
    }
}
