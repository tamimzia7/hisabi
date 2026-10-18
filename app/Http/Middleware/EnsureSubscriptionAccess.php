<?php

namespace App\Http\Middleware;

use App\Services\SubscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscriptionAccess
{
    public function __construct(private SubscriptionService $subscriptions) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $this->subscriptions->canPerformPaidActions($user)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'সাবস্ক্রিপশন প্রয়োজন।'], 403);
            }

            return redirect()->route('subscription.index')
                ->with('error', 'এই কাজটি করতে সক্রিয় সাবস্ক্রিপশন বা ট্রায়াল প্রয়োজন।');
        }

        return $next($request);
    }
}
