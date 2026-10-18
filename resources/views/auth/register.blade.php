<x-layouts.auth>
    <div class="auth-wrapper">
        <style>.compact .form-group{margin-bottom:12px;} .compact .form-control{padding:10px 12px 10px 40px;font-size:14px;} .compact .auth-header{margin-bottom:16px;} .compact .auth-header h2{font-size:20px;} .compact .auth-header p{font-size:13px;}</style>
        <div class="auth-card compact" style="max-width: 760px; padding: 24px 20px;">
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
                <h2>অ্যাকাউন্ট তৈরি করুন</h2>
                <p>মাত্র ১ মিনিটে ফ্রি অ্যাকাউন্ট খুলুন</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <style>@media (max-width: 640px){ .reg-grid{grid-template-columns: 1fr !important;} }</style>
                <div class="reg-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <!-- Left column -->
                    <div>
                        <div class="form-group">
                            <label for="name">আপনার নাম</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-user"></i>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control" placeholder="পুরো নাম লিখুন" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">ইমেইল</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-envelope"></i>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control" placeholder="আপনার ইমেইল" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">পাসওয়ার্ড</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-lock"></i>
                                <input id="password" name="password" type="password" class="form-control" placeholder="পাসওয়ার্ড তৈরি করুন" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">পাসওয়ার্ড আবার লিখুন</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-lock"></i>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="পাসওয়ার্ড নিশ্চিত করুন" required>
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                    <div>
                        <div class="form-group">
                            <label>হিসাবের ধরন</label>
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <label class="checkbox-label" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 10px;">
                                    <input type="radio" name="account_type" value="personal" {{ old('account_type') === 'personal' ? 'checked' : '' }} required>
                                    Personal হিসাব
                                </label>
                                <label class="checkbox-label" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 10px;">
                                    <input type="radio" name="account_type" value="mess" {{ old('account_type') === 'mess' ? 'checked' : '' }} required>
                                    মেস / ব্যাচেলর হিসাব
                                </label>
                                <label class="checkbox-label" style="padding: 10px; border: 1px solid var(--border-color); border-radius: 10px;">
                                    <input type="radio" name="account_type" value="business" {{ old('account_type') === 'business' ? 'checked' : '' }} required>
                                    ব্যবসার হিসাব
                                </label>
                            </div>
                            @error('account_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-options" style="justify-content: flex-start;">
                            <label class="checkbox-label">
                                <input type="checkbox" required> আমি শর্তাবলী মেনে নিচ্ছি
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 16px;">রেজিস্ট্রেশন করুন</button>

                <div class="auth-footer">
                    আগে থেকেই অ্যাকাউন্ট আছে? <a href="{{ route('login') }}">লগইন করুন</a>
                </div>
            </form>

            <div style="text-align: center;">
                <a href="{{ route('home') }}" class="back-home"><i class="fa-solid fa-arrow-left"></i> হোমে ফিরে যান</a>
            </div>
        </div>
    </div>
</x-layouts.auth>
