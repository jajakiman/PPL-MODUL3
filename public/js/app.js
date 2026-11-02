document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-menu-toggle]');

    document.querySelectorAll('[data-menu-toggle][aria-expanded="true"]').forEach((open) => {
        if (open !== toggle && !document.getElementById(open.getAttribute('aria-controls')).contains(event.target)) {
            setMenu(open, false);
        }
    });

    if (toggle) {
        setMenu(toggle, toggle.getAttribute('aria-expanded') !== 'true');
    }

    const confirmBtn = event.target.closest('[data-confirm-url]');
    if (confirmBtn) {
        const modal = document.getElementById('modal-confirm');
        modal.querySelector('form').action = confirmBtn.dataset.confirmUrl;
        modal.querySelectorAll('[data-cat-name]').forEach((el) => (el.textContent = confirmBtn.dataset.confirmCat));
        modal.showModal();
    }

    if (event.target.closest('[data-modal-close]') || event.target.tagName === 'DIALOG') {
        event.target.closest('dialog')?.close();
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    document.querySelectorAll('[data-menu-toggle][aria-expanded="true"]').forEach((open) => {
        setMenu(open, false);
        open.focus();
    });
});

document.addEventListener('submit', (event) => {
    const message = event.target.dataset.confirm;
    if (message && !confirm(message)) {
        event.preventDefault();
    }
});

(function bloomField() {
    const field = document.getElementById('floral-bg');
    if (!field || matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const seed = 449994798;
    const hash = (n) => {
        const x = Math.sin(seed + n * 12.9898) * 43758.5453;
        return (x - Math.floor(x)) * Math.PI * 2;
    };
    const blobs = [[78.73, 61.82], [36.12, 80.21], [68.19, 11.87], [92.11, 81.09]]
        .map(([x, y], i) => ({ x, y, p: hash(i * 2 + 1), p2: hash(i * 2 + 2) }));
    const amt = 0.19;
    const dir = 1;
    let start;

    function frame(now) {
        start ??= now;
        const ph = ((now - start) / 1000) * 0.26 * dir;
        blobs.forEach((b, i) => {
            const dx = (Math.sin(ph * 0.55 + b.p) - Math.sin(b.p)) * 14 * amt;
            const dy = (Math.sin(ph * 0.43 + b.p2) - Math.sin(b.p2)) * 14 * amt;
            field.style.setProperty(`--b${i + 1}x`, `${b.x + dx}%`);
            field.style.setProperty(`--b${i + 1}y`, `${b.y + dy}%`);
        });
        requestAnimationFrame(frame);
    }

    requestAnimationFrame(frame);
})();

function setMenu(toggle, open) {
    toggle.setAttribute('aria-expanded', String(open));
    document.getElementById(toggle.getAttribute('aria-controls')).hidden = !open;
}
