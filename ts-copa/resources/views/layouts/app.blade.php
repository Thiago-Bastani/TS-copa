<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TS Copa</title>
    <style>
        :root {
            --primary: #E8801E;
            --primary-dark: #c96a10;
            --bg: #F7F5F2;
            --card: #ffffff;
            --dark: #2B2B2B;
            --muted: #6b6b6b;
            --border: #e0ddd8;
            --success: #1E8E3E;
            --error: #D93025;
            --blur-bg: #e0ddd8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg); color: var(--dark); min-height: 100vh; }

        /* Header */
        .header { background: var(--dark); color: #fff; padding: 0 1.5rem; }
        .header-inner { max-width: 860px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 56px; }
        .logo { display: flex; flex-direction: column; line-height: 1; }
        .logo-main { font-size: 1.1rem; font-weight: 800; letter-spacing: .5px; color: var(--primary); }
        .logo-sub { font-size: .6rem; letter-spacing: 2px; color: #aaa; text-transform: uppercase; }
        .badge-copa { background: var(--primary); color: #fff; font-size: .65rem; font-weight: 700; padding: 3px 8px; border-radius: 20px; letter-spacing: 1px; }
        nav { display: flex; gap: 1rem; align-items: center; }
        nav a { color: #ccc; text-decoration: none; font-size: .85rem; font-weight: 500; transition: color .2s; }
        nav a:hover { color: #fff; }
        nav a.active { color: var(--primary); }
        .btn-logout { background: none; border: 1px solid #555; color: #ccc; padding: 4px 12px; border-radius: 6px; cursor: pointer; font-size: .8rem; }
        .btn-logout:hover { border-color: var(--primary); color: var(--primary); }

        /* Main */
        .main { max-width: 860px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
        .page-title { font-size: 1.4rem; font-weight: 800; margin-bottom: 1.25rem; }

        /* Card */
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 14px; padding: 1.25rem; margin-bottom: 1rem; }

        /* Alert */
        .alert { padding: .75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: .9rem; font-weight: 500; }
        .alert-success { background: #e8f5e9; color: var(--success); border: 1px solid #a5d6a7; }
        .alert-error   { background: #fdecea; color: var(--error);   border: 1px solid #f5c2be; }

        /* Forms */
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-size: .82rem; font-weight: 600; color: var(--muted); margin-bottom: .35rem; text-transform: uppercase; letter-spacing: .5px; }
        input, select { width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--border); border-radius: 8px; font-size: .95rem; background: var(--bg); color: var(--dark); transition: border-color .2s; }
        input:focus, select:focus { outline: none; border-color: var(--primary); }
        .input-error { border-color: var(--error) !important; }
        .error-msg { font-size: .78rem; color: var(--error); margin-top: .25rem; }

        .btn { display: inline-block; padding: .7rem 1.5rem; border-radius: 8px; font-size: .95rem; font-weight: 700; cursor: pointer; border: none; text-decoration: none; text-align: center; transition: background .2s, transform .1s; }
        .btn:active { transform: scale(.98); }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-sm { padding: .4rem .9rem; font-size: .82rem; }
        .btn-danger { background: #fdecea; color: var(--error); }
        .btn-danger:hover { background: var(--error); color: #fff; }
        .btn-outline { background: transparent; border: 1.5px solid var(--border); color: var(--dark); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }
        .btn-success { background: var(--success); color: #fff; }
        .btn-warning { background: #f59e0b; color: #fff; }
        .btn-block { display: block; width: 100%; }

        /* Tabs */
        .tabs { display: flex; gap: .5rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--border); padding-bottom: 0; }
        .tab { padding: .6rem 1.2rem; font-size: .9rem; font-weight: 600; color: var(--muted); text-decoration: none; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all .2s; }
        .tab:hover { color: var(--primary); }
        .tab.active { color: var(--primary); border-bottom-color: var(--primary); }

        /* Status badges */
        .badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: .72rem; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; }
        .badge-apostas { background: #fff3e0; color: #e65100; }
        .badge-em_andamento { background: #e3f2fd; color: #1565c0; }
        .badge-finalizado { background: #e8f5e9; color: var(--success); }

        /* Match card */
        .match-card { background: var(--card); border: 1px solid var(--border); border-radius: 14px; padding: 1.25rem; margin-bottom: .85rem; transition: box-shadow .2s; }
        .match-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,.08); }
        .match-teams { display: flex; align-items: center; justify-content: center; gap: 1rem; margin: .75rem 0; }
        .team-side { display: flex; flex-direction: column; align-items: center; gap: .35rem; flex: 1; }
        .team-name { font-size: .82rem; font-weight: 700; text-align: center; }
        .score-display { display: flex; align-items: center; gap: .5rem; font-size: 1.6rem; font-weight: 900; color: var(--dark); }
        .score-sep { color: var(--muted); font-weight: 400; font-size: 1.2rem; }
        .match-meta { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem; }
        .match-date { font-size: .8rem; color: var(--muted); }

        /* Score inputs */
        .score-inputs { display: flex; align-items: center; gap: .75rem; justify-content: center; }
        .score-input { width: 64px; text-align: center; font-size: 1.4rem; font-weight: 800; padding: .5rem; }

        /* Bets list */
        .bets-list { display: flex; flex-direction: column; gap: .5rem; margin-top: 1rem; }
        .bet-item { display: flex; align-items: center; justify-content: space-between; padding: .65rem 1rem; border-radius: 8px; background: var(--bg); border: 1px solid var(--border); }
        .bet-item.my-bet { border-color: var(--primary); background: #fff8f0; }
        .bet-item.winner { border-color: var(--success); background: #f0faf3; }
        .bet-name { font-weight: 600; font-size: .9rem; }
        .bet-score { font-weight: 800; font-size: 1rem; }
        .bet-score.blurred { filter: blur(5px); user-select: none; pointer-events: none; }

        /* Winners section */
        .winners-section { margin-top: 1.5rem; padding: 1.25rem; border-radius: 12px; background: #f0faf3; border: 1.5px solid #a5d6a7; }
        .winners-title { font-size: 1rem; font-weight: 800; color: var(--success); margin-bottom: 1rem; }
        .winner-card { display: flex; flex-direction: column; align-items: center; gap: .75rem; padding: 1rem; background: #fff; border-radius: 10px; border: 1px solid #c8e6c9; margin-bottom: .75rem; }
        .winner-name { font-weight: 700; font-size: 1rem; }
        .winner-pix { font-size: .8rem; color: var(--muted); }
        .winner-amount { font-size: 1.2rem; font-weight: 900; color: var(--success); }
        .qr-wrap { padding: .5rem; background: #fff; border: 1px solid var(--border); border-radius: 8px; }
        .qr-wrap svg { display: block; }

        /* Table */
        table { width: 100%; border-collapse: collapse; font-size: .9rem; }
        th { text-align: left; padding: .5rem .75rem; font-size: .75rem; text-transform: uppercase; letter-spacing: .5px; color: var(--muted); border-bottom: 2px solid var(--border); }
        td { padding: .65rem .75rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }

        /* Auth pages */
        .auth-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
        .auth-card { width: 100%; max-width: 420px; background: var(--card); border-radius: 16px; padding: 2rem; border: 1px solid var(--border); box-shadow: 0 8px 32px rgba(0,0,0,.07); }
        .auth-logo { text-align: center; margin-bottom: 1.75rem; }
        .auth-logo .logo-main { font-size: 1.6rem; }
        .auth-title { font-size: 1.2rem; font-weight: 800; margin-bottom: 1.5rem; }
        .auth-footer { text-align: center; margin-top: 1.25rem; font-size: .85rem; color: var(--muted); }
        .auth-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }

        /* Eye toggle */
        .input-eye { position: relative; }
        .input-eye input { padding-right: 2.5rem; }
        .eye-btn { position: absolute; right: .65rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 0; display: flex; align-items: center; }
        .eye-btn:hover { color: var(--dark); }

        /* Responsive */
        @media (max-width: 520px) {
            .header-inner { flex-wrap: wrap; height: auto; padding: .75rem 0; gap: .5rem; }
            nav { flex-wrap: wrap; gap: .5rem; }
            .match-teams { gap: .5rem; }
        }
    </style>
</head>
<body>
    @auth
    <header class="header">
        <div class="header-inner">
            <div class="logo">
                <span class="logo-main">TS Copa</span>
                <span class="logo-sub">Time.System</span>
            </div>
            <div style="display:flex;align-items:center;gap:1rem;">
                <span class="badge-copa">COPA 2026</span>
                <nav>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.teams.index') }}" class="{{ request()->routeIs('admin.teams.*') ? 'active' : '' }}">Times</a>
                        <a href="{{ route('admin.matches.index') }}" class="{{ request()->routeIs('admin.matches.*') ? 'active' : '' }}">Partidas</a>
                    @else
                        <a href="{{ route('matches.index') }}" class="{{ request()->routeIs('matches.*') ? 'active' : '' }}">Partidas</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button class="btn-logout" type="submit">Sair</button>
                    </form>
                </nav>
            </div>
        </div>
    </header>
    @endauth

    <main class="{{ auth()->check() ? 'main' : '' }}">
        @yield('content')
    </main>
<script>
function togglePassword(btn) {
    var input = btn.closest('.input-eye').querySelector('input');
    var open  = btn.querySelector('.eye-open');
    var shut  = btn.querySelector('.eye-shut');
    if (input.type === 'password') {
        input.type = 'text';
        open.style.display = 'none';
        shut.style.display = '';
    } else {
        input.type = 'password';
        open.style.display = '';
        shut.style.display = 'none';
    }
}
</script>
</body>
</html>
