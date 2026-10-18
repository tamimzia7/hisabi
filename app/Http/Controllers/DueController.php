<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Due;
use App\Models\DuePayment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DueController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $contacts = Contact::where('user_id', $user->id)->with('dues.payments')->latest()->get();

        $receivableTotal = Due::where('user_id', $user->id)
            ->where('type', 'receivable')
            ->where('status', 'open')
            ->get()
            ->sum(fn ($due) => (float) $due->outstanding());

        $payableTotal = Due::where('user_id', $user->id)
            ->where('type', 'payable')
            ->where('status', 'open')
            ->get()
            ->sum(fn ($due) => (float) $due->outstanding());

        return view('dues.index', compact('contacts', 'receivableTotal', 'payableTotal'));
    }

    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'type' => ['required', 'in:customer,supplier'],
        ]);

        $request->user()->contacts()->create($validated);

        return back()->with('status', 'কন্টাক্ট যোগ হয়েছে।');
    }

    public function storeDue(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'contact_id' => ['required', 'integer', 'exists:contacts,id'],
            'type' => ['required', 'in:receivable,payable'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'due_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $contact = Contact::findOrFail($validated['contact_id']);
        abort_unless($contact->user_id === $request->user()->id, 403);

        Due::create([
            'user_id' => $request->user()->id,
            'contact_id' => $contact->id,
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => 'open',
        ]);

        return back()->with('status', 'বাকি যোগ হয়েছে।');
    }

    public function storePayment(Request $request, Due $due): RedirectResponse
    {
        abort_unless($due->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        DuePayment::create([
            'due_id' => $due->id,
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'description' => $validated['description'] ?? null,
        ]);

        if (bccomp($due->fresh()->outstanding(), '0.00', 2) <= 0) {
            $due->update(['status' => 'settled']);
        }

        return back()->with('status', 'পেমেন্ট সংরক্ষণ হয়েছে।');
    }
}
