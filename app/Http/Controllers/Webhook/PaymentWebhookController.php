<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function __construct(private PaymentService $payments) {}

    public function __invoke(Request $request): JsonResponse
    {
        $success = $this->payments->handleWebhook($request);

        return response()->json([
            'success' => $success,
        ], $success ? 200 : 422);
    }
}
