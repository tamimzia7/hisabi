<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hisabi — ব্যক্তিগত, মেস ও ছোট ব্যবসার হিসাব সহজে পরিচালনা করার প্ল্যাটফর্ম।">
    <title>Hisabi - Mobile App</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --brand-navy: #0F172A;
            --brand-green: #10B981;
            --brand-green-hover: #059669;
            --bg-light: #F8FAFC;
            --white: #FFFFFF;
            --text-gray: #475569;
            --border-color: #E2E8F0;
            --light-green-bg: #ECFDF5;
            --bottom-nav-height: 65px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Hind Siliguri', sans-serif; -webkit-tap-highlight-color: transparent; }
        html { scroll-behavior: smooth; }
        body { background-color: var(--bg-light); color: var(--brand-navy); line-height: 1.6; overflow-x: hidden; width: 100%; }
        .container { width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .page-section { display: block; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes floatBadge { 0%, 100% { transform: translate(-50%, 0); } 50% { transform: translate(-50%, -5px); } }
        @keyframes pulseGlow { 0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); } 70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); } 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } }
        .section-padding { padding: 60px 0; }
        .section-title { font-size: 28px; color: var(--brand-navy); margin-bottom: 8px; text-align: center; font-weight: 700; line-height: 1.3; }
        .section-subtitle { color: var(--text-gray); margin-bottom: 32px; text-align: center; font-size: 15px; }
        .logo { font-size: 20px; font-weight: 700; color: var(--brand-navy); display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .logo svg { width: 32px; height: 32px; transition: transform 0.3s ease; }
        .logo:hover svg { transform: scale(1.1) rotate(5deg); }
        header { background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-color); padding: 12px 0; position: sticky; top: 0; z-index: 100; width: 100%; transition: box-shadow 0.3s ease; }
        header.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .nav-container { display: flex; justify-content: space-between; align-items: center; }
        .nav-links { display: none; }
        .header-btn { width: auto; padding: 8px 16px; font-size: 14px; border-radius: 8px; text-decoration: none; color: white; background-color: var(--brand-green); font-weight: 600; border: none; white-space: nowrap; }
        .header-actions { display: flex; gap: 10px; align-items: center; }
        .lang-link { font-size: 12px; color: var(--text-gray); text-decoration: none; white-space: nowrap; }
        .lang-link:hover { color: var(--brand-green); }
        .header-login { width: auto; padding: 8px 16px; font-size: 14px; white-space: nowrap; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 14px 20px; border-radius: 10px; font-weight: 600; text-decoration: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: none; cursor: pointer; font-size: 16px; width: 100%; }
        .btn-primary { background-color: var(--brand-green); color: var(--white); box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2); }
        .btn-primary:active { transform: scale(0.96); background-color: var(--brand-green-hover); }
        .btn-outline { background-color: transparent; color: var(--brand-navy); border: 1.5px solid var(--border-color); }
        .btn-outline:active { background-color: var(--bg-light); transform: scale(0.96); }
        body.has-bottom-nav { padding-bottom: 0; }
        .hero { padding-top: 50px; padding-bottom: 70px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; min-height: 65vh; }
        .hero-content { width: 100%; max-width: 700px; }
        .anim-hero-1 { opacity: 0; animation: fadeUp 0.8s ease-out 0.1s forwards; }
        .anim-hero-2 { opacity: 0; animation: fadeUp 0.8s ease-out 0.25s forwards; }
        .anim-hero-3 { opacity: 0; animation: fadeUp 0.8s ease-out 0.4s forwards; }
        .anim-hero-4 { opacity: 0; animation: fadeUp 0.8s ease-out 0.55s forwards; }
        .anim-hero-5 { opacity: 0; animation: fadeUp 0.8s ease-out 0.7s forwards; }
        .badge { display: inline-block; background-color: var(--light-green-bg); color: var(--brand-green); padding: 6px 14px; border-radius: 50px; font-size: 13px; font-weight: 600; margin-bottom: 20px; }
        .hero h1 { font-size: 34px; line-height: 1.25; color: var(--brand-navy); margin-bottom: 16px; font-weight: 700; }
        .hero h1 span { color: var(--brand-green); }
        .hero p { font-size: 16px; color: var(--text-gray); margin-bottom: 30px; padding: 0 10px; }
        .hero-buttons { display: flex; flex-direction: column; gap: 12px; margin-bottom: 30px; width: 100%; max-width: 400px; margin-left: auto; margin-right: auto; }
        .trust-badges { display: flex; justify-content: center; gap: 16px; color: var(--text-gray); font-size: 13px; flex-wrap: wrap; }
        .trust-badges span { display: flex; align-items: center; gap: 6px; }
        .trust-badges i { color: var(--brand-green); }
        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.5, 0, 0, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .delay-1 { transition-delay: 0.1s; } .delay-2 { transition-delay: 0.2s; } .delay-3 { transition-delay: 0.3s; } .delay-4 { transition-delay: 0.4s; }
        .features { background-color: var(--white); border-top: 1px solid var(--border-color); }
        .features-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .feature-card { padding: 20px 12px; border-radius: 12px; background-color: var(--bg-light); border: 1px solid var(--border-color); text-align: center; transition: all 0.3s ease; }
        .feature-icon { width: 48px; height: 48px; background-color: var(--light-green-bg); color: var(--brand-green); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin: 0 auto 12px; transition: all 0.4s ease; }
        .feature-card h3 { font-size: 15px; margin-bottom: 6px; }
        .feature-card p { font-size: 12px; color: var(--text-gray); line-height: 1.4; }
        .pricing { background-color: var(--bg-light); }
        .pricing-grid { display: flex; gap: 16px; overflow-x: auto; padding-bottom: 20px; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; padding-left: 20px; padding-right: 20px; margin: 0 -20px; }
        .pricing-grid::-webkit-scrollbar { display: none; }
        .pricing-card { flex: 0 0 85%; scroll-snap-align: center; background: var(--white); padding: 24px 20px; border-radius: 16px; border: 1px solid var(--border-color); text-align: center; position: relative; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .pricing-card.popular { border: 2px solid var(--brand-green); }
        .popular-badge { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--brand-green); color: var(--white); padding: 4px 14px; border-radius: 50px; font-size: 11px; font-weight: 600; white-space: nowrap; animation: floatBadge 2s ease-in-out infinite; }
        .pricing-card h3 { font-size: 20px; margin-bottom: 10px; }
        .price { font-size: 36px; font-weight: 700; color: var(--brand-navy); margin-bottom: 16px; }
        .price span { font-size: 13px; color: var(--text-gray); font-weight: 400; }
        .pricing-features { list-style: none; margin-bottom: 20px; text-align: left; }
        .pricing-features li { margin-bottom: 10px; color: var(--text-gray); display: flex; align-items: center; gap: 8px; font-size: 13px; }
        .pricing-features i { color: var(--brand-green); }
        .help-support { background-color: var(--white); }
        .help-grid { display: flex; flex-direction: column; gap: 30px; }
        .faq-column h3, .contact-column h3 { font-size: 20px; color: var(--brand-navy); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .faq-column h3 i, .contact-column h3 i { color: var(--brand-green); font-size: 18px; }
        .faq-item { border: 1px solid var(--border-color); border-radius: 10px; margin-bottom: 10px; overflow: hidden; transition: border-color 0.3s; }
        .faq-item.active { border-color: var(--brand-green); }
        .faq-question { width: 100%; padding: 16px; background: var(--bg-light); border: none; text-align: left; font-size: 14px; font-weight: 600; color: var(--brand-navy); cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
        .faq-question i { transition: transform 0.3s ease; font-size: 12px; }
        .faq-item.active .faq-question i { transform: rotate(180deg); color: var(--brand-green); }
        .faq-answer { padding: 0 16px; max-height: 0; overflow: hidden; transition: max-height 0.4s ease-out, padding 0.4s ease-out, opacity 0.4s ease-out; color: var(--text-gray); background: var(--white); font-size: 13px; opacity: 0; }
        .faq-item.active .faq-answer { padding: 16px; max-height: 250px; opacity: 1; }
        .contact-card-list { display: flex; flex-direction: column; gap: 10px; }
        .contact-card { background-color: var(--bg-light); border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 14px; text-decoration: none; transition: all 0.3s ease; }
        .contact-icon { width: 46px; height: 46px; background-color: var(--light-green-bg); color: var(--brand-green); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
        .contact-info h4 { font-size: 15px; color: var(--brand-navy); margin-bottom: 2px; }
        .contact-info p { font-size: 12px; color: var(--text-gray); margin-bottom: 2px; }
        .contact-info span { font-size: 14px; font-weight: 700; color: var(--brand-green); }
        footer { background-color: var(--brand-navy); color: var(--white); padding: 30px 0 20px; text-align: center; }
        .footer-grid { display: flex; flex-direction: column; gap: 24px; margin-bottom: 24px; }
        .footer-brand p { color: #94A3B8; font-size: 13px; margin: 10px 0 16px; }
        .social-links { display: flex; justify-content: center; gap: 10px; }
        .social-links a { width: 36px; height: 36px; background: rgba(255,255,255,0.1); color: var(--white); border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.3s ease; }
        .footer-col h4 { font-size: 15px; margin-bottom: 12px; color: var(--white); }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 8px; }
        .footer-col ul li a { color: #94A3B8; text-decoration: none; font-size: 13px; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 16px; color: #94A3B8; font-size: 12px; }
        .footer-bottom-links { margin-top: 10px; display: flex; justify-content: center; gap: 14px; }
        .footer-bottom-links a { color: #94A3B8; text-decoration: none; }
        .bottom-nav { position: fixed; bottom: 0; left: 0; width: 100%; height: var(--bottom-nav-height); background-color: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); border-top: 1px solid var(--border-color); display: flex; justify-content: space-around; align-items: center; z-index: 1000; box-shadow: 0 -2px 10px rgba(0,0,0,0.05); padding-bottom: env(safe-area-inset-bottom); }
        .bottom-nav-item { display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; color: var(--text-gray); font-size: 11px; font-weight: 500; gap: 4px; width: 25%; height: 100%; transition: color 0.3s ease; position: relative; cursor: pointer; }
        .bottom-nav-item i { font-size: 20px; transition: transform 0.3s ease; }
        .bottom-nav-item.active { color: var(--brand-green); }
        .bottom-nav-item.active i { transform: translateY(-2px); }
        .bottom-nav-item.active::before { content: ''; position: absolute; top: 0; width: 30px; height: 3px; background-color: var(--brand-green); border-radius: 0 0 4px 4px; }
        @media (max-width: 767px) {
            .nav-container { flex-wrap: wrap; gap: 8px; }
            .logo { font-size: 18px; }
            .logo svg { width: 28px; height: 28px; }
            .header-actions { gap: 6px; }
            .lang-link { font-size: 11px; }
            .header-login { padding: 7px 12px; font-size: 13px; }
            .header-btn { padding: 7px 12px; font-size: 13px; }
            .footer-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 26px 20px; text-align: left; }
            .footer-brand { grid-column: 1 / -1; text-align: center; }
            .footer-bottom { text-align: center; }
            footer { padding-bottom: calc(var(--bottom-nav-height) + 20px); }
        }
        @media (min-width: 768px) {
            .container { padding: 0 40px; }
            .section-padding { padding: 90px 0; }
            .section-title { font-size: 36px; }
            .section-subtitle { font-size: 18px; margin-bottom: 50px; }
            .btn { width: auto; padding: 14px 32px; border-radius: 8px; font-size: 16px; }
            header { padding: 16px 0; }
            .logo { font-size: 24px; }
            .logo svg { width: 36px; height: 36px; }
            .nav-links { display: flex; gap: 32px; align-items: center; }
            .nav-links a { text-decoration: none; color: var(--text-gray); font-weight: 500; font-size: 16px; transition: color 0.3s; cursor: pointer; }
            .nav-links a:hover { color: var(--brand-green); }
            .header-btn { padding: 10px 20px; font-size: 16px; }
            body.has-bottom-nav { padding-bottom: 0; }
            .bottom-nav { display: none; }
            .hero { padding-top: 120px; padding-bottom: 100px; min-height: 70vh; }
            .hero h1 { font-size: 56px; }
            .hero p { font-size: 20px; margin-bottom: 40px; }
            .hero-buttons { flex-direction: row; justify-content: center; gap: 16px; max-width: none; margin-bottom: 40px; }
            .trust-badges { gap: 24px; font-size: 15px; }
            .features-grid { grid-template-columns: repeat(4, 1fr); gap: 24px; }
            .feature-card { padding: 32px 24px; border-radius: 16px; }
            .feature-icon { width: 60px; height: 60px; font-size: 24px; margin-bottom: 20px; }
            .feature-card h3 { font-size: 18px; }
            .feature-card p { font-size: 14px; }
            .pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); overflow-x: visible; padding: 0; margin: 0; gap: 24px; align-items: center; }
            .pricing-card { padding: 40px 32px; border-radius: 16px; }
            .pricing-card.popular { transform: scale(1.05); }
            .price { font-size: 48px; }
            .pricing-features li { font-size: 15px; }
            .help-grid { flex-direction: row; gap: 50px; }
            .faq-column, .contact-column { flex: 1; }
            .faq-column h3, .contact-column h3 { font-size: 24px; }
            .faq-question { font-size: 16px; padding: 18px; }
            .contact-card { padding: 20px; }
            footer { padding: 60px 0 30px; }
            .footer-grid { flex-direction: row; text-align: left; justify-content: space-between; gap: 40px; }
            .social-links { justify-content: flex-start; }
            .footer-bottom { display: flex; justify-content: space-between; align-items: center; }
            .footer-bottom-links { margin-top: 0; }
        }
    </style>
</head>
<body class="has-bottom-nav">

    <header id="header">
        <div class="container nav-container">
            <a href="#home" class="logo">
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
            <nav class="nav-links">
                <a href="#features">ফিচার</a>
                <a href="#pricing">প্রাইসিং</a>
                <a href="#help-support">সাপোর্ট</a>
            </nav>
            <div class="header-actions">
                <a href="{{ route('language.switch', 'bn') }}" class="lang-link">বাংলা</a>
                <a href="{{ route('language.switch', 'en') }}" class="lang-link">English</a>
                <a href="{{ route('login') }}" class="btn btn-outline header-login">লগইন</a>
                <a href="{{ route('register') }}" class="btn header-btn">ফ্রি শুরু</a>
            </div>
        </div>
    </header>

    <section class="hero container" id="home">
        <div class="hero-content">
            <span class="badge anim-hero-1"><i class="fa-solid fa-shield-halved"></i> ১০০% নিরাপদ ফিনটেক</span>
            <h1 class="anim-hero-2">আপনার সব হিসাব<br>এখন <span>হাতের মুঠোয়</span></h1>
            <p class="anim-hero-3">Hisabi আপনার দৈনন্দিন আয়-ব্যয়, স্টক, বাকি এবং আর্থিক রিপোর্ট ম্যানেজমেন্টকে করেছে আরও সহজ এবং নিরাপদ।</p>
            <div class="hero-buttons anim-hero-4">
                <a href="{{ route('register') }}" class="btn btn-primary">ফ্রি শুরু করুন <i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i></a>
                <a href="#features" class="btn btn-outline">ফিচার দেখুন</a>
            </div>
            <div class="trust-badges anim-hero-5">
                <span><i class="fa-solid fa-shield"></i> নিরাপদ</span>
                <span><i class="fa-solid fa-mobile-screen"></i> মোবাইল ফ্রেন্ডলি</span>
                <span><i class="fa-solid fa-headset"></i> ২৪/৭ সাপোর্ট</span>
            </div>
        </div>
    </section>

    <section id="features" class="features section-padding">
        <div class="container">
            <h2 class="section-title reveal">কেন Hisabi?</h2>
            <p class="section-subtitle reveal delay-1">সাধারণ মানুষের জন্য, ছোট ব্যবসার জন্য – একটাই সমাধান।</p>
            <div class="features-grid">
                <div class="feature-card reveal delay-1"><div class="feature-icon"><i class="fa-solid fa-feather"></i></div><h3>সহজ ব্যবহার</h3><p>নিজেই সব পরিচালনা করুন।</p></div>
                <div class="feature-card reveal delay-2"><div class="feature-icon"><i class="fa-solid fa-mobile-button"></i></div><h3>মোবাইল ফ্রেন্ডলি</h3><p>যেকোনো সময় অ্যাক্সেস করুন।</p></div>
                <div class="feature-card reveal delay-3"><div class="feature-icon"><i class="fa-solid fa-lock"></i></div><h3>নিরাপদ</h3><p>আপনার তথ্য সুরক্ষিত থাকে।</p></div>
                <div class="feature-card reveal delay-4"><div class="feature-icon"><i class="fa-solid fa-users"></i></div><h3>সবার জন্য</h3><p>ব্যক্তিগত ও ব্যবসার জন্য।</p></div>
            </div>
        </div>
    </section>

    <section id="pricing" class="pricing section-padding">
        <div class="container">
            <h2 class="section-title reveal">সহজ ও সাশ্রয়ী প্যাকেজ</h2>
            <p class="section-subtitle reveal delay-1">আপনার প্রয়োজন অনুযায়ী সঠিক প্ল্যানটি বেছে নিন।</p>
            <div class="pricing-grid">
                <div class="pricing-card reveal delay-1">
                    <h3>বেসিক</h3>
                    <div class="price">৳ ০<span>/মাস</span></div>
                    <ul class="pricing-features">
                        <li><i class="fa-solid fa-check"></i> দৈনিক ৫০টি এন্ট্রি</li>
                        <li><i class="fa-solid fa-check"></i> সাধারণ রিপোর্ট</li>
                        <li><i class="fa-solid fa-check"></i> ১ জন ইউজার</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-outline">ফ্রি শুরু করুন</a>
                </div>
                @forelse ($plans as $plan)
                    <div class="pricing-card popular reveal delay-2">
                        <div class="popular-badge">সবচেয়ে জনপ্রিয়</div>
                        <h3>{{ $plan->name }}</h3>
                        <div class="price">{{ $plan->price }}<span>/{{ $plan->duration_days }} দিন</span></div>
                        <ul class="pricing-features">
                            @if ($plan->description)
                                <li><i class="fa-solid fa-check"></i> {{ $plan->description }}</li>
                            @endif
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary" style="animation: pulseGlow 2s infinite;">কিনুন</a>
                    </div>
                @empty
                    <div class="pricing-card reveal delay-2">
                        <h3>প্ল্যান নেই</h3>
                        <p class="text-sm text-gray-500">কনফিগার করা হলে দেখাবে।</p>
                    </div>
                @endforelse
                <div class="pricing-card reveal delay-3">
                    <h3>বিজনেস</h3>
                    <div class="price">৳ ৯৯৯<span>/মাস</span></div>
                    <ul class="pricing-features">
                        <li><i class="fa-solid fa-check"></i> সব ফিচার আনলকড</li>
                        <li><i class="fa-solid fa-check"></i> কাস্টম রিপোর্ট</li>
                        <li><i class="fa-solid fa-check"></i> আনলিমিটেড ইউজার</li>
                        <li><i class="fa-solid fa-check"></i> ডেডিকেটেড ম্যানেজার</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn btn-outline">যোগাযোগ করুন</a>
                </div>
            </div>
        </div>
    </section>

    <section id="help-support" class="help-support section-padding">
        <div class="container">
            <h2 class="section-title reveal">সাহায্য ও যোগাযোগ</h2>
            <p class="section-subtitle reveal delay-1">আপনার প্রশ্নের উত্তর খুঁজুন অথবা সরাসরি আমাদের সাথে কথা বলুন।</p>
            <div class="help-grid">
                <div class="faq-column reveal delay-1">
                    <h3><i class="fa-solid fa-circle-question"></i> সাধারণ জিজ্ঞাসা</h3>
                    <div class="faq-grid">
                        <div class="faq-item"><button class="faq-question">Hisabi ব্যবহার করতে কি টাকা লাগে? <i class="fa-solid fa-chevron-down"></i></button><div class="faq-answer"><p>না, Hisabi-এর বেসিক প্ল্যান সম্পূর্ণ ফ্রি। তবে আপনি চাইলে প্রিমিয়াম ফিচারের জন্য সাবস্ক্রাইব করতে পারেন।</p></div></div>
                        <div class="faq-item"><button class="faq-question">আমার তথ্য কি নিরাপদ? <i class="fa-solid fa-chevron-down"></i></button><div class="faq-answer"><p>অবশ্যই। আমরা ব্যাংক-লেভেল এনক্রিপশন ব্যবহার করি, তাই আপনার আর্থিক তথ্য সম্পূর্ণ সুরক্ষিত থাকে।</p></div></div>
                        <div class="faq-item"><button class="faq-question">মোবাইল থেকে ব্যবহার করা যাবে? <i class="fa-solid fa-chevron-down"></i></button><div class="faq-answer"><p>হ্যাঁ, Hisabi সম্পূর্ণ মোবাইল-ফ্রেন্ডলি। আপনি যেকোনো স্মার্টফোন বা ট্যাবলেট থেকে সহজেই ব্যবহার করতে পারবেন।</p></div></div>
                        <div class="faq-item"><button class="faq-question">কিভাবে শুরু করবো? <i class="fa-solid fa-chevron-down"></i></button><div class="faq-answer"><p>শুধু "ফ্রি শুরু করুন" বাটনে ক্লিক করে আপনার মোবাইল নম্বর বা ইমেইল দিয়ে অ্যাকাউন্ট খুলুন, ব্যস!</p></div></div>
                    </div>
                </div>
                <div class="contact-column reveal delay-2">
                    <h3><i class="fa-solid fa-headset"></i> সরাসরি যোগাযোগ</h3>
                    <div class="contact-card-list">
                        <a href="tel:+8801700000000" class="contact-card">
                            <div class="contact-icon"><i class="fa-solid fa-phone-volume"></i></div>
                            <div class="contact-info">
                                <h4>ফোনে কল করুন</h4>
                                <p>সকাল ৯টা - রাত ৯টা</p>
                                <span>+৮৮০ ১৭০০ ০০০ ০০০</span>
                            </div>
                        </a>
                        <a href="mailto:support@hisabi.com" class="contact-card">
                            <div class="contact-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
                            <div class="contact-info">
                                <h4>ইমেইল করুন</h4>
                                <p>২৪ ঘন্টার মধ্যে উত্তর</p>
                                <span>support@hisabi.com</span>
                            </div>
                        </a>
                        <a href="https://wa.me/8801700000000" target="_blank" class="contact-card">
                            <div class="contact-icon"><i class="fa-brands fa-whatsapp"></i></div>
                            <div class="contact-info">
                                <h4>হোয়াটসঅ্যাপ</h4>
                                <p>দ্রুত মেসেজে সাহায্য নিন</p>
                                <span>+৮৮০ ১৭০০ ০০০ ০০০</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="#home" class="logo" style="color: var(--white); justify-content: center;">
                        <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100" height="100" rx="24" fill="#10B981"/>
                            <path d="M30 25V75" stroke="white" stroke-width="10" stroke-linecap="round"/>
                            <path d="M70 25V75" stroke="white" stroke-width="10" stroke-linecap="round"/>
                            <path d="M30 50H70" stroke="white" stroke-width="10" stroke-linecap="round"/>
                            <path d="M45 35V25" stroke="#0F172A" stroke-width="6" stroke-linecap="round"/>
                            <path d="M55 45V25" stroke="#0F172A" stroke-width="6" stroke-linecap="round"/>
                            <path d="M65 40V25" stroke="#0F172A" stroke-width="6" stroke-linecap="round"/>
                        </svg>
                        Hisabi
                    </a>
                    <p>আপনার দৈনন্দিন আয়-ব্যয় এবং ব্যবসার হিসাব রাখার সবচেয়ে সহজ ও নিরাপদ মাধ্যম।</p>
                    <div class="social-links">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>কোম্পানি</h4>
                    <ul>
                        <li><a href="#">আমাদের সম্পর্কে</a></li>
                        <li><a href="#">ক্যারিয়ার</a></li>
                        <li><a href="#">ব্লগ</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>সাপোর্ট</h4>
                    <ul>
                        <li><a href="#help-support">সাধারণ জিজ্ঞাসা</a></li>
                        <li><a href="#">সাহায্য কেন্দ্র</a></li>
                        <li><a href="#help-support">যোগাযোগ</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>আইনগত</h4>
                    <ul>
                        <li><a href="#">গোপনীয়তা নীতি</a></li>
                        <li><a href="#">ব্যবহারের শর্তাবলী</a></li>
                        <li><a href="#">রিফান্ড পলিসি</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Hisabi. সর্বস্বত্ব সংরক্ষিত।</p>
                <div class="footer-bottom-links">
                    <a href="#">গোপনীয়তা নীতি</a>
                    <a href="#">ব্যবহারের শর্তাবলী</a>
                </div>
            </div>
        </div>
    </footer>

    <div class="bottom-nav">
        <a href="#home" class="bottom-nav-item active">
            <i class="fa-solid fa-house"></i>
            <span>হোম</span>
        </a>
        <a href="#features" class="bottom-nav-item">
            <i class="fa-solid fa-layer-group"></i>
            <span>ফিচার</span>
        </a>
        <a href="#pricing" class="bottom-nav-item">
            <i class="fa-solid fa-tags"></i>
            <span>প্রাইসিং</span>
        </a>
        <a href="{{ route('login') }}" class="bottom-nav-item">
            <i class="fa-solid fa-user"></i>
            <span>লগইন</span>
        </a>
    </div>

    <script>
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                const isActive = faqItem.classList.contains('active');
                document.querySelectorAll('.faq-item').forEach(item => item.classList.remove('active'));
                if (!isActive) faqItem.classList.add('active');
            });
        });
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('active');
            });
        }, { threshold: 0.15 });
        revealElements.forEach(el => revealObserver.observe(el));
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) header.classList.add('scrolled');
            else header.classList.remove('scrolled');
        });
    </script>
</body>
</html>
