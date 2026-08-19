<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krystal Claire's Campus Badge</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

        :root {
            --ink-deep:   #241238;
            --violet-700: #4B2482;
            --violet-500: #7C4DBE;
            --orchid-400: #A66DD4;
            --lilac-mist: #EFE6FB;
            --paper:      #FCFAFF;
            --blush:      #F3B9DC;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            color: var(--ink-deep);
            background:
                radial-gradient(520px 360px at 12% -10%, rgba(166,109,212,.35), transparent 60%),
                radial-gradient(480px 320px at 110% 110%, rgba(243,185,220,.35), transparent 60%),
                var(--paper);
            padding: 24px;
        }
        nav {
            position: fixed;
            top: 18px; left: 50%;
            transform: translateX(-50%);
            display: flex; gap: 6px;
            font-size: .9rem;
            background: rgba(255,255,255,.7);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(124,77,190,.18);
            border-radius: 999px;
            padding: 6px 8px;
        }
        nav a {
            text-decoration: none;
            color: var(--violet-700);
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 999px;
        }
        nav a:hover, nav a:focus-visible { background: var(--lilac-mist); }
        nav span { color: #c6b6e5; align-self: center; }

        .hero {
            max-width: 560px;
            text-align: center;
        }
        .hero__eyebrow {
            font-size: .72rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--violet-500);
            font-weight: 600;
            margin: 0 0 10px;
        }
        .hero h1 {
            font-family: 'Fraunces', serif;
            font-weight: 700;
            font-size: clamp(2rem, 6vw, 2.8rem);
            line-height: 1.15;
            margin: 0 0 16px;
        }
        .hero h1 em {
            font-style: normal;
            color: var(--violet-700);
            background: linear-gradient(180deg, transparent 62%, var(--blush) 62%);
        }
        .hero p {
            font-size: 1rem;
            line-height: 1.6;
            color: #4a3a63;
            margin: 0 0 28px;
        }
        .hero__cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: .95rem;
            color: var(--paper);
            background: linear-gradient(135deg, var(--violet-700), var(--violet-500));
            padding: 12px 22px;
            border-radius: 14px;
            box-shadow: 0 14px 28px -12px rgba(75,36,130,.5);
            transition: transform .15s ease;
        }
        .hero__cta:hover, .hero__cta:focus-visible { transform: translateY(-2px); }
        .hero__cta:focus-visible { outline: 2px solid var(--orchid-400); outline-offset: 2px; }
    </style>
</head>
<body>
    <nav aria-label="Main navigation">
        <a href="<?= site_url('student'); ?>">Home</a>
        <span>/</span>
        <a href="<?= site_url('student/profile'); ?>">Campus Badge</a>
    </nav>

    <div class="hero">
        <p class="hero__eyebrow">MCC &middot; Student Portal</p>
        <h1>Welcome to the <em>Student Page</em></h1>
        <p>This is a sample landing page for students. Head over to the campus badge to view a full student profile.</p>
        <a class="hero__cta" href="<?= site_url('student/profile'); ?>">View Campus Badge &rarr;</a>
    </div>
</body>
</html>