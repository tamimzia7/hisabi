<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Hisabi') }}</title>
    <link rel="icon" href="{{ asset('icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Hind Siliguri', sans-serif; -webkit-tap-highlight-color: transparent; }
        body { background-color: var(--bg-light); color: var(--brand-navy); line-height: 1.6; overflow-x: hidden; width: 100%; }
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: var(--bg-light); padding: 20px; }
        .auth-card { background-color: var(--white); width: 100%; max-width: 420px; padding: 40px 30px; border-radius: 24px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08); border: 1px solid var(--border-color); animation: fadeUp 0.5s ease-out; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .auth-header { text-align: center; margin-bottom: 30px; }
        .auth-header .logo { justify-content: center; margin-bottom: 16px; font-size: 26px; display: flex; align-items: center; gap: 8px; text-decoration: none; color: var(--brand-navy); font-weight: 700; }
        .auth-header .logo svg { width: 36px; height: 36px; }
        .auth-header h2 { font-size: 24px; color: var(--brand-navy); margin-bottom: 8px; }
        .auth-header p { font-size: 14px; color: var(--text-gray); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; color: var(--brand-navy); margin-bottom: 8px; }
        .input-wrapper { position: relative; display: flex; align-items: center; }
        .input-wrapper i { position: absolute; left: 16px; color: var(--text-gray); font-size: 16px; }
        .form-control { width: 100%; padding: 14px 16px 14px 45px; border: 1.5px solid var(--border-color); border-radius: 12px; font-size: 15px; font-family: inherit; color: var(--brand-navy); background-color: var(--bg-light); transition: all 0.3s; }
        .form-control:focus { outline: none; border-color: var(--brand-green); background-color: var(--white); box-shadow: 0 0 0 4px var(--light-green-bg); }
        .form-options { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 13px; }
        .checkbox-label { display: flex; align-items: center; gap: 8px; color: var(--text-gray); cursor: pointer; }
        .checkbox-label input { accent-color: var(--brand-green); width: 16px; height: 16px; }
        .form-options a { color: var(--brand-green); text-decoration: none; font-weight: 600; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 14px 20px; border-radius: 10px; font-weight: 600; text-decoration: none; transition: all 0.3s; border: none; cursor: pointer; font-size: 16px; width: 100%; }
        .btn-primary { background-color: var(--brand-green); color: var(--white); }
        .btn-primary:active { transform: scale(0.96); background-color: var(--brand-green-hover); }
        .auth-footer { text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-gray); }
        .auth-footer a { color: var(--brand-green); font-weight: 700; text-decoration: none; }
        .back-home { display: inline-block; margin-top: 20px; color: var(--text-gray); text-decoration: none; font-size: 14px; }
        .back-home:hover { color: var(--brand-green); }
    </style>
</head>
<body>
    {{ $slot }}
</body>
</html>
