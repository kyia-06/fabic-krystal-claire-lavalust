<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle(Closure $next)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (($_SESSION['student_access'] ?? false) !== true) {
            http_response_code(403);
            echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Badge Not Scanned &mdash; Access Restricted</title>
                <style>
                    @import url("https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap");
                    * { box-sizing: border-box; }
                    body {
                        margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
                        font-family: "Plus Jakarta Sans", system-ui, sans-serif; color: #241238; padding: 24px;
                        background:
                            radial-gradient(520px 360px at 12% -10%, rgba(166,109,212,.35), transparent 60%),
                            radial-gradient(480px 320px at 110% 110%, rgba(243,185,220,.35), transparent 60%),
                            #FCFAFF;
                    }
                    .kc-denied {
                        max-width: 440px; text-align: center; background: #fff; border-radius: 22px;
                        padding: 34px 30px; box-shadow: 0 24px 48px -20px rgba(75,36,130,.35), 0 0 0 1px rgba(124,77,190,.10);
                    }
                    .kc-denied__badge {
                        width: 62px; height: 62px; margin: 0 auto 16px; border-radius: 50%;
                        background: linear-gradient(135deg, #4B2482, #7C4DBE 55%, #A66DD4);
                        display: flex; align-items: center; justify-content: center;
                        font-size: 1.5rem; color: #fff;
                    }
                    .kc-denied h1 {
                        font-family: "Fraunces", serif; font-weight: 700; font-size: 1.5rem; margin: 0 0 10px;
                    }
                    .kc-denied p {
                        font-size: .95rem; line-height: 1.6; color: #4a3a63; margin: 0 0 22px;
                    }
                    .kc-denied a {
                        display: inline-flex; align-items: center; gap: 8px; text-decoration: none; font-weight: 600;
                        font-size: .9rem; color: #FCFAFF; background: linear-gradient(135deg, #4B2482, #7C4DBE);
                        padding: 11px 20px; border-radius: 12px;
                    }
                    .kc-denied a:hover, .kc-denied a:focus-visible { transform: translateY(-1px); }
                </style>
                </head><body>
                    <div class="kc-denied">
                        <div class="kc-denied__badge">&#128274;</div>
                        <h1>This badge hasn&rsquo;t been scanned in yet</h1>
                        <p>Looks like you tried to walk into the Campus Badge page without checking in first. Head back to the Student Page to get your access sorted, then try again.</p>
                        <a href="' . site_url('student') . '">&larr; Back to Student Page</a>
                    </div>
                </body></html>';
            exit;
        }

        return $next();
    }
}