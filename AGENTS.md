# AGENTS.md --- Hisabi

## 1. Instructions for AI Coding Agents

You are working on **Hisabi**, a subscription-based SaaS platform for
personal finance, mess/bachelor meal accounting, and small-business
record management.

Your responsibility is to build a reliable, secure, attractive, and
extremely user-friendly Laravel application, especially for people with
limited literacy or little experience using financial software.

### Mandatory rules

-   Read this document before making changes.
-   Inspect the existing project before creating, modifying, or deleting
    files.
-   Do not assume that the project is empty.
-   Do not replace working code without a clear reason.
-   Do not introduce unnecessary packages or architectural complexity.
-   Implement one focused feature at a time.
-   Write maintainable, readable, testable code.
-   Follow the conventions of the installed Laravel version.
-   Never claim that a feature works unless it has been tested
    appropriately.
-   Explain important changes and list modified files after each
    implementation phase.
-   Never delete or erase a user's financial records because a free
    trial or subscription has expired.
-   If an existing implementation conflicts with these instructions,
    identify the conflict before making a potentially destructive
    change.

## 2. Product Vision

Hisabi helps everyday people, mess/bachelor groups, and small-business
owners keep track of money without needing to understand complicated
accounting concepts.

The product should let users select the kind of accounting they need and
then show a simple interface tailored to that choice.

### Core principles

-   Simplicity over complexity.
-   Bengali-first user experience.
-   Mobile-first, responsive design.
-   Usable by people with limited literacy and low technical confidence.
-   Attractive, consistent, memorable visual identity.
-   Accurate financial calculations.
-   Secure, private user data.
-   Affordable subscriptions.
-   Reliable performance.
-   Preserve financial history even when access is restricted.

### Main account types

During registration/onboarding, the user selects one primary account
experience:

1.  **Personal হিসাব** --- personal income, expenses, cash balance,
    receivables/payables, and reports.
2.  **মেস / ব্যাচেলর হিসাব** --- meals, member meal counts, market
    expenses, meal rate, member deposits, balances, and monthly
    settlement summaries.
3.  **ব্যবসার হিসাব** --- sales, expenses, customer dues, supplier
    payables, and business reports.

Do not show every type's features to every user by default. The selected
type should determine the initial dashboard, primary actions, and
navigation. Keep the architecture extensible so a user may add another
accounting type later if that feature is deliberately implemented. Do
not silently mix records between personal, mess, and business
workspaces.

## 3. Technology Stack

Use this stack unless the existing project or an explicit requirement
justifies a change.

### Backend

-   PHP
-   Laravel
-   MySQL
-   Laravel Eloquent ORM
-   Laravel Form Requests for complex validation
-   Laravel Policies and Gates for authorization
-   Laravel REST API only when required for a future mobile app or
    integration

### Frontend

-   Laravel Blade
-   Tailwind CSS
-   JavaScript
-   Chart.js for financial charts when useful

### Mobile strategy

Initially build a responsive web application. Make it progressively
web-app friendly so it can later support PWA installation. A Flutter
Android application may be introduced later using a documented API. Do
not build a separate mobile application during the initial MVP.

### Package policy

Before installing a package: - Check whether Laravel already provides
the required functionality. - Check compatibility with installed PHP and
Laravel versions. - Evaluate security, maintenance, and licensing. -
Install only when it provides a clear benefit.

Never assume a particular Laravel version or package is installed.
Inspect `composer.json`, `composer.lock`, `package.json`, and the
existing codebase first.

## 4. UI/UX Requirements

UI/UX is one of Hisabi's highest priorities. Every screen should make
its primary task obvious and should be understandable to a first-time
user.

### Visual design

-   Soft green as the primary brand color.
-   Warm white or light neutral backgrounds.
-   Dark, readable text.
-   Green for income and positive balances.
-   Soft red for expenses and amounts owed.
-   Calm blue for informational elements.
-   Rounded cards and buttons.
-   Subtle shadows and restrained animations.
-   Consistent spacing, Bengali typography, and iconography.
-   Avoid excessive gradients, distracting animations, dense tables, and
    unnecessary decoration.

### Accessibility and low-literacy usability

-   Bengali is the default interface language.
-   Use simple everyday Bengali instead of technical accounting terms.
-   Use large, readable text and clear labels.
-   Use large touch targets, preferably 44--48 CSS pixels or larger.
-   Pair icons with text; never rely on color alone.
-   Provide visible labels and helpful validation messages.
-   Support keyboard navigation where appropriate.
-   Respect reduced-motion preferences.
-   Avoid tiny text and dense tables on mobile.
-   Keep common tasks short and predictable.
-   Explain unfamiliar concepts in plain Bengali.
-   Ask for confirmation before destructive actions.
-   Preserve user input when validation fails.
-   Prevent accidental duplicate submissions.
-   Never use decorative controls that appear functional but do nothing.

Suggested wording: - "টাকা পেলাম" instead of "Credit Transaction" -
"টাকা খরচ করলাম" instead of "Debit Transaction" - "বাকি পাব" for money
owed to the user - "বাকি দেব" for money the user owes - "আজকের হিসাব"
instead of "Daily Financial Summary" - "আজকের মিল" for meal recording -
"বাজার খরচ যোগ করুন" for mess market costs

### Public single home page

Create one responsive public landing page with anchor navigation to
sections on that same page, rather than unnecessary separate marketing
pages. It should explain Hisabi simply, show benefits for Personal,
Mess, and Business users, explain how it works, show subscription
information, and provide clear Registration and Login actions.

Do not invent real customer testimonials, usage statistics, or pricing
claims. Clearly mark placeholder content until real information is
provided.

### Main application navigation

Navigation must depend on the selected account type and remain simple.

Examples: - Personal: Home, Add Record, Due Accounts, Reports,
Profile. - Mess: Home, Today's Meals, Market Expenses, Members, Monthly
Summary, Profile. - Business: Home, Add Record/Sale, Due Accounts,
Reports, Profile.

Do not add unnecessary navigation items to the initial MVP.

## 5. Registration, Onboarding, and Account Type

Registration should use secure, maintained Laravel-compatible
authentication rather than custom authentication from scratch.

After registration: 1. Ask the user to select Personal, Mess/Bachelor,
or Business accounting. 2. Explain each choice in plain Bengali with a
short description and recognizable icon. 3. Save the chosen account
type/workspace relationship server-side. 4. Start a **30-day free
trial** according to the subscription rules below. 5. Send the user to a
large, simple dashboard customized for the selected type.

The choice shown in the UI is not an authorization mechanism. Validate
it server-side and enforce access rules on the server.

## 6. Subscription and 30-Day Free Trial

Hisabi is a subscription-based SaaS. Every new eligible user receives a
**30-day free trial** for the selected account type and trial-eligible
features.

### Trial rules

-   Record the trial start and expiration timestamps server-side.
-   Use a consistent configured timezone and server-side time.
-   Do not trust dates, subscription status, plan, or payment success
    supplied by the browser.
-   Display the number of trial days remaining in an understandable way.
-   Explain the trial and post-trial restrictions clearly before the
    user begins.
-   Do not start a second free trial simply because a user changes a
    profile field, account type, or browser.
-   Trial eligibility and abuse controls must be enforced server-side.

### After trial expiration

When the 30-day trial expires and the user has no active paid
subscription: - Restrict creating, editing, and deleting records and
other paid operations according to the plan's access rules. - Show a
clear subscription renewal/purchase screen or banner. - Allow the user
to view existing financial records in read-only mode, where feasible. -
Allow access to subscription details and payment history. - Keep the
user's records stored safely. - Do not delete, truncate, overwrite,
anonymize, or otherwise erase financial records because of trial
expiration or non-payment. - Do not make the user start from zero after
subscribing.

### Paid access

-   Activate paid access only after the server verifies the payment
    through a trusted gateway/server-side verification flow.
-   Never activate a paid subscription solely because the frontend
    reports success or redirects to a success page.
-   Store subscription plan, status, start date, expiration date, and
    payment history.
-   Enforce plan restrictions on the server, not only by hiding buttons.
-   Handle failed, pending, cancelled, refunded, and duplicate payment
    callbacks safely.
-   Prevent duplicate payment processing using idempotency or an
    equivalent reliable mechanism.
-   Define renewal and any grace period explicitly before implementing
    them.
-   On subscription expiration, restrict paid operations but preserve
    the user's data.
-   When payment is verified and the subscription becomes active,
    restore permitted access to the user's existing records.

### Data preservation rule --- critical

**A trial or subscription expiring must never delete the user's data.**
This includes income and expense entries, due accounts, payments,
contacts, mess meal records, market costs, member balances, reports
derived from stored records, and business records. Preserve data
according to the application's documented retention and legal
obligations. Account deletion must be a separate, explicit
user-requested process with appropriate confirmation and safeguards; it
must never be triggered by subscription expiration.

### Subscription UI

The dashboard should clearly display: - Current plan/account type. -
Trial or subscription status. - Trial expiration date or subscription
renewal/expiration date. - Days remaining when relevant. - A clear
"সাবস্ক্রিপশন কিনুন" or "নবায়ন করুন" action when needed.

Avoid misleading countdowns or fake payment confirmations. Do not invent
final prices or payment gateway details before they are decided.

## 7. Initial MVP Scope

Build incrementally. Do not implement every feature simultaneously.

### Phase 1: Authentication and onboarding

-   Registration, login, logout.
-   Password reset.
-   Profile management.
-   Secure session handling.
-   Account type selection: Personal, Mess, or Business.
-   30-day free trial creation and status display.

### Phase 2: Responsive dashboard

-   A large, clear dashboard customized to the user's account type.
-   Today's and monthly summaries appropriate to that type.
-   Recent records.
-   Large quick-action buttons.
-   Trial/subscription status.
-   Clear distinction between recorded cash balance, income, expenses,
    profit, receivables, and payables.

### Phase 3: Personal income and expense records

-   Create a record.
-   Select a category.
-   Enter an amount.
-   Select a date.
-   Add an optional description.
-   View, filter, edit, and delete records with confirmation.
-   Server-side validation and authorization.

### Phase 4: Mess/Bachelor accounting

-   Create/manage a mess workspace and its members.
-   Record each member's meals by date and meal period (for example,
    breakfast, lunch, dinner).
-   Track per-person meal counts and total monthly meals.
-   Record market purchases and other shared expenses.
-   Support expense categories such as food/market, gas, electricity,
    water, and rent where required.
-   Calculate meal rate using a clearly documented rule, for example:
    eligible shared meal expenses divided by total recorded meals.
-   Calculate member meal cost using that member's meals multiplied by
    the applicable meal rate, plus/minus separately defined shared costs
    and payments.
-   Record member deposits/payments and calculate remaining balances.
-   Provide a monthly summary with total meals, total market/eligible
    expenses, meal rate, member-level meal counts, costs, deposits, and
    outstanding balances.
-   Make the accounting period and calculation rules visible.
-   Do not silently include rent/utilities in meal rate unless the
    configured rule explicitly says they are included.
-   Avoid double-counting payments or expenses.
-   Enforce workspace membership and roles so members cannot access
    another mess's private data.

### Phase 5: Due management

-   Customer/supplier contacts.
-   Money owed to the user and money owed by the user.
-   Partial payments and payment history.
-   Outstanding balance calculation and due settlement.
-   Do not count settlement of an existing due as new income/expense a
    second time.

### Phase 6: Business accounting

-   Sales and expenses.
-   Customer receivables and supplier payables.
-   Transaction history and reports.
-   Do not claim accounting-grade inventory or profit calculations
    unless implemented and documented.

### Phase 7: Reports

-   Daily and monthly summaries.
-   Income and expense totals.
-   Mess monthly meal and member settlement reports.
-   Business/personal filters as applicable.
-   Basic charts where helpful.
-   Consistent date/timezone handling.
-   Reports must use the same calculation rules as the dashboard.
-   Provide export/download only after authorization and access checks.

### Phase 8: Subscription management

-   Free trial status.
-   Free/paid plan definitions.
-   Subscription status, start, and expiration dates.
-   Renewal handling.
-   Payment history.
-   Server-side plan restrictions.
-   Graceful handling of failed payments.
-   Read-only access to stored records after expiration.
-   Data preservation tests.

Payment gateway integration should follow only after core financial
operations and subscription state rules are stable.

## 8. Database and Financial Integrity

Design the database based on the features actually implemented.
Potential tables include: - `users` - `user_settings` - `workspaces` -
`workspace_members` - `accounts` - `categories` - `transactions` -
`contacts` - `contact_transactions` - `mess_meals` or an equivalent
meal-record structure - `mess_expenses` or appropriately categorized
transactions - `mess_member_payments` - `subscription_plans` -
`subscriptions` - `payment_records` - `notifications` - `audit_logs`

This list is a starting point, not a requirement to create every table
immediately.

### Database rules

-   Use Laravel migrations for schema changes.
-   Use foreign keys where appropriate and suitable indexes.
-   Use database transactions for multi-step financial operations.
-   Define explicit transaction types and statuses.
-   Prevent duplicate payment processing.
-   Preserve financial history where required.
-   Validate workspace ownership and membership.
-   Use database constraints where appropriate.
-   Document important financial relationships.
-   Do not store financial amounts using floating-point arithmetic. Use
    an appropriate fixed-precision decimal representation and consistent
    arithmetic.
-   Do not introduce breaking migrations without considering existing
    data.
-   Never run destructive migrations against production without explicit
    authorization and a safe, verified migration plan.

### Financial calculations

Clearly distinguish: - Income - Expense - Transfer - Receivable -
Payable - Payment settlement - Mess meal count - Shared mess expense -
Member contribution/payment - Member balance

A transfer between accounts owned by the same user must not increase
total income or expenses. Settling an existing due must not create
duplicate income or expenses. A mess member's payment/deposit must not
be counted again as a new sale or income if the accounting model treats
it as settlement of an existing obligation.

Do not calculate business profit simply as cash received minus cash paid
when outstanding payments or inventory accounting affect the result.
Label simplified figures clearly and document the rules.

## 9. Security Requirements

-   Use server-side authentication and authorization.
-   Validate every user-controlled input.
-   Apply CSRF protection to applicable web forms.
-   Use secure password hashing and sessions.
-   Apply rate limiting to sensitive endpoints.
-   Protect against SQL injection and cross-site scripting.
-   Use Eloquent and safe Blade output escaping.
-   Prevent users from accessing other users' records.
-   Enforce workspace membership and permissions.
-   Protect file uploads and report exports.
-   Never expose secrets or credentials in source control.
-   Keep production debug mode disabled.
-   Do not log passwords, authentication tokens, payment secrets, or
    sensitive financial details.
-   Maintain regular backups and document database restoration tests.
-   Do not trust client-side subscription state, role, amount, workspace
    ID, or payment result.
-   Enforce trial restrictions and subscription access on the server.
-   Keep user data private across Personal, Mess, and Business contexts.

Hisabi is initially a financial record management application. It must
not represent itself as a bank or independently hold, transfer, or
custody customer funds. Real-money payment processing and regulated
financial functionality require a separate compliance assessment.

## 10. Architecture and Code Quality

-   Follow Laravel conventions.
-   Use controllers for HTTP request handling.
-   Use Form Requests for complex validation.
-   Use Policies or Gates for authorization.
-   Use Eloquent relationships appropriately.
-   Keep business rules out of Blade templates.
-   Extract complex financial, meal-rate, and subscription logic into
    focused service classes when justified.
-   Use database transactions for operations that must succeed or fail
    together.
-   Keep routes organized and named.
-   Use reusable Blade components.
-   Avoid duplicate business logic and unnecessary abstractions.
-   Keep configuration in config files and environment variables.
-   Never hardcode production credentials.
-   Use shared calculation logic for dashboard summaries and reports so
    figures do not disagree.

## 11. Coding Agent Workflow

Follow this workflow for every implementation task.

### Step 1: Inspect

-   Read `AGENTS.md`.
-   Inspect the repository structure and Git status.
-   Review `composer.json`, `composer.lock`, `package.json`, and
    relevant lockfiles.
-   Identify the installed Laravel and PHP versions.
-   Check routes, models, migrations, controllers, middleware, views,
    assets, authentication, and tests.
-   Identify existing and incomplete features.

### Step 2: Plan

Before substantial changes: - Identify the exact feature. - List files
likely to change. - Identify database changes and data migration
needs. - Identify authorization requirements. - Identify
subscription/trial impacts where relevant. - Define tests and potential
regressions.

### Step 3: Implement

-   Make small, coherent changes.
-   Reuse existing functionality.
-   Create migrations for schema changes.
-   Add validation and authorization.
-   Build responsive Bengali-first UI.
-   Add tests for financial, workspace, trial, subscription, and
    data-preservation rules as relevant.

### Step 4: Verify

Run relevant available checks, such as: - `php artisan test` -
`php artisan route:list` - `php artisan migrate:status` -
`npm run build`

Check syntax, routes, views, database behavior, authorization, financial
calculations, responsive layout, and tests. Do not report a check as
successful unless it ran and passed. If a command cannot run due to
missing dependencies or infrastructure, explain the limitation. Never
run destructive tests against a production database.

### Step 5: Report

After each implementation task, summarize: - What was implemented. -
Files created or modified. - Database changes. - Commands and tests
executed. - Actual test results. - Known limitations. - Recommended next
task.

Do not silently skip failed tests or unresolved errors.

## 12. Testing Requirements

### Authentication and onboarding

-   Registration and login work.
-   Guests cannot access protected pages.
-   Password reset follows the configured flow.
-   Users can select a valid account type.
-   Invalid account types are rejected.
-   Trial start/expiration values are set server-side.

### Authorization and workspace isolation

-   Users cannot access other users' transactions.
-   Workspace members can access only authorized resources.
-   Unauthorized users cannot change another user's data.
-   Mess members cannot access another mess's private records.
-   Paid features cannot be accessed by unauthorized subscribers.

### Financial and mess tests

-   Income and expense totals are correct.
-   Account balances are correct.
-   Transfers do not create artificial income.
-   Partial payments update outstanding balances correctly.
-   Due settlements do not double-count transactions.
-   Invalid amounts are rejected.
-   Meal counts per member and per period are correct.
-   Total meals and meal rate are calculated correctly.
-   Member costs, payments, and remaining balances are correct.
-   Shared expenses follow the configured inclusion rules.
-   Monthly reports agree with dashboard calculations.
-   Duplicate payment callbacks do not duplicate financial records.

### Trial, subscription, and data preservation tests

-   Eligible new users receive one 30-day trial according to server-side
    rules.
-   Trial users receive the expected permitted features.
-   Expired trial users cannot perform restricted write operations.
-   Expired trial users can still view existing records in read-only
    mode where specified.
-   Expired subscriptions do not delete or alter existing financial
    records.
-   Existing data remains accessible after a verified subscription
    renewal.
-   Free users receive Free Plan permissions.
-   Active subscribers receive entitled features.
-   Expired subscriptions follow configured access rules.
-   Failed or unverified payments do not activate paid access.
-   Duplicate payment callbacks are idempotent.
-   Subscription limits are enforced server-side.

Use isolated test data and the appropriate testing database
configuration. Never run destructive test operations against a
production database.

## 13. Development Roadmap

Implement features in this order: 1. Project inspection and environment
setup. 2. Database and workspace/account-type planning. 3.
Authentication and account-type onboarding. 4. Trial and
subscription-state foundation. 5. UI design system and reusable
Bengali-first components. 6. Account-type-specific dashboards. 7.
Personal income and expense management. 8. Mess meal, market expense,
member payment, and settlement management. 9. Due management. 10.
Business accounting. 11. Reports and exports. 12. Automated testing and
security review. 13. Subscription plans and verified payment gateway
integration. 14. Production deployment. 15. PWA improvements. 16. Voice
entry and offline functionality. 17. Android application.

Do not start future phases before required earlier functionality is
stable. The exact order may be adjusted after project inspection, but
explain why.

## 14. Explicitly Avoid

Do not: - Build every proposed feature in the MVP. - Create unnecessary
tables or duplicate models. - Change frameworks or replace the frontend
stack without approval. - Invent undocumented financial or meal-rate
calculations. - Trust client-side validation or subscription status for
security. - Expose data across user accounts or workspaces. - Use fake
payment confirmations in production. - Add unnecessary dependencies. -
Generate large amounts of untested code. - Remove existing functionality
without justification. - Claim completion when important functionality
is missing. - Introduce breaking database changes without considering
existing data. - Store real payment credentials in the repository. -
Deploy to production or perform destructive operations without
authorization. - Delete user records because a free trial or
subscription expired. - Show complex features to users who do not need
them. - Use difficult accounting terminology when plain Bengali is
clearer.

## 15. Definition of Done

A feature is complete only when: - Its intended behavior is
implemented. - Validation is in place. - Authorization is enforced
server-side. - Relevant database changes are complete and safe. - The UI
works on desktop and mobile. - The UI is understandable to first-time
users and uses simple Bengali by default. - Important edge cases are
considered. - Relevant tests have been run and actual results
reported. - Existing functionality has not been unintentionally
broken. - Subscription restrictions preserve user data. - Known
limitations are documented. - The implementation summary is provided.

## 16. Final Instruction

Build Hisabi incrementally. Prioritize a simple, safe core experience
before advanced features.

Every user should see an interface tailored to their selected need:
Personal, Mess/Bachelor, or Business. Every financial and meal
calculation must have clear rules. Every protected operation must
enforce authorization on the server. A free trial or subscription
expiring may restrict paid operations, but **must never erase the user's
financial history**.

The goal is not to build the application with the most features. The
goal is to create the simplest, safest, and most useful accounting
application for everyday people, mess residents, and small businesses.
