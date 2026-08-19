<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/*
    Redesign notes for the dev handing this back:
    - Every value that ships from StudentController (student_id, name, course, year,
      section, email, contact, address, status, avatar_initials) is still pulled through
      htmlspecialchars() exactly like the original — no bindings were touched.
    - skills / hobbies / description / social links are NOT part of the current
      $student array the controller passes, so per the brief they're hardcoded below.
      If you want these dynamic later, just add matching keys to the controller's
      $student array and swap the hardcoded blocks for the equivalent <?= htmlspecialchars($x) ?>.
    - Heads up: the controller currently sends contact as '0946 836 9092' (last digit 2),
      but the brief text listed '...9093'. This view just prints whatever $contact is,
      so update the digit in StudentController if 9093 is the correct one.
*/
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap');

    .kc-scope {
        --ink-deep:     #241238;
        --violet-700:   #4B2482;
        --violet-500:   #7C4DBE;
        --orchid-400:   #A66DD4;
        --lilac-mist:   #EFE6FB;
        --paper:        #FCFAFF;
        --blush:        #F3B9DC;
        --ok-green:     #3FAE6A;

        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        color: var(--ink-deep);
        max-width: 780px;
        margin: 32px auto;
        padding: 0 16px 48px;
        position: relative;
    }

    .kc-scope * { box-sizing: border-box; }

    @media (prefers-reduced-motion: no-preference) {
        .kc-badge { animation: kc-rise 0.55s cubic-bezier(.2,.8,.2,1) both; }
        .kc-chip  { animation: kc-fade 0.4s ease both; animation-delay: calc(var(--i, 0) * 60ms); }
    }
    @keyframes kc-rise { from { opacity:0; transform: translateY(14px); } to { opacity:1; transform:none; } }
    @keyframes kc-fade { from { opacity:0; transform: translateY(6px); } to { opacity:1; transform:none; } }

    /* ambient blobs */
    .kc-blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(46px);
        opacity: .35;
        z-index: 0;
        pointer-events: none;
    }
    .kc-blob.one   { width:260px; height:260px; background:var(--orchid-400); top:-90px; left:-80px; }
    .kc-blob.two   { width:220px; height:220px; background:var(--blush); bottom:-70px; right:-70px; }

    .kc-eyebrow {
        position: relative;
        z-index: 1;
        text-align: center;
        font-family: 'JetBrains Mono', monospace;
        font-size: .72rem;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--violet-500);
        margin: 0 0 6px;
    }

    .kc-title {
        position: relative;
        z-index: 1;
        text-align: center;
        font-family: 'Fraunces', serif;
        font-weight: 600;
        font-size: clamp(1.7rem, 4vw, 2.35rem);
        line-height: 1.15;
        margin: 0 0 30px;
        color: var(--ink-deep);
    }
    .kc-title em {
        font-style: normal;
        color: var(--violet-700);
        background: linear-gradient(180deg, transparent 62%, var(--blush) 62%);
        padding: 0 2px;
    }

    /* ===== the badge / campus-pass card ===== */
    .kc-badge {
        position: relative;
        z-index: 1;
        background: var(--paper);
        border-radius: 26px;
        box-shadow: 0 24px 48px -20px rgba(75,36,130,.35), 0 0 0 1px rgba(124,77,190,.10);
        overflow: hidden;
    }

    .kc-badge__header {
        position: relative;
        background: linear-gradient(135deg, var(--violet-700), var(--violet-500) 55%, var(--orchid-400));
        padding: 30px 28px 40px;
        color: var(--lilac-mist);
    }

    .kc-badge__lanyardhole {
        position: absolute;
        top: 16px; left: 50%;
        transform: translateX(-50%);
        width: 34px; height: 10px;
        background: var(--paper);
        border-radius: 999px;
        box-shadow: inset 0 2px 3px rgba(0,0,0,.18);
    }

    .kc-badge__top {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 14px;
    }

    .kc-avatar {
        flex: none;
        width: 66px; height: 66px;
        border-radius: 50%;
        background: var(--paper);
        color: var(--violet-700);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Fraunces', serif;
        font-weight: 700;
        font-size: 1.3rem;
        box-shadow: 0 0 0 3px rgba(255,255,255,.35);
    }

    .kc-badge__name {
        font-family: 'Fraunces', serif;
        font-weight: 600;
        font-size: 1.28rem;
        margin: 0;
    }
    .kc-badge__id {
        font-family: 'JetBrains Mono', monospace;
        font-size: .8rem;
        letter-spacing: .04em;
        opacity: .85;
        margin: 3px 0 0;
    }

    .kc-status {
        position: absolute;
        top: 26px; right: 22px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.4);
        backdrop-filter: blur(4px);
        border-radius: 999px;
        padding: 5px 12px 5px 9px;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .02em;
    }
    .kc-status__dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: #7CE8A6;
        box-shadow: 0 0 0 3px rgba(124,232,166,.25);
    }

    /* perforated tear between header and body — the signature element */
    .kc-tear {
        position: relative;
        height: 0;
        border-top: 2px dashed rgba(75,36,130,.28);
        margin: 0 24px;
    }
    .kc-tear::before, .kc-tear::after {
        content: "";
        position: absolute;
        top: -12px;
        width: 24px; height: 24px;
        border-radius: 50%;
        background: var(--lilac-mist);
        box-shadow: inset 0 0 0 1px rgba(75,36,130,.12);
    }
    .kc-tear::before { left: -36px; }
    .kc-tear::after  { right: -36px; }

    .kc-badge__body { padding: 30px 28px 28px; }

    .kc-desc {
        font-size: .96rem;
        line-height: 1.6;
        color: #4a3a63;
        margin: 0 0 26px;
        padding: 14px 16px;
        background: var(--lilac-mist);
        border-left: 3px solid var(--orchid-400);
        border-radius: 4px 12px 12px 4px;
    }

    .kc-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 24px;
        margin-bottom: 26px;
    }
    .kc-field dt {
        font-family: 'JetBrains Mono', monospace;
        font-size: .68rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--violet-500);
        margin: 0 0 3px;
    }
    .kc-field dd {
        margin: 0;
        font-size: .94rem;
        font-weight: 500;
        color: var(--ink-deep);
    }
    .kc-field.kc-span2 { grid-column: 1 / -1; }

    .kc-section-label {
        font-family: 'JetBrains Mono', monospace;
        font-size: .68rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--violet-500);
        margin: 0 0 10px;
    }

    .kc-chips { display: flex; flex-wrap: wrap; gap: 8px; margin: 0 0 24px; padding: 0; list-style: none; }
    .kc-chip {
        font-size: .82rem;
        font-weight: 600;
        padding: 6px 13px;
        border-radius: 999px;
        background: var(--lilac-mist);
        color: var(--violet-700);
        border: 1px solid rgba(124,77,190,.18);
    }
    .kc-chip.is-hobby {
        background: #FDECF6;
        color: #9A3E7B;
        border-color: rgba(154,62,123,.18);
    }

    .kc-socials { display: flex; gap: 10px; flex-wrap: wrap; }
    .kc-social {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        font-size: .86rem;
        font-weight: 600;
        color: var(--paper);
        background: var(--violet-700);
        padding: 9px 16px;
        border-radius: 12px;
        transition: transform .15s ease, background .15s ease;
    }
    .kc-social:hover, .kc-social:focus-visible { background: var(--violet-500); transform: translateY(-2px); }
    .kc-social:focus-visible { outline: 2px solid var(--orchid-400); outline-offset: 2px; }
    .kc-social__dot { width: 8px; height: 8px; border-radius: 50%; background: var(--blush); flex: none; }

    .kc-nav {
        position: relative;
        z-index: 1;
        max-width: 780px;
        margin: 0 auto 22px;
        padding: 0 4px 14px;
        display: flex;
        gap: 6px;
        font-size: .9rem;
        border-bottom: 1px solid rgba(124,77,190,.18);
    }
    .kc-nav a {
        text-decoration: none;
        color: var(--violet-700);
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 8px;
    }
    .kc-nav a:hover, .kc-nav a:focus-visible { background: var(--lilac-mist); }
    .kc-nav span { color: #b9a9d6; }

    @media (max-width: 560px) {
        .kc-badge__header { padding: 26px 20px 36px; }
        .kc-badge__body { padding: 26px 20px 24px; }
        .kc-grid { grid-template-columns: 1fr; }
        .kc-status { position: static; margin-top: 14px; width: fit-content; }
        .kc-tear { margin: 0 16px; }
        .kc-tear::before { left: -28px; }
        .kc-tear::after  { right: -28px; }
    }
</style>

<div class="kc-scope">
    <nav class="kc-nav" aria-label="Main navigation">
        <a href="<?= site_url('student'); ?>">Home</a>
        <span>/</span>
        <a href="<?= site_url('student/profile'); ?>">Campus Badge</a>
    </nav>

    <div class="kc-blob one"></div>
    <div class="kc-blob two"></div>

    <p class="kc-eyebrow">MCC &middot; Official Campus Access Badge</p>
    <h1 class="kc-title">Krystal Claire's <em>Campus&nbsp;Badge</em></h1>

    <div class="kc-badge">
        <div class="kc-badge__header">
            <div class="kc-badge__lanyardhole"></div>

            <span class="kc-status">
                <span class="kc-status__dot"></span>
                <?= htmlspecialchars($status) ?>
            </span>

            <div class="kc-badge__top">
                <div class="kc-avatar"><?= htmlspecialchars($avatar_initials) ?></div>
                <div>
                    <p class="kc-badge__name"><?= htmlspecialchars($name) ?></p>
                    <p class="kc-badge__id">ID <?= htmlspecialchars($student_id) ?></p>
                </div>
            </div>
        </div>

        <div class="kc-tear"></div>

        <div class="kc-badge__body">
            <p class="kc-desc">"A simple student who's passionate about learning, growing, and making the most out of every experience."</p>

            <dl class="kc-grid">
                <div class="kc-field">
                    <dt>Course</dt>
                    <dd><?= htmlspecialchars($course) ?></dd>
                </div>
                <div class="kc-field">
                    <dt>Year &amp; Section</dt>
                    <dd><?= htmlspecialchars($year) ?> &ndash; <?= htmlspecialchars($section) ?></dd>
                </div>
                <div class="kc-field">
                    <dt>Email</dt>
                    <dd><?= htmlspecialchars($email) ?></dd>
                </div>
                <div class="kc-field">
                    <dt>Contact No.</dt>
                    <dd><?= htmlspecialchars($contact) ?></dd>
                </div>
                <div class="kc-field kc-span2">
                    <dt>Address</dt>
                    <dd><?= htmlspecialchars($address) ?></dd>
                </div>
            </dl>

            <p class="kc-section-label">Skills</p>
            <ul class="kc-chips">
                <li class="kc-chip" style="--i:0">Problem-Solving</li>
                <li class="kc-chip" style="--i:1">Communication</li>
                <li class="kc-chip" style="--i:2">Team Work</li>
                <li class="kc-chip" style="--i:3">Masarap</li>
                <li class="kc-chip" style="--i:4">Thirstrapper</li>
            </ul>

            <p class="kc-section-label">Hobbies</p>
            <ul class="kc-chips">
                <li class="kc-chip is-hobby" style="--i:5">🎬 Movie</li>
                <li class="kc-chip is-hobby" style="--i:6">🎮 Online Games</li>
            </ul>

            <p class="kc-section-label">Find Me Online</p>
            <div class="kc-socials">
                <a class="kc-social" href="https://www.facebook.com/profile.php?id=61579008061825" target="_blank" rel="noopener noreferrer">
                    <span class="kc-social__dot"></span>Facebook
                </a>
                <a class="kc-social" href="https://www.instagram.com/clayrexhy?igsh=MW4zYjdxc3pwcGEwbg==" target="_blank" rel="noopener noreferrer">
                    <span class="kc-social__dot"></span>Instagram
                </a>
                <a class="kc-social" href="https://www.tiktok.com/@kisksksjs?_r=1&_t=ZS-990I2FogVjs" target="_blank" rel="noopener noreferrer">
                    <span class="kc-social__dot"></span>TikTok
                </a>
            </div>
        </div>
    </div>
</div>