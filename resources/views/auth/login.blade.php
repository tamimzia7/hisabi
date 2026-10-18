<x-layouts.auth>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <a href="{{ route('home') }}" class="logo">
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100" height="100" rx="24" fill="#ECFDF5"/>
                        <path d="M30 25V75" stroke="#10B981" stroke-width="12" stroke-linecap="round"/>
                        <path d="M70 25V75" stroke="#10B981" stroke-width="12" stroke-linecap="round"/>
                        <path d="M30 50H70" stroke="#10B981" stroke-width="12" stroke-linecap="round"/>
                        <path d="M45 35V25" stroke="#0F172A" stroke-width="8" stroke-linecap="round"/>
                        <path d="M55 45V25" stroke="#0F172A" stroke-width="8" stroke-linecap="round"/>
                        <path d="M65 40V25" stroke="#0F172A" stroke-width="8" stroke-linecap="round"/>
                    </svg>
                    Hisabi
                </a>
                <h2>{{ __('লগইন') }}</h2>
                <p>{{ __('আপনার হিসাবে প্রবেশ করুন।') }}</p>
                <div style="margin-top:8px; font-size:12px;">
                    <a href="{{ route('language.switch', 'bn') }}">বাংলা</a> |
                    <a href="{{ route('language.switch', 'en') }}">English</a>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-lg bg-[#ECFDF5] p-3 text-sm text-[#059669]">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">{{ __('ইমেইল') }}</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control" placeholder="আপনার ইমেইল" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">{{ __('পাসওয়ার্ড') }}</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input id="password" name="password" type="password" class="form-control" placeholder="পাসওয়ার্ড লিখুন" required>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" value="1"> {{ __('মনে রাখুন') }}
                    </label>
                    <a href="{{ route('password.request') }}">{{ __('পাসওয়ার্ড ভুলে গেছেন?') }}</a>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('লগইন করুন') }}</button>

                <div class="auth-footer">
                    {{ __('নতুন ব্যবহারকারী?') }} <a href="{{ route('register') }}">{{ __('রেজিস্ট্রেশন করুন') }}</a>
                </div>
            </form>

            <div style="text-align: center;">
                <a href="{{ route('home') }}" class="back-home"><i class="fa-solid fa-arrow-left"></i> {{ __('হোমে ফিরে যান') }}</a>
            </div>
        </div>
    </div>
</x-layouts.auth>
