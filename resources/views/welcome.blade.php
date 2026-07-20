<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Shortlinks') }}</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #08111f;
            --bg-2: #101c31;
            --card: rgba(10, 17, 33, 0.72);
            --card-border: rgba(255, 255, 255, 0.10);
            --text: #f5f7fb;
            --muted: #9eabc3;
            --accent: #f5a524;
            --accent-2: #7dd3fc;
            --success: #38d39f;
            --shadow: 0 30px 80px rgba(0, 0, 0, 0.45);
        }

        * { box-sizing: border-box; }

        html, body { min-height: 100%; }

        body {
            margin: 0;
            color: var(--text);
            font-family: "Avenir Next", "Segoe UI", "Helvetica Neue", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(245, 165, 36, 0.18), transparent 30%),
                radial-gradient(circle at top right, rgba(125, 211, 252, 0.18), transparent 24%),
                linear-gradient(180deg, var(--bg), var(--bg-2));
        }

        .shell {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            padding: 32px;
        }

        .noise {
            position: absolute;
            inset: 0;
            opacity: 0.22;
            background-image:
                linear-gradient(rgba(255,255,255,.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.05) 1px, transparent 1px);
            background-size: 72px 72px;
            mask-image: radial-gradient(circle at center, black, transparent 85%);
            pointer-events: none;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 1180px;
            margin: 0 auto;
        }

        .topbar {
            align-items: center;
            gap: 16px;
            margin-bottom: 56px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .mark {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: linear-gradient(145deg, var(--accent), #ffcf70);
            box-shadow: 0 12px 32px rgba(245, 165, 36, 0.35);
            position: relative;
        }

        .mark::after {
            content: "";
            position: absolute;
            inset: 11px;
            border: 2px solid rgba(8, 17, 31, 0.82);
            border-radius: 10px 0 0;
            transform: rotate(45deg);
        }

        .brand-title {
            font-size: 2.05rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            font-family: monospace;
            font-variant: small-caps;
        }

        .brand-subtitle {
            display: block;
            color: var(--muted);
            font-size: 0.88rem;
            margin-top: 2px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 18px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 700;
            border: 1px solid transparent;
            transition: transform 160ms ease, box-shadow 160ms ease, border-color 160ms ease, background 160ms ease;
        }

        .button:hover {
            transform: translateY(-1px);
        }

        .button.primary {
            color: #0d1321;
            background: linear-gradient(135deg, var(--accent), #ffd86b);
            box-shadow: 0 16px 38px rgba(245, 165, 36, 0.28);
        }

        .button.secondary {
            color: var(--text);
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.08);
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(320px, 0.8fr);
            gap: 28px;
            align-items: stretch;
        }

        .panel {
            border: 1px solid var(--card-border);
            background: var(--card);
            backdrop-filter: blur(18px);
            border-radius: 28px;
            box-shadow: var(--shadow);
        }

        .hero-copy {
            padding: 40px;
        }

        .eyebrow {
            float: right;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            color: #ffe2b1;
            background: rgba(245, 165, 36, 0.12);
            border: 1px solid rgba(245, 165, 36, 0.18);
            font-size: 0.92rem;
            margin-bottom: 18px;
        }

        h1 {
            margin: 0;
            font-size: clamp(2.6rem, 5vw, 5.2rem);
            line-height: 0.96;
            letter-spacing: -0.05em;
        }

        .lead {
            margin: 20px 0 0;
            max-width: 56ch;
            color: var(--muted);
            font-size: 1.08rem;
            line-height: 1.75;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 30px;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 34px;
        }

        .meta {
            padding: 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }

        .meta strong {
            display: block;
            font-size: 1.05rem;
            margin-bottom: 6px;
        }

        .meta span {
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .side {
            display: grid;
            gap: 16px;
            padding: 22px;
        }

        .side-card {
            padding: 22px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }

        .side-card h2 {
            margin: 0 0 10px;
            font-size: 1.05rem;
        }

        .stack {
            display: grid;
            gap: 10px;
            margin: 0;
        }

        .credential {
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(8, 17, 31, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .credential code {
            color: #ffe2b1;
            font-size: 0.95rem;
            word-break: break-word;
        }

        .credential small {
            color: var(--muted);
            white-space: nowrap;
        }

        .mini {
            display: grid;
            gap: 12px;
        }

        .mini-row {
            gap: 16px;
            align-items: center;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .top-links {
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        }

        .flex-space-bw {
            display: flex;
            justify-content: space-between;
        }

        .w-75-a {
            width: 75%;
            margin: auto;
        }
        .w-100 {
            width: 100%;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(56, 211, 159, 0.12);
            color: #acf7db;
            border: 1px solid rgba(56, 211, 159, 0.18);
            font-size: 0.88rem;
        }

        @media (max-width: 900px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .meta-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero-copy,
            .side {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
<main class="shell">
    <div class="noise"></div>
    <div class="container">
        <header class="topbar flex-space-bw">
            <a class="brand" href="{{ url('/') }}">
                <span class="mark" aria-hidden="true"></span>
                <span>
                    <span class="brand-title">{{ config('app.name', 'Shortlinks') }}</span>
                    <span class="brand-subtitle">with Laravel 12, Filament 5 and <s>hookers</s> DDD</span>
                </span>
            </a>

            <div class="top-links">
                @if(app()->environment('local', 'staging'))<a class="button secondary" href="{{ url('/test') }}">Smoke test</a>@endif
                <a class="button primary" href="{{ url('/admin/login') }}">Open admin</a>
                <a class="button secondary" href="{{ url('/admin') }}">Open dashboard</a>
            </div>
        </header>

        <section class="hero">
            <div class="panel hero-copy">
                <div class="eyebrow">
                    <span class="badge" style="padding:4px 10px;">Ready</span>
                    Short links, analytics, admin panel
                </div>
                <h1>Shorten URLs and inspect every click from one panel.</h1>
                <p class="lead">
                    This project is wired for testing with a Filament-style interface,
                    tracked redirects, and bootstrap users for the admin area.
                    Use the credentials below to enter the dashboard immediately.
                </p>

                <div class="actions">
                    @guest
                    <!-- Visible only to guests -->
                    <a class="button primary" href="{{ url('/admin/register') }}">Register</a>
                    <a class="button primary" href="{{ url('/admin/login') }}">Go to login</a>
                    @else
                    <!-- Visible only to logged-in users -->
                    <a class="button secondary" href="{{ url('/admin') }}">Open dashboard</a>
                    @endguest
                </div>


                @auth
                <!-- Visible only to logged-in users -->
                <br /><br /><br />
                    @if(session('short_url'))
                    <div class="success">Ваша ссылка: {{ session('short_url') }}</div>
                    @else
                        <p>Welcome, <b>{{ auth()->user()->name }}</b> you can shorten url below</p>
                        <div class="side-card">
                            <div class="credential mini-row flex-space-bw">
                                <form action="{{ url('/urls') }}" method="POST" class="flex-space-bw w-100">
                                    @csrf
                                    <input class="side-card w-75-a" type="url" name="original_url" required placeholder="https://example.com/page" />
                                    <button class="button secondary badge" type="submit">Shorten</button>
                                </form>
                            </div>
                        </div>
                    @endif

                @else
                <!-- Visible only to guests -->
                <p> After successful log-in you can shorten links here!</p>
                @endauth

                <div class="meta-grid">
                    <div class="meta">
                        <strong>Redirects</strong>
                        <span>Short codes resolve to the original URL and record visit data.</span>
                    </div>
                    <div class="meta">
                        <strong>Analytics</strong>
                        <span>IP address and timestamp are stored per visit for each link.</span>
                    </div>
                    <div class="meta">
                        <strong>Panel</strong>
                        <span>Manage URLs in Filament with list, create, edit and delete screens.</span>
                    </div>
                </div>
            </div>

            @if(app()->environment('local', 'staging'))
            <aside class="panel side">
                <div class="side-card">
                    <h2>Bootstrap accounts</h2>
                    <div class="stack">
                        <div class="credential flex-space-bw">
                            <code>admin@example.com</code>
                            <small>password</small>
                        </div>
                        <div class="credential flex-space-bw">
                            <code>user@example.com</code>
                            <small>password</small>
                        </div>
                    </div>
                </div>

                <div class="side-card mini">
                    <h2>Quick status</h2>
                    <div class="mini-row flex-space-bw">
                        <span>Admin route</span>
                        <span class="badge">{{ url('/admin/login') }}</span>
                    </div>
                    <div class="mini-row flex-space-bw">
                        <span>Panel name</span>
                        <span class="badge">filament.admin</span>
                    </div>
                    <div class="mini-row flex-space-bw">
                        <span>Database</span>
                        <span class="badge">mysql</span>
                    </div>
                </div>
            </aside>
            @endif
        </section>
    </div>
</main>
</body>
</html>
