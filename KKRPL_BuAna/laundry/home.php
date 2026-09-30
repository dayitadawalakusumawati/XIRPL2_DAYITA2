<?php
session_start();
$show_login = isset($_GET['login']) || isset($_GET['pesan']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi WashClean</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; }
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --accent: #06b6d4;
            --dark: #0f172a;
            --gray: #64748b;
            --light: #f0fdf4;
        }
        html { scroll-behavior: smooth; }
        body { line-height: 1.6; color: #1e293b; overflow-x: hidden; }

        .blob { position: fixed; border-radius: 50%; filter: blur(80px); opacity: 0.35; z-index: -1; pointer-events: none; }
        .blob-1 { width: 500px; height: 500px; background: #6ee7b7; top: -200px; left: -200px; animation: blobFloat 15s ease-in-out infinite; }
        .blob-2 { width: 400px; height: 400px; background: #67e8f9; bottom: -150px; right: -150px; animation: blobFloat 20s ease-in-out infinite reverse; }
        @keyframes blobFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(50px, -50px) scale(1.1); }
            66% { transform: translate(-30px, 30px) scale(0.9); }
        }

        nav { position: fixed; top: 0; width: 100%; padding: 1.2rem 5%; display: flex; justify-content: space-between; align-items: center; z-index: 1000; transition: all 0.4s; }
        nav.scrolled { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); box-shadow: 0 4px 30px rgba(0,0,0,0.08); padding: 0.8rem 5%; }
        .logo { display: flex; align-items: center; gap: 0.5rem; font-size: 1.4rem; font-weight: 800; color: var(--dark); }
        .logo-icon { width: 38px; height: 38px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }
        .logo-text span { color: var(--primary); }
        .nav-links { display: flex; gap: 2rem; list-style: none; }
        .nav-links a { text-decoration: none; color: var(--dark); font-weight: 600; font-size: 0.93rem; position: relative; transition: color 0.3s; }
        .nav-links a::after { content: ''; position: absolute; bottom: -5px; left: 0; width: 0; height: 2px; background: var(--primary); transition: width 0.3s; }
        .nav-links a:hover { color: var(--primary); }
        .nav-links a:hover::after { width: 100%; }

        .btn { padding: 0.7rem 1.5rem; border-radius: 50px; border: none; cursor: pointer; font-weight: 700; font-family: inherit; font-size: 0.9rem; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; white-space: nowrap; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4); }
        .btn-outline { background: white; color: var(--dark); border: 2px solid #e2e8f0; }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); transform: translateY(-3px); }

        .user-menu { position: relative; }
        .user-btn { display: flex; align-items: center; gap: 0.6rem; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; padding: 0.5rem 1rem 0.5rem 0.5rem; border-radius: 50px; cursor: pointer; border: none; font-family: inherit; font-weight: 700; font-size: 0.9rem; transition: all 0.3s; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }
        .user-btn:hover { transform: translateY(-2px); }
        .avatar { width: 32px; height: 32px; background: white; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; }
        .dropdown { position: absolute; top: 115%; right: 0; background: white; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.12); min-width: 200px; padding: 0.5rem; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s; }
        .user-menu:hover .dropdown { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown a { display: block; padding: 0.75rem 1rem; color: var(--dark); text-decoration: none; border-radius: 10px; font-size: 0.9rem; font-weight: 600; transition: background 0.2s; }
        .dropdown a:hover { background: var(--light); color: var(--primary); }
        .dropdown .logout-link { color: #ef4444; }
        .dropdown .logout-link:hover { background: #fee2e2; }

        .login-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center; z-index: 2000; padding: 1rem; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .login-box { background: white; padding: 2.5rem; border-radius: 24px; width: 100%; max-width: 420px; box-shadow: 0 30px 60px rgba(0,0,0,0.3); animation: popIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); position: relative; }
        @keyframes popIn { from { opacity: 0; transform: scale(0.85) translateY(30px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .close-btn { position: absolute; top: 1rem; right: 1rem; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; font-size: 1rem; color: var(--gray); transition: all 0.2s; display: flex; align-items: center; justify-content: center; text-decoration: none; }
        .close-btn:hover { background: #e2e8f0; color: var(--dark); transform: rotate(90deg); }
        .login-box h2 { text-align: center; color: var(--dark); margin-bottom: 0.3rem; font-size: 1.6rem; font-weight: 800; }
        .login-box p.subtitle { text-align: center; color: var(--gray); margin-bottom: 1.8rem; font-size: 0.9rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--dark); font-weight: 600; font-size: 0.85rem; }
        .form-group input { width: 100%; padding: 0.85rem 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; font-family: inherit; transition: all 0.3s; background: #f8fafc; }
        .form-group input:focus { outline: none; border-color: var(--primary); background: white; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
        .btn-login { width: 100%; padding: 0.95rem; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 700; cursor: pointer; font-family: inherit; transition: all 0.3s; margin-top: 0.5rem; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(16, 185, 129, 0.4); }
        .alert { padding: 0.85rem 1rem; border-radius: 12px; font-size: 0.9rem; margin-bottom: 1rem; text-align: center; font-weight: 600; }
        .alert-danger { background: #fee2e2; color: #dc2626; }
        .alert-info { background: #dbeafe; color: #2563eb; }

        .hero { min-height: 100vh; display: flex; align-items: center; padding: 120px 5% 60px; position: relative; }
        .hero-content { display: grid; grid-template-columns: 1.1fr 1fr; gap: 4rem; align-items: center; max-width: 1200px; margin: 0 auto; width: 100%; }
        .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: white; border: 1px solid #e2e8f0; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; color: var(--dark); margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05); animation: slideUp 0.8s ease; }
        .hero-badge .dot { width: 8px; height: 8px; background: var(--primary); border-radius: 50%; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.3); } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .hero-text h1 { font-size: 3.8rem; line-height: 1.1; margin-bottom: 1.5rem; color: var(--dark); font-weight: 800; letter-spacing: -1.5px; animation: slideUp 0.8s ease 0.1s backwards; }
        .hero-text h1 .gradient { background: linear-gradient(135deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-text > p { font-size: 1.1rem; color: var(--gray); margin-bottom: 2rem; max-width: 500px; animation: slideUp 0.8s ease 0.2s backwards; }
        .hero-buttons { display: flex; gap: 1rem; flex-wrap: wrap; animation: slideUp 0.8s ease 0.3s backwards; }
        .hero-trust { display: flex; align-items: center; gap: 1.5rem; margin-top: 2.5rem; animation: slideUp 0.8s ease 0.4s backwards; }
        .avatars { display: flex; }
        .avatars .av { width: 40px; height: 40px; border-radius: 50%; border: 3px solid white; margin-left: -12px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: white; font-size: 0.85rem; }
        .avatars .av:first-child { margin-left: 0; }
        .av-1 { background: linear-gradient(135deg, #f59e0b, #ef4444); }
        .av-2 { background: linear-gradient(135deg, #8b5cf6, #ec4899); }
        .av-3 { background: linear-gradient(135deg, #10b981, #06b6d4); }
        .av-4 { background: linear-gradient(135deg, #3b82f6, #6366f1); }
        .trust-text { font-size: 0.85rem; color: var(--gray); font-weight: 600; }
        .trust-text strong { color: var(--dark); font-size: 1rem; }

        .hero-visual { position: relative; display: flex; justify-content: center; align-items: center; min-height: 500px; animation: slideUp 0.8s ease 0.3s backwards; }
        .hero-main-card { width: 100%; max-width: 380px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 32px; padding: 2.5rem 2rem; color: white; text-align: center; box-shadow: 0 30px 60px rgba(16, 185, 129, 0.35); position: relative; z-index: 2; animation: floatMain 4s ease-in-out infinite; }
        @keyframes floatMain { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        .hero-main-card .big-emoji { font-size: 6rem; display: inline-block; margin-bottom: 1rem; animation: spinSlow 8s linear infinite; }
        @keyframes spinSlow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .hero-main-card h3 { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem; }
        .hero-main-card p { font-size: 0.95rem; opacity: 0.9; }
        .hero-main-card .pill { display: inline-block; background: rgba(255,255,255,0.25); backdrop-filter: blur(10px); padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; margin-top: 1rem; border: 1px solid rgba(255,255,255,0.3); }

        .float-card { position: absolute; background: white; border-radius: 20px; padding: 0.9rem 1.1rem; box-shadow: 0 20px 40px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 0.7rem; z-index: 3; border: 1px solid #f1f5f9; }
        .float-card .fc-icon { width: 38px; height: 38px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .float-card .fc-text strong { display: block; font-size: 0.8rem; color: var(--dark); font-weight: 700; }
        .float-card .fc-text span { font-size: 0.7rem; color: var(--gray); }
        .fc-1 { top: 8%; left: -5%; animation: floatCard1 5s ease-in-out infinite; }
        .fc-1 .fc-icon { background: #dcfce7; }
        .fc-2 { bottom: 12%; right: -8%; animation: floatCard2 6s ease-in-out infinite; }
        .fc-2 .fc-icon { background: #cffafe; }
        .fc-3 { top: 45%; right: -3%; animation: floatCard1 7s ease-in-out infinite; }
        .fc-3 .fc-icon { background: #fef3c7; }
        @keyframes floatCard1 { 0%, 100% { transform: translateY(0) rotate(-2deg); } 50% { transform: translateY(-15px) rotate(2deg); } }
        @keyframes floatCard2 { 0%, 100% { transform: translateY(0) rotate(2deg); } 50% { transform: translateY(-20px) rotate(-2deg); } }

        /* ===== SECTION ===== */
.section { padding: 6rem 5%; }
.section-title { text-align: center; margin-bottom: 4rem; }
.section-tag { display: inline-block; background: var(--light); color: var(--primary-dark); padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; border: 1px solid rgba(16, 185, 129, 0.2); }
.section-title h2 { font-size: 2.8rem; color: var(--dark); margin-bottom: 1rem; font-weight: 800; letter-spacing: -1px; }
.section-title p { color: var(--gray); font-size: 1.05rem; max-width: 600px; margin: 0 auto; }

/* ===== STATS ===== */
.stats { padding: 4rem 5%; background: var(--dark); color: white; position: relative; overflow: hidden; }
.stats::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.2), transparent 50%), radial-gradient(circle at 80% 50%, rgba(6, 182, 212, 0.15), transparent 50%); }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto; position: relative; z-index: 2; text-align: center; }
.stat-item h3 { font-size: 3rem; font-weight: 800; background: linear-gradient(135deg, #34d399, #06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 0.3rem; letter-spacing: -1px; }
.stat-item p { color: #94a3b8; font-size: 0.9rem; font-weight: 600; }

/* ===== CARA KERJA ===== */
.steps-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 2rem; max-width: 1100px; margin: 0 auto; }
.step-card { background: white; padding: 2.5rem 2rem; border-radius: 24px; text-align: center; transition: all 0.4s; border: 1px solid #f1f5f9; position: relative; opacity: 0; transform: translateY(30px); }
.step-card.visible { opacity: 1; transform: translateY(0); }
.step-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(16, 185, 129, 0.15); border-color: var(--primary); }
.step-number { position: absolute; top: -18px; left: 50%; transform: translateX(-50%); width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); border: 4px solid white; }
.step-icon { width: 80px; height: 80px; background: var(--light); border-radius: 24px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 1rem auto 1.5rem; }
.step-card h3 { margin-bottom: 0.8rem; color: var(--dark); font-weight: 800; font-size: 1.2rem; }
.step-card p { color: var(--gray); font-size: 0.95rem; }

/* ===== FEATURES ===== */
.features { background: #f8fafc; }
.features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; max-width: 1200px; margin: 0 auto; }
.feature-card { background: white; padding: 2rem; border-radius: 24px; transition: all 0.4s; border: 1px solid #f1f5f9; opacity: 0; transform: translateY(30px); }
.feature-card.visible { opacity: 1; transform: translateY(0); }
.feature-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px rgba(16, 185, 129, 0.12); border-color: rgba(16, 185, 129, 0.3); }
.feature-icon { width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.7rem; margin-bottom: 1.3rem; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.25); }
.feature-card h3 { margin-bottom: 0.6rem; color: var(--dark); font-weight: 800; font-size: 1.15rem; }
.feature-card p { color: var(--gray); font-size: 0.92rem; }

/* ===== TESTIMONI ===== */
.testimoni-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; max-width: 1100px; margin: 0 auto; }
.testi-card { background: white; padding: 2rem; border-radius: 24px; border: 1px solid #f1f5f9; transition: all 0.4s; opacity: 0; transform: translateY(30px); }
.testi-card.visible { opacity: 1; transform: translateY(0); }
.testi-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
.stars { color: #fbbf24; margin-bottom: 1rem; font-size: 1.1rem; }
.testi-text { color: var(--dark); font-size: 0.95rem; margin-bottom: 1.5rem; line-height: 1.7; font-style: italic; }
.testi-user { display: flex; align-items: center; gap: 0.8rem; }
.testi-avatar { width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 1.1rem; }
.testi-user strong { display: block; color: var(--dark); font-size: 0.95rem; font-weight: 700; }
.testi-user span { color: var(--gray); font-size: 0.8rem; }

/* ===== PRICING ===== */
.pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; max-width: 1100px; margin: 0 auto; }
.price-card { background: white; padding: 2.5rem 2rem; border-radius: 28px; text-align: center; border: 2px solid #f1f5f9; transition: all 0.4s; position: relative; opacity: 0; transform: translateY(30px); }
.price-card.visible { opacity: 1; transform: translateY(0); }
.price-card.popular { border-color: var(--primary); transform: scale(1.05); box-shadow: 0 25px 50px rgba(16, 185, 129, 0.2); background: linear-gradient(180deg, #f0fdf4 0%, white 30%); }
.price-card.popular.visible { transform: scale(1.05); }
.price-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px rgba(16, 185, 129, 0.15); }
.price-card.popular:hover { transform: scale(1.05) translateY(-8px); }
.badge-popular { position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; padding: 0.5rem 1.3rem; border-radius: 50px; font-size: 0.72rem; font-weight: 800; letter-spacing: 1px; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4); white-space: nowrap; }
.price-card h3 { color: var(--dark); margin-bottom: 0.8rem; font-weight: 800; font-size: 1.2rem; }
.price { font-size: 2.8rem; font-weight: 800; color: var(--dark); margin-bottom: 0.3rem; letter-spacing: -1px; }
.price span { font-size: 1rem; color: var(--gray); font-weight: 500; }
.price-desc { color: var(--gray); margin-bottom: 2rem; font-size: 0.9rem; }
.price-features { list-style: none; text-align: left; margin-bottom: 2rem; padding: 0 0.5rem; }
.price-features li { padding: 0.6rem 0; color: #475569; font-size: 0.92rem; display: flex; align-items: center; gap: 0.6rem; }
.price-features li::before { content: '✓'; color: white; background: var(--primary); width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 800; flex-shrink: 0; }
.price-card .btn { width: 100%; justify-content: center; }

/* ===== FAQ ===== */
.faq { background: #f8fafc; }
.faq-list { max-width: 800px; margin: 0 auto; }
.faq-item { background: white; border-radius: 16px; margin-bottom: 1rem; border: 1px solid #f1f5f9; overflow: hidden; transition: all 0.3s; }
.faq-item.active { box-shadow: 0 15px 35px rgba(16, 185, 129, 0.1); border-color: var(--primary); }
.faq-question { padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; cursor: pointer; font-weight: 700; color: var(--dark); font-size: 1rem; user-select: none; gap: 1rem; }
.faq-question:hover { color: var(--primary); }
.faq-icon { width: 32px; height: 32px; background: var(--light); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--primary); font-weight: 700; transition: all 0.3s; flex-shrink: 0; }
.faq-item.active .faq-icon { background: var(--primary); color: white; transform: rotate(45deg); }
.faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
.faq-answer p { padding: 0 1.5rem 1.5rem; color: var(--gray); font-size: 0.95rem; line-height: 1.7; }

/* ===== CTA ===== */
.cta { padding: 6rem 5%; background: linear-gradient(135deg, var(--primary), var(--accent)); text-align: center; color: white; position: relative; overflow: hidden; }
.cta::before { content: ''; position: absolute; top: -50%; left: -10%; width: 400px; height: 400px; background: rgba(255,255,255,0.1); border-radius: 50%; }
.cta::after { content: ''; position: absolute; bottom: -50%; right: -10%; width: 400px; height: 400px; background: rgba(255,255,255,0.1); border-radius: 50%; }
.cta h2 { font-size: 2.8rem; margin-bottom: 1rem; font-weight: 800; letter-spacing: -1px; position: relative; z-index: 2; }
.cta p { font-size: 1.1rem; margin-bottom: 2rem; opacity: 0.95; position: relative; z-index: 2; }
.cta .btn { background: white; color: var(--primary-dark); padding: 1rem 2.5rem; font-size: 1.05rem; position: relative; z-index: 2; box-shadow: 0 15px 35px rgba(0,0,0,0.15); }
.cta .btn:hover { transform: translateY(-3px) scale(1.05); box-shadow: 0 20px 45px rgba(0,0,0,0.25); }

/* ===== FOOTER ===== */
footer { background: var(--dark); color: #94a3b8; padding: 4rem 5% 1rem; }
.footer-content { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 3rem; max-width: 1200px; margin: 0 auto 3rem; }
.footer-brand p { margin-top: 1rem; font-size: 0.9rem; line-height: 1.7; }
.social-links { display: flex; gap: 0.7rem; margin-top: 1.5rem; }
.social-links a { width: 40px; height: 40px; background: rgba(255,255,255,0.08); border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.1rem; transition: all 0.3s; }
.social-links a:hover { background: var(--primary); transform: translateY(-3px); }
.footer-col h4 { color: white; margin-bottom: 1.2rem; font-size: 1rem; font-weight: 700; }
.footer-col ul { list-style: none; }
.footer-col ul li { padding: 0.4rem 0; font-size: 0.9rem; }
.footer-col a { color: #94a3b8; text-decoration: none; transition: color 0.3s; }
.footer-col a:hover { color: var(--primary); }
.footer-bottom { text-align: center; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.08); max-width: 1200px; margin: 0 auto; font-size: 0.85rem; }

/* ===== WHATSAPP FLOAT ===== */
.wa-float { position: fixed; bottom: 2rem; right: 2rem; width: 60px; height: 60px; background: linear-gradient(135deg, #25d366, #128c7e); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; text-decoration: none; box-shadow: 0 15px 35px rgba(37, 211, 102, 0.4); z-index: 999; transition: all 0.3s; animation: waPulse 2s infinite; }
.wa-float:hover { transform: scale(1.1) translateY(-5px); }
@keyframes waPulse { 0%, 100% { box-shadow: 0 15px 35px rgba(37, 211, 102, 0.4); } 50% { box-shadow: 0 15px 35px rgba(37, 211, 102, 0.7), 0 0 0 10px rgba(37, 211, 102, 0.1); } }

/* ===== RESPONSIVE ===== */
@media (max-width: 968px) {
    .footer-content { grid-template-columns: 1fr 1fr; gap: 2rem; }
}
@media (max-width: 768px) {
    .nav-links { display: none; }
    .hero-content { grid-template-columns: 1fr; text-align: center; }
    .hero-text h1 { font-size: 2.4rem; }
    .hero-text > p { margin: 0 auto 2rem; }
    .hero-buttons { justify-content: center; }
    .hero-trust { justify-content: center; }
    .hero-visual { min-height: 400px; margin-top: 2rem; }
    .float-card { display: none; }
    .hero-main-card { max-width: 300px; padding: 2rem 1.5rem; }
    .hero-main-card .big-emoji { font-size: 4rem; }
    .section { padding: 4rem 5%; }
    .section-title h2 { font-size: 2rem; }
    .section-title p { font-size: 0.95rem; }
    .stat-item h3 { font-size: 2.2rem; }
    .price-card.popular { transform: scale(1); }
    .price-card.popular.visible { transform: scale(1); }
    .price-card.popular:hover { transform: translateY(-8px); }
    .cta h2 { font-size: 2rem; }
    .footer-content { grid-template-columns: 1fr; gap: 2rem; text-align: center; }
    .social-links { justify-content: center; }
    .wa-float { width: 55px; height: 55px; font-size: 1.5rem; bottom: 1.5rem; right: 1.5rem; }
}
@media (max-width: 480px) {
    .logo-text { font-size: 1.1rem; }
    .hero-text h1 { font-size: 2rem; }
    .btn { padding: 0.65rem 1.2rem; font-size: 0.85rem; }
    .stats-grid { grid-template-columns: 1fr 1fr; }
    .stat-item h3 { font-size: 1.8rem; }
}
    </style>
</head>
<body>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <!-- ===== NAVBAR ===== -->
    <nav id="navbar">
        <div class="logo">
            <div class="logo-icon">🧺</div>
            <div class="logo-text">WashClean<span>.</span></div>
        </div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#cara-kerja">Cara Kerja</a></li>
            <li><a href="#features">Fitur</a></li>
            <li><a href="#pricing">Harga</a></li>
            <li><a href="#faq">FAQ</a></li>
        </ul>

        <?php if (isset($_SESSION['status']) && $_SESSION['status'] == "login"): ?>
            <div class="user-menu">
                <button class="user-btn">
                    <div class="avatar"><?= strtoupper(substr($_SESSION['username'], 0, 1)) ?></div>
                    <?= htmlspecialchars($_SESSION['username']) ?>
                    <span style="font-size: 0.7rem;">▼</span>
                </button>
                <div class="dropdown">
                    <a href="admin/index.php">📊 Dashboard</a>
                    <a href="admin/logout.php" class="logout-link">🚪 Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="index.php?login=1" class="btn btn-primary">Login Admin</a>
        <?php endif; ?>
    </nav>

    <!-- ===== LOGIN MODAL ===== -->
    <?php if ($show_login && !(isset($_SESSION['status']) && $_SESSION['status'] == "login")): ?>
    <div class="login-overlay">
        <div class="login-box">
            <a href="index.php" class="close-btn" title="Tutup">✕</a>
            <h2>🔐 Login Admin</h2>
            <p class="subtitle">Masuk ke panel admin WashClean</p>

            <?php if (isset($_GET['pesan'])): ?>
                <?php if ($_GET['pesan'] == 'gagal'): ?>
                    <div class="alert alert-danger">❌ Username atau Password Salah!</div>
                <?php elseif ($_GET['pesan'] == 'logout'): ?>
                    <div class="alert alert-info">✅ Anda telah berhasil Logout!</div>
                <?php elseif ($_GET['pesan'] == 'belum_login'): ?>
                    <div class="alert alert-danger">⚠️ Anda harus login untuk mengakses halaman admin!</div>
                <?php endif; ?>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required autofocus>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn-login">Log In</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- ===== HERO ===== -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Layanan WashClean #1 di Indonesia
                </div>
                <h1>Cuci Bersih,<br><span class="gradient">Hidup Lebih Mudah</span></h1>
                <p>Antar-jemput gratis, tracking real-time, dan hasil yang selalu memuaskan. Serahkan cucianmu, nikmati waktumu.</p>
                <div class="hero-buttons">
                    <a href="#pricing" class="btn btn-primary">Pesan Sekarang →</a>
                    <a href="#cara-kerja" class="btn btn-outline">Lihat Cara Kerja</a>
                </div>
                <div class="hero-trust">
                    <div class="avatars">
                        <div class="av av-1">A</div>
                        <div class="av av-2">B</div>
                        <div class="av av-3">C</div>
                        <div class="av av-4">D</div>
                    </div>
                    <div class="trust-text">
                        <strong>10.000+ pelanggan</strong><br>
                        ⭐ 4.9/5 rating kepuasan
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-main-card">
                    <span class="big-emoji">🧺</span>
                    <h3>Antar Jemput Gratis</h3>
                    <p>Dalam radius 5 km dari outlet</p>
                    <span class="pill">✨ Dalam 24 jam selesai</span>
                </div>
                <div class="float-card fc-1">
                    <div class="fc-icon">✅</div>
                    <div class="fc-text">
                        <strong>Pesanan Selesai</strong>
                        <span>Baru saja</span>
                    </div>
                </div>
                <div class="float-card fc-2">
                    <div class="fc-icon">🚚</div>
                    <div class="fc-text">
                        <strong>Sedang Diantar</strong>
                        <span>2 menit lagi</span>
                    </div>
                </div>
                <div class="float-card fc-3">
                    <div class="fc-icon">⚡</div>
                    <div class="fc-text">
                        <strong>Express 6 Jam</strong>
                        <span>Tersedia</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STATS ===== -->
    <section class="stats">
        <div class="stats-grid">
            <div class="stat-item"><h3 data-count="10000">0</h3><p>Pelanggan Puas</p></div>
            <div class="stat-item"><h3 data-count="50">0</h3><p>Outlet Tersebar</p></div>
            <div class="stat-item"><h3 data-count="24">0</h3><p>Jam Layanan Express</p></div>
            <div class="stat-item"><h3 data-count="99">0</h3><p>% Kepuasan</p></div>
        </div>
    </section>

    <!-- ===== CARA KERJA ===== -->
    <section class="section" id="cara-kerja">
        <div class="section-title">
            <span class="section-tag">Cara Kerja</span>
            <h2>Cuma 3 Langkah Mudah</h2>
            <p>Gak ribet, gak repot. Kami urus semua dari jemput sampai antar.</p>
        </div>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <div class="step-icon">📱</div>
                <h3>Pesan Online</h3>
                <p>Pilih paket, isi alamat, dan jadwalkan penjemputan lewat aplikasi atau WhatsApp.</p>
            </div>
            <div class="step-card">
                <div class="step-number">2</div>
                <div class="step-icon">🚚</div>
                <h3>Kami Jemput</h3>
                <p>Kurir kami datang ke lokasi Anda dalam 30 menit untuk mengambil cucian.</p>
            </div>
            <div class="step-card">
                <div class="step-number">3</div>
                <div class="step-icon">✨</div>
                <h3>Bersih & Diantar</h3>
                <p>Cucian dicuci, dikeringkan, disetrika, lalu diantar kembali ke rumah Anda.</p>
            </div>
        </div>
    </section>

    <!-- ===== FEATURES ===== -->
    <section class="section features" id="features">
        <div class="section-title">
            <span class="section-tag">Keunggulan</span>
            <h2>Kenapa Pilih Kami?</h2>
            <p>Kami hadir dengan solusi lengkap untuk semua kebutuhan WashClean Anda</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🚚</div>
                <h3>Antar Jemput Gratis</h3>
                <p>Layanan jemput-antar gratis dalam radius 5 km. Gak perlu keluar rumah.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⏱️</div>
                <h3>Tracking Real-time</h3>
                <p>Pantau status cucian dari aplikasi. Update tiap tahap: cuci, kering, setrika, antar.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💳</div>
                <h3>Pembayaran Digital</h3>
                <p>Bayar via transfer, e-wallet, QRIS, atau COD. Fleksibel sesuai kebutuhan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌿</div>
                <h3>Ramah Lingkungan</h3>
                <p>Deterjen eco-friendly, hemat air, dan kemasan yang bisa didaur ulang.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Layanan Express</h3>
                <p>Butuh cepat? Paket express selesai dalam 6-24 jam. Prioritas utama.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Garansi Kualitas</h3>
                <p>Gak puas? Kami cuci ulang gratis. Kepuasan Anda nomor satu.</p>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONI ===== -->
    <section class="section">
        <div class="section-title">
            <span class="section-tag">Testimoni</span>
            <h2>Kata Pelanggan Kami</h2>
            <p>Ribuan pelanggan udah ngerasain bedanya. Sekarang giliran kamu!</p>
        </div>
        <div class="testimoni-grid">
            <div class="testi-card">
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p class="testi-text">"Praktis banget! Tinggal klik, cucian dijemput, besok udah balik wangi & rapi. Recommended!"</p>
                <div class="testi-user">
                    <div class="testi-avatar" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">S</div>
                    <div>
                        <strong>Sarah Amelia</strong>
                        <span>Ibu Rumah Tangga</span>
                    </div>
                </div>
            </div>
            <div class="testi-card">
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p class="testi-text">"Anak kos nih, susah nyuci. Untung ada layanan ini. Express 6 jam beneran jadi! Worth it banget."</p>
                <div class="testi-user">
                    <div class="testi-avatar" style="background: linear-gradient(135deg, #8b5cf6, #ec4899);">B</div>
                    <div>
                        <strong>Budi Santoso</strong>
                        <span>Mahasiswa</span>
                    </div>
                </div>
            </div>
            <div class="testi-card">
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p class="testi-text">"Sebagai pekerja sibuk, layanan ini ngebantu banget. Hasilnya konsisten bagus. Langganan deh!"</p>
                <div class="testi-user">
                    <div class="testi-avatar" style="background: linear-gradient(135deg, #10b981, #06b6d4);">D</div>
                    <div>
                        <strong>Dinda Permata</strong>
                        <span>Karyawan Swasta</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRICING ===== -->
    <section class="section" id="pricing">
        <div class="section-title">
            <span class="section-tag">Harga</span>
            <h2>Pilih Paket Sesuai Kebutuhan</h2>
            <p>Harga transparan, tanpa biaya tersembunyi</p>
        </div>
        <div class="pricing-grid">
            <div class="price-card">
                <h3>Reguler</h3>
                <div class="price">Rp 7.000<span>/kg</span></div>
                <p class="price-desc">Selesai dalam 3 hari</p>
                <ul class="price-features">
                    <li>Cuci + Kering + Lipat</li>
                    <li>Antar Jemput Gratis</li>
                    <li>Tracking Online</li>
                    <li>Deterjen Standar</li>
                </ul>
                <a href="index.php?login=1" class="btn btn-outline">Pilih Paket</a>
            </div>
            <div class="price-card popular">
                <span class="badge-popular">PALING POPULER</span>
                <h3>Express</h3>
                <div class="price">Rp 12.000<span>/kg</span></div>
                <p class="price-desc">Selesai dalam 24 jam</p>
                <ul class="price-features">
                    <li>Cuci + Kering + Setrika</li>
                    <li>Prioritas Antar Jemput</li>
                    <li>Tracking Real-time</li>
                    <li>Deterjen Premium</li>
                    <li>Parfum Tahan Lama</li>
                </ul>
                <a href="index.php?login=1" class="btn btn-primary">Pilih Paket</a>
            </div>
            <div class="price-card">
                <h3>Premium</h3>
                <div class="price">Rp 20.000<span>/kg</span></div>
                <p class="price-desc">Selesai dalam 6 jam</p>
                <ul class="price-features">
                    <li>Cuci + Kering + Setrika</li>
                    <li>Same Day Service</li>
                    <li>Deterjen Hypoallergenic</li>
                    <li>Packing Rapi & Wangi</li>
                    <li>Garansi Cuci Ulang</li>
                </ul>
                <a href="index.php?login=1" class="btn btn-outline">Pilih Paket</a>
            </div>
        </div>
    </section>

    <!-- ===== FAQ ===== -->
    <section class="section faq" id="faq">
        <div class="section-title">
            <span class="section-tag">FAQ</span>
            <h2>Pertanyaan Umum</h2>
            <p>Belum yakin? Cek dulu jawaban dari pertanyaan yang sering ditanyakan</p>
        </div>
        <div class="faq-list">
            <div class="faq-item">
                <div class="faq-question">
                    <span>Berapa lama proses WashClean selesai?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Untuk paket Reguler 3 hari, Express 24 jam, dan Premium hanya 6 jam. Semua sudah termasuk cuci, kering, setrika, dan packing.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Apakah antar jemput benar-benar gratis?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Ya, 100% gratis untuk area dalam radius 5 km dari outlet kami. Untuk area lebih jauh, ada biaya tambahan yang akan diinfokan saat order.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Bagaimana cara melacak status cucian saya?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Setelah order, Anda akan dapat link tracking. Bisa juga pantau langsung lewat aplikasi atau hubungi customer service kami via WhatsApp.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Metode pembayaran apa saja yang tersedia?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Kami menerima transfer bank, e-wallet (GoPay, OVO, DANA, ShopeePay), QRIS, dan COD (bayar di tempat).</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Apakah ada garansi kalau hasilnya kurang memuaskan?</span>
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Tentu! Kalau Anda kurang puas, laporkan dalam 1x24 jam dan kami akan cuci ulang gratis tanpa biaya tambahan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta">
        <h2>Siap Coba Layanan Kami?</h2>
        <p>Daftar sekarang dan dapatkan diskon 20% untuk order pertama!</p>
        <a href="index.php?login=1" class="btn">Pesan Sekarang 🚀</a>
    </section>
    <!-- ===== FOOTER ===== -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="logo" style="margin-bottom: 1rem;">
                    <div class="logo-icon">🧺</div>
                    <div class="logo-text" style="color: white;">WashClean<span>.</span></div>
                </div>
                <p>Solusi WashClean modern dengan teknologi terkini untuk hidup yang lebih mudah.</p>
                <div class="social-links">
                    <a href="#" title="Instagram">📷</a>
                    <a href="#" title="WhatsApp">💬</a>
                    <a href="#" title="Email">✉️</a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="#">Cuci Reguler</a></li>
                    <li><a href="#">Express 24 Jam</a></li>
                    <li><a href="#">Premium 6 Jam</a></li>
                    <li><a href="#">Cuci Sepatu</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Perusahaan</h4>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Karier</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Partner</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <ul>
                    <li>📞 0812-3456-7890</li>
                    <li>✉️ info@WashClean.id</li>
                    <li>📍 Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> WashClean. All rights reserved. Dibuat dengan ❤️</p>
        </div>
    </footer>

    <!-- ===== FLOATING WHATSAPP ===== -->
    <a href="https://wa.me/6281234567890" target="_blank" class="wa-float" title="Chat WhatsApp">
        💬
    </a>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        // Intersection Observer untuk animasi
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.feature-card, .price-card, .step-card, .testi-card').forEach(el => {
            observer.observe(el);
        });

        // Counter animation
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.dataset.count);
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    let current = 0;
                    const updateCount = () => {
                        current += increment;
                        if (current < target) {
                            el.textContent = Math.floor(current).toLocaleString('id-ID') + (target >= 1000 ? '+' : '');
                            requestAnimationFrame(updateCount);
                        } else {
                            el.textContent = target.toLocaleString('id-ID') + (target >= 1000 ? '+' : '');
                        }
                    };
                    updateCount();
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.stat-item h3[data-count]').forEach(el => {
            counterObserver.observe(el);
        });

        // FAQ accordion
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', () => {
                const item = q.parentElement;
                const wasActive = item.classList.contains('active');
                document.querySelectorAll('.faq-item').forEach(i => {
                    i.classList.remove('active');
                    i.querySelector('.faq-answer').style.maxHeight = null;
                });
                if (!wasActive) {
                    item.classList.add('active');
                    const ans = item.querySelector('.faq-answer');
                    ans.style.maxHeight = ans.scrollHeight + 'px';
                }
            });
        });
    </script>
</body>
</html>