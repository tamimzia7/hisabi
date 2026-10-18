# Subscription and Payment Status

## Implemented safely
- Configurable subscription plans (`subscription_plans`).
- User subscriptions (`subscriptions`) with status and dates.
- Payment records (`payment_records`) with unique transaction references.
- Server-side payment verification via HMAC-signed callbacks/webhooks.
- Idempotent webhook handling.
- Subscription access service and `subscription.access` middleware.
- 30-day trial driven by `SUBSCRIPTION_TRIAL_DAYS`.

## Configuration
- `SUBSCRIPTION_CURRENCY` (default: BDT)
- `SUBSCRIPTION_TRIAL_DAYS` (default: 30)
- `SUBSCRIPTION_GRACE_DAYS` (default: 0)
- `SUBSCRIPTION_PAYMENT_PROVIDER` (default: pending)
- `SUBSCRIPTION_WEBHOOK_SECRET` (required for verification)

## Blockers / not implemented
- No real payment gateway SDK or provider adapter is integrated.
- No final pricing is defined; plan prices must be configured by an administrator.
- Checkout currently creates a pending payment record and redirects back with instructions.
- Real payment success requires a trusted gateway callback/webhook with a valid
  `X-Subscription-Signature` (HMAC SHA-256) and matching amount, currency,
  transaction reference, and status.
- Payment gateway credentials and provider choice are unavailable in this project.

## Data preservation
- Subscription or trial expiration never deletes user, subscription, payment,
  or financial records.
- Renewal activates a new subscription and restores paid-action access.
