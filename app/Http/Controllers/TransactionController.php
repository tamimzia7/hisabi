<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $query = Transaction::where('user_id', $user->id)
            ->with(['category'])
            ->orderByDesc('transaction_date')
            ->orderByDesc('id');

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }
        if ($request->filled('from')) {
            $query->where('transaction_date', '>=', $request->date('from'));
        }
        if ($request->filled('to')) {
            $query->where('transaction_date', '<=', $request->date('to'));
        }

        $transactions = $query->paginate(20)->withQueryString();

        $categories = Category::where(function ($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user->id);
        })->orderBy('name')->get();

        $totals = [
            'income' => Transaction::where('user_id', $user->id)->where('type', 'income')->sum('amount'),
            'expense' => Transaction::where('user_id', $user->id)->where('type', 'expense')->sum('amount'),
        ];
        $totals['balance'] = bcsub((string) $totals['income'], (string) $totals['expense'], 2);

        return view('transactions.index', compact('transactions', 'categories', 'totals'));
    }

    public function create(Request $request): View
    {
        $user = $request->user();
        $categories = Category::where(function ($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user->id);
        })->orderBy('name')->get();

        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'type' => ['required', 'in:income,expense'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'transaction_date' => ['required', 'date'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'transaction_date' => $validated['transaction_date'],
            'category_id' => $validated['category_id'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('transactions.index')->with('status', 'লেনদেন সংরক্ষণ হয়েছে।');
    }

    public function edit(Request $request, Transaction $transaction): View
    {
        abort_unless($transaction->user_id === $request->user()->id, 403);

        $user = $request->user();
        $categories = Category::where(function ($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user->id);
        })->orderBy('name')->get();

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        abort_unless($transaction->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'type' => ['required', 'in:income,expense'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'transaction_date' => ['required', 'date'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('status', 'লেনদেন আপডেট হয়েছে।');
    }

    public function destroy(Request $request, Transaction $transaction): RedirectResponse
    {
        abort_unless($transaction->user_id === $request->user()->id, 403);

        $transaction->delete();

        return redirect()->route('transactions.index')->with('status', 'লেনদেন মুছে ফেলা হয়েছে।');
    }
}
