@extends('layouts.app')

@section('page-class', 'page-full')

@section('content')
    <section class="hero">
        <div class="hero-copy">
            <h1>Setiap kucing Bandung layak punya rumah</h1>
            <p class="hero-lede">Temukan kucing dari berbagai daerah di Bandung yang sudah dirawat dan siap menjadi teman baru di tempat tinggalmu.</p>
            <div class="capsule">
                <span>Siap mengadopsi kucing?</span>
                <a class="btn" href="{{ route('register') }}">Register</a>
            </div>
            <p class="hero-alt">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
        </div>

        <div class="hero-panel" aria-label="Kondisi shelter saat ini">
            <p class="cell stat"><span>Menunggu adopsi</span><strong>{{ $total }} kucing</strong></p>
            <div class="cell"></div>
            <div class="cell block" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M4 3l4 4h8l4-4v9a8 8 0 0 1-16 0z" fill="currentColor"/></svg>
            </div>
            <p class="cell stat">
                <span>Sudah divaksin</span>
                <strong>{{ $vaccinated }} dari {{ $total }}</strong>
                <span class="bar" role="presentation"><span style="width: {{ $total ? round($vaccinated / $total * 100) : 0 }}%"></span></span>
            </p>
            <p class="cell stat"><span>Terakhir ditemukan</span><strong>{{ $latest?->found_at ?? 'Belum ada' }}</strong></p>
            <div class="cell"></div>
        </div>
    </section>

    <footer id="hwf-footer" class="hwf-root" style="height: 520px; --hwf-bg: #0a0c1b; --hwf-ink: #f8fafc; --hwf-mono: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;">
        <style>
            .hwf-root {
                position: relative; width: 100%; overflow: hidden; isolation: isolate;
                background: var(--hwf-bg); color: var(--hwf-ink); -webkit-font-smoothing: antialiased;
                border-top: 1px solid var(--grid-line);
            }
            .hwf-root canvas { position: absolute; inset: 0; width: 100%; height: 100%; display: block; max-width: none; }
            .hwf-top {
                position: relative; z-index: 1; display: grid; grid-template-columns: minmax(0, 1.25fr) repeat(3, minmax(0, 1fr));
                gap: 24px; padding: clamp(22px, 3.4vw, 40px) clamp(20px, 3.4vw, 44px) 0;
                font-family: var(--hwf-mono); font-size: 10.5px; letter-spacing: .18em; text-transform: uppercase; line-height: 1.75;
            }
            .hwf-brand strong { display: block; font-weight: 500; }
            .hwf-brand span { opacity: .45; }
            .hwf-col h3 { margin: 0; font: inherit; opacity: .4; font-weight: 500; }
            .hwf-col ul { list-style: none; margin: 0; padding: 0; }
            .hwf-col span { opacity: .78; }
            .hwf-col a, .hwf-up {
                color: inherit; text-decoration: none; opacity: .78; background: none; border: 0; padding: 0;
                font: inherit; letter-spacing: inherit; text-transform: inherit; cursor: pointer;
                background-image: linear-gradient(currentColor, currentColor); background-size: 0% 1px;
                background-repeat: no-repeat; background-position: 0 100%; transition: opacity .25s ease, background-size .35s cubic-bezier(.2,.7,.1,1);
            }
            .hwf-col a:hover, .hwf-up:hover { opacity: 1; background-size: 100% 1px; }
            .hwf-col a:focus-visible, .hwf-up:focus-visible { outline: 1px solid currentColor; outline-offset: 3px; opacity: 1; }
            .hwf-rule {
                position: relative; z-index: 1; display: flex; justify-content: flex-end; align-items: center; gap: 16px;
                margin: clamp(18px, 2.6vw, 30px) clamp(20px, 3.4vw, 44px) 0; padding-top: 12px;
                border-top: 0.5px solid color-mix(in srgb, var(--hwf-ink) 16%, transparent);
                font-family: var(--hwf-mono); font-size: 10.5px; letter-spacing: .18em; text-transform: uppercase;
            }
            .hwf-sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip-path: inset(50%); white-space: nowrap; }
            @media (max-width: 720px) {
                .hwf-top { grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); row-gap: 18px; }
                .hwf-brand { grid-column: 1 / -1; }
            }
            @media (prefers-reduced-motion: reduce) {
                .hwf-col a, .hwf-up { transition: none; }
            }
        </style>
        <canvas id="hwf-canvas" aria-hidden="true"></canvas>
        <span class="hwf-sr">meowdopt</span>
        <div class="hwf-top">
            <div class="hwf-brand">
                <strong>EISD Meowdopt</strong>
                <span>©2026 · Laboratorium EISD</span>
            </div>
            <nav class="hwf-col" aria-label="Portal">
                <h3>Portal</h3>
                <ul>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ route('cats.index') }}">Katalog Kucing</a></li>
                    <li><a href="{{ route('adoptions.index') }}">Pengajuan Adopsi</a></li>
                </ul>
            </nav>
            <nav class="hwf-col" aria-label="Akun">
                <h3>Akun</h3>
                <ul>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                </ul>
            </nav>
            <div class="hwf-col">
                <h3>Praktikum</h3>
                <ul>
                    <li><span>Modul 3 Automation Testing</span></li>
                    <li><span>EISD Laboratory</span></li>
                </ul>
            </div>
        </div>
        <div class="hwf-rule">
            <button type="button" class="hwf-up" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })">Back to top ↑</button>
        </div>
    </footer>

    <script>
        (() => {
            const root = document.getElementById('hwf-footer');
            const canvas = document.getElementById('hwf-canvas');
            const ctx = canvas?.getContext('2d');
            if (!root || !canvas || !ctx) return;

            const o = {
                wordmark: 'meowdopt',
                dotGap: 6,
                radius: 80,
                crop: 0.2,
                grain: 0.5,
                fontFamily: '"Bricolage Grotesque", "Plus Jakarta Sans", system-ui, sans-serif',
                fontWeight: 800,
                bg: '#0a0c1b',
                inkHex: '#f8fafc',
                ink: [248, 250, 252],
                warm: [198, 20, 159],
            };
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            let w = 0, h = 0, dpr = 1, px = -1e5, py = -1e5, raf = 0, visible = true, awake = true;
            let ring = { x: 0, y: 0, t: -1 };
            let dots = new Float32Array(0), count = 0, grainTile = null;

            const layout = () => {
                const rect = root.getBoundingClientRect();
                w = Math.max(1, Math.round(rect.width));
                h = Math.max(1, Math.round(rect.height));
                dpr = Math.min(window.devicePixelRatio || 1, 2);
                canvas.width = Math.round(w * dpr);
                canvas.height = Math.round(h * dpr);

                const mask = document.createElement('canvas');
                mask.width = w; mask.height = h;
                const m = mask.getContext('2d', { willReadFrequently: true });
                if (!m) return;
                m.font = `${o.fontWeight} 100px ${o.fontFamily}`;
                const measured = m.measureText(o.wordmark).width;
                const fit = measured > 0 ? (w * 1.02 / measured) * 100 : 0;
                m.font = `${o.fontWeight} ${fit}px ${o.fontFamily}`;
                const box = m.measureText(o.wordmark);
                const cap = box.actualBoundingBoxAscent || fit * 0.72;
                m.fillStyle = '#000';
                m.textBaseline = 'alphabetic';
                m.fillText(o.wordmark, (w - box.width) / 2, h + cap * o.crop);
                const img = m.getImageData(0, 0, w, h).data;

                const gap = o.dotGap, cols = Math.ceil(w / gap), rows = Math.ceil(h / gap), tmp = [];
                for (let gy = 0; gy < rows; gy++) {
                    for (let gx = 0; gx < cols; gx++) {
                        let sum = 0;
                        for (let sy = 0; sy < 3; sy++) {
                            for (let sx = 0; sx < 3; sx++) {
                                const x = Math.min(w - 1, Math.floor(gx * gap + ((sx + 0.5) * gap) / 3));
                                const y = Math.min(h - 1, Math.floor(gy * gap + ((sy + 0.5) * gap) / 3));
                                sum += img[(y * w + x) * 4 + 3];
                            }
                        }
                        const cov = sum / (9 * 255);
                        if (cov < 0.06) continue;
                        const hx = gx * gap + gap / 2, hy = gy * gap + gap / 2;
                        tmp.push(hx, hy, 0, 0, hx, hy, Math.sqrt(Math.min(1, cov)) * gap * 0.56);
                    }
                }
                dots = new Float32Array(tmp);
                count = tmp.length / 7;

                grainTile = document.createElement('canvas');
                grainTile.width = 256; grainTile.height = 256;
                const g = grainTile.getContext('2d');
                if (g) {
                    const id = g.createImageData(256, 256);
                    for (let i = 0; i < id.data.length; i += 4) {
                        const v = Math.random() * 255;
                        id.data[i] = id.data[i + 1] = id.data[i + 2] = v;
                        id.data[i + 3] = Math.random() < 0.5 ? 0 : 255;
                    }
                    g.putImageData(id, 0, 0);
                }
                awake = true;
            };

            const draw = (now) => {
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                ctx.fillStyle = o.bg;
                ctx.fillRect(0, 0, w, h);

                const r = reduced ? 0 : o.radius;
                const ringAge = ring.t < 0 ? 1e9 : now - ring.t;
                const ringR = ringAge * 0.9;
                let moving = false;

                for (let i = 0; i < count; i++) {
                    const j = i * 7;
                    let x = dots[j], y = dots[j + 1], vx = dots[j + 2], vy = dots[j + 3];
                    const hx = dots[j + 4], hy = dots[j + 5];
                    if (!reduced) {
                        if (ringAge < 900) {
                            const dx = hx - ring.x, dy = hy - ring.y;
                            const d = Math.sqrt(dx * dx + dy * dy) + 0.001;
                            const band = 1 - Math.min(1, Math.abs(d - ringR) / 26);
                            if (band > 0) {
                                const f = band * 3.2 * (1 - ringAge / 900);
                                vx += (dx / d) * f; vy += (dy / d) * f;
                            }
                        }
                        const dx = x - px, dy = y - py, d2 = dx * dx + dy * dy;
                        if (r > 0 && d2 < r * r) {
                            const d = Math.sqrt(d2) + 0.001, f = (1 - d / r) * 2.6;
                            vx += (dx / d) * f; vy += (dy / d) * f;
                        }
                        vx = (vx + (hx - x) * 0.05) * 0.84;
                        vy = (vy + (hy - y) * 0.05) * 0.84;
                        x += vx; y += vy;
                        if (Math.abs(vx) + Math.abs(vy) > 0.02 || Math.abs(x - hx) + Math.abs(y - hy) > 0.05) moving = true;
                        else { x = hx; y = hy; vx = 0; vy = 0; }
                        dots[j] = x; dots[j + 1] = y; dots[j + 2] = vx; dots[j + 3] = vy;
                    }
                    const k = Math.min(1, Math.hypot(x - hx, y - hy) / 28);
                    ctx.fillStyle = k > 0.02
                        ? `rgb(${Math.round(o.ink[0] + (o.warm[0] - o.ink[0]) * k)},${Math.round(o.ink[1] + (o.warm[1] - o.ink[1]) * k)},${Math.round(o.ink[2] + (o.warm[2] - o.ink[2]) * k)})`
                        : o.inkHex;
                    ctx.beginPath();
                    ctx.arc(x, y, dots[j + 6], 0, 6.2832);
                    ctx.fill();
                }

                if (grainTile && o.grain > 0) {
                    ctx.globalAlpha = o.grain * 0.09;
                    ctx.globalCompositeOperation = 'overlay';
                    const pattern = ctx.createPattern(grainTile, 'repeat');
                    if (pattern) { ctx.fillStyle = pattern; ctx.fillRect(0, 0, w, h); }
                    ctx.globalAlpha = 1;
                    ctx.globalCompositeOperation = 'source-over';
                }
                awake = moving || ringAge < 900 || px > -1e4;
            };

            const loop = (now) => { raf = 0; if (!visible) return; draw(now); if (awake) raf = requestAnimationFrame(loop); };
            const wake = () => { awake = true; if (!raf && visible) raf = requestAnimationFrame(loop); };

            root.addEventListener('pointermove', (e) => { const b = canvas.getBoundingClientRect(); px = e.clientX - b.left; py = e.clientY - b.top; wake(); });
            root.addEventListener('pointerleave', () => { px = -1e5; py = -1e5; wake(); });
            root.addEventListener('pointerdown', (e) => {
                if (reduced || e.target.closest('a,button')) return;
                const b = canvas.getBoundingClientRect();
                ring = { x: e.clientX - b.left, y: e.clientY - b.top, t: performance.now() };
                wake();
            });

            layout(); draw(performance.now()); wake();
            new ResizeObserver(() => { layout(); wake(); }).observe(root);
            new IntersectionObserver((entries) => { visible = entries[0] ? entries[0].isIntersecting : true; if (visible) wake(); }).observe(root);
            document.fonts?.ready?.then(() => { layout(); wake(); });
        })();
    </script>
@endsection
