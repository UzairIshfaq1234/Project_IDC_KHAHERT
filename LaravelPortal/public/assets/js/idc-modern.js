/* ============================================================
   IDC Modern Portal — core UI behaviors
   theme toggle · sidebar · live clock · counters · table search
   CSV export · print · fullscreen · file previews · password eyes
   ============================================================ */
(function () {
    'use strict';

    /* ---------- Theme (dark / light, persisted) ---------- */
    var root = document.documentElement;

    function applyTheme(theme) {
        root.setAttribute('data-theme', theme);
        try { localStorage.setItem('idc-theme', theme); } catch (e) {}
        document.querySelectorAll('[data-theme-toggle] i').forEach(function (icon) {
            icon.className = theme === 'dark' ? 'bi bi-sun' : 'bi bi-moon-stars';
        });
    }

    applyTheme((function () {
        try { return localStorage.getItem('idc-theme') || 'light'; } catch (e) { return 'light'; }
    })());

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-theme-toggle]');
        if (!btn) return;
        applyTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    });

    /* ---------- Mobile sidebar ---------- */
    document.addEventListener('click', function (e) {
        var sidebar = document.getElementById('idcSidebar');
        var backdrop = document.getElementById('sidebarBackdrop');
        if (!sidebar) return;

        if (e.target.closest('[data-sidebar-toggle]')) {
            sidebar.classList.toggle('show');
            if (backdrop) backdrop.classList.toggle('show', sidebar.classList.contains('show'));
        } else if (backdrop && e.target === backdrop) {
            sidebar.classList.remove('show');
            backdrop.classList.remove('show');
        }
    });

    /* ---------- Fullscreen ---------- */
    document.addEventListener('click', function (e) {
        if (!e.target.closest('[data-fullscreen-toggle]')) return;
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen && document.documentElement.requestFullscreen();
        } else {
            document.exitFullscreen && document.exitFullscreen();
        }
    });

    /* ---------- Live clock + greeting ---------- */
    function tickClock() {
        var now = new Date();
        var t = document.querySelectorAll('[data-clock-time]');
        var d = document.querySelectorAll('[data-clock-date]');
        var g = document.querySelectorAll('[data-greeting]');

        var timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        var dateStr = now.toLocaleDateString([], { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        var h = now.getHours();
        var greet = h < 12 ? 'Good morning' : h < 17 ? 'Good afternoon' : 'Good evening';

        t.forEach(function (el) { el.textContent = timeStr; });
        d.forEach(function (el) { el.textContent = dateStr; });
        g.forEach(function (el) { el.textContent = greet; });
    }
    tickClock();
    setInterval(tickClock, 1000);

    /* ---------- Animated counters ---------- */
    function animateCounter(el) {
        var target = parseFloat((el.getAttribute('data-count-to') || el.textContent || '0').replace(/,/g, ''));
        if (isNaN(target)) return;
        var duration = 1100, start = null;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(target * eased).toLocaleString();
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) { animateCounter(en.target); io.unobserve(en.target); }
            });
        }, { threshold: 0.35 });
        document.querySelectorAll('.counter').forEach(function (el) {
            el.setAttribute('data-count-to', el.textContent.trim());
            io.observe(el);
        });
    } else {
        document.querySelectorAll('.counter').forEach(animateCounter);
    }

    /* ---------- Client-side table search ---------- */
    document.querySelectorAll('[data-table-search]').forEach(function (input) {
        var table = document.querySelector(input.getAttribute('data-table-search'));
        if (!table) return;
        input.addEventListener('input', function () {
            var q = input.value.toLowerCase().trim();
            var rows = table.querySelectorAll('tbody tr');
            var visible = 0;
            rows.forEach(function (row) {
                if (row.hasAttribute('data-empty-row')) return;
                var hit = row.textContent.toLowerCase().indexOf(q) !== -1;
                row.style.display = hit ? '' : 'none';
                if (hit) visible++;
            });
            var empty = table.parentElement.querySelector('[data-search-empty]');
            if (empty) empty.style.display = visible === 0 ? '' : 'none';
        });
    });

    /* ---------- CSV export ---------- */
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-export-table]');
        if (!btn) return;
        var table = document.querySelector(btn.getAttribute('data-export-table'));
        if (!table) return;
        var rows = [];
        table.querySelectorAll('tr').forEach(function (tr) {
            if (tr.style.display === 'none') return;
            var cells = [];
            tr.querySelectorAll('th, td').forEach(function (cell) {
                if (cell.hasAttribute('data-no-export')) return;
                cells.push('"' + cell.innerText.replace(/\s+/g, ' ').trim().replace(/"/g, '""') + '"');
            });
            if (cells.length) rows.push(cells.join(','));
        });
        var blob = new Blob(['﻿' + rows.join('\n')], { type: 'text/csv;charset=utf-8;' });
        var a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = (btn.getAttribute('data-export-name') || 'idc-export') + '-' + new Date().toISOString().slice(0, 10) + '.csv';
        document.body.appendChild(a);
        a.click();
        a.remove();
    });

    /* ---------- Print ---------- */
    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-print-page]')) window.print();
    });

    /* ---------- Password visibility toggles ---------- */
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.toggle-password');
        if (!btn) return;
        e.preventDefault();
        var input = btn.closest('.input-icon-group').querySelector('input');
        if (!input) return;
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        var icon = btn.querySelector('i');
        if (icon) icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    });

    /* ---------- Caps-lock warning (login) ---------- */
    document.querySelectorAll('[data-capslock-watch]').forEach(function (input) {
        var warn = document.querySelector(input.getAttribute('data-capslock-watch'));
        if (!warn) return;
        input.addEventListener('keyup', function (e) {
            if (typeof e.getModifierState === 'function') {
                warn.classList.toggle('show', e.getModifierState('CapsLock'));
            }
        });
        input.addEventListener('blur', function () { warn.classList.remove('show'); });
    });

    /* ---------- Pretty file inputs (drop zone + image preview) ---------- */
    document.querySelectorAll('.file-drop').forEach(function (zone) {
        var input = zone.querySelector('input[type="file"]');
        if (!input) return;

        function showFile(file) {
            var nameEl = zone.querySelector('.fd-name');
            if (nameEl) nameEl.textContent = file ? file.name : '';
            var old = zone.querySelector('img.preview');
            if (old) old.remove();
            if (file && file.type && file.type.indexOf('image/') === 0) {
                var img = document.createElement('img');
                img.className = 'preview';
                img.alt = 'preview';
                img.src = URL.createObjectURL(file);
                zone.appendChild(img);
            }
        }

        zone.addEventListener('click', function (e) {
            if (e.target !== input) input.click();
        });
        input.addEventListener('change', function () { showFile(input.files[0]); });

        ['dragenter', 'dragover'].forEach(function (ev) {
            zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.add('dragover'); });
        });
        ['dragleave', 'drop'].forEach(function (ev) {
            zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.remove('dragover'); });
        });
        zone.addEventListener('drop', function (e) {
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                showFile(input.files[0]);
            }
        });
    });

    /* ---------- Chart.js theme defaults ---------- */
    if (window.Chart) {
        Chart.defaults.font.family = "'Plus Jakarta Sans', 'Inter', system-ui, sans-serif";
        Chart.defaults.font.weight = 600;
        Chart.defaults.plugins.legend.labels.usePointStyle = true;
        Chart.defaults.plugins.legend.labels.boxWidth = 8;
        Chart.defaults.plugins.tooltip.cornerRadius = 10;
        Chart.defaults.plugins.tooltip.padding = 12;
        Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(15, 23, 42, .92)';
    }
})();
