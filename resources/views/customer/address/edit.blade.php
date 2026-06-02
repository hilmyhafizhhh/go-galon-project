<x-app-layout>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        :root {
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-400: #60a5fa;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --blue-800: #1e40af;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --red: #e11d48;
            --red-soft: #fff1f2;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
            --shadow-md: 0 4px 16px rgba(37, 99, 235, .08), 0 1px 4px rgba(0, 0, 0, .04);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f6ff;
            color: var(--slate-800);
            min-height: 100vh;
        }

        .dark body {
            background: #0b1120;
            color: #f1f5f9
        }

        .dark {
            --blue-50: rgba(37, 99, 235, .1);
            --blue-100: rgba(37, 99, 235, .18);
            --blue-200: rgba(37, 99, 235, .28);
            --slate-50: #0f172a;
            --slate-100: #1e293b;
            --slate-200: #273449;
            --slate-300: #334155;
            --slate-400: #64748b;
            --slate-500: #94a3b8;
            --slate-600: #cbd5e1;
            --slate-700: #e2e8f0;
            --slate-800: #f1f5f9;
            --slate-900: #f8fafc;
            --shadow-md: 0 4px 16px rgba(0, 0, 0, .3), 0 1px 4px rgba(0, 0, 0, .2);
        }

        /* ─ Header ── */
        .ca-header {
            position: sticky;
            top: 0;
            z-index: 40;
            background: rgba(255, 255, 255, .94);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-bottom: 1px solid rgba(37, 99, 235, .1);
            box-shadow: 0 2px 16px rgba(37, 99, 235, .06);
        }

        .dark .ca-header {
            background: rgba(15, 23, 42, .94);
            border-bottom-color: rgba(255, 255, 255, .06);
            box-shadow: 0 2px 16px rgba(0, 0, 0, .2);
        }

        .ca-header__inner {
            max-width: 720px;
            margin: 0 auto;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 60px;
        }

        .ca-header__back {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--blue-50);
            border: 1px solid rgba(37, 99, 235, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue-600);
            text-decoration: none;
            transition: background .15s, transform .15s;
            flex-shrink: 0;
        }

        .ca-header__back:hover {
            background: var(--blue-100);
            transform: translateX(-1px)
        }

        .dark .ca-header__back {
            background: rgba(37, 99, 235, .12);
            border-color: rgba(37, 99, 235, .25);
            color: #60a5fa
        }

        .ca-header__titles {
            flex: 1;
            text-align: center
        }

        .ca-header__title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--slate-800);
            line-height: 1
        }

        .dark .ca-header__title {
            color: #f1f5f9
        }

        .ca-header__sub {
            font-size: .7rem;
            color: var(--slate-400);
            margin-top: 3px;
            font-weight: 500
        }

        .ca-header__icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--blue-50);
            border: 1px solid rgba(37, 99, 235, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue-600);
        }

        .dark .ca-header__icon {
            background: rgba(37, 99, 235, .12);
            border-color: rgba(37, 99, 235, .25);
            color: #60a5fa
        }

        /* ─ Body ── */
        .ca-body {
            max-width: 720px;
            margin: 0 auto;
            padding: 16px 14px 110px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        @media(min-width:640px) {
            .ca-body {
                padding: 20px 24px 120px
            }
        }

        /* ─ Reveal ── */
        .ca-reveal {
            opacity: 0;
            transform: translateY(14px);
            transition: opacity .4s cubic-bezier(.22, 1, .36, 1), transform .4s cubic-bezier(.22, 1, .36, 1);
        }

        .ca-reveal.in {
            opacity: 1;
            transform: none
        }

        /* ─ Error banner ── */
        .ca-error {
            background: var(--red-soft);
            border: 1px solid rgba(225, 29, 72, .2);
            border-radius: var(--radius-md);
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .82rem;
            color: var(--red);
            font-weight: 600;
        }

        .dark .ca-error {
            background: rgba(225, 29, 72, .1);
            border-color: rgba(225, 29, 72, .25)
        }

        /* ─ Delete danger banner ── */
        .ca-danger-card {
            background: #fff;
            border: 1px solid rgba(225, 29, 72, .18);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .dark .ca-danger-card {
            background: rgba(17, 24, 39, .95);
            border-color: rgba(225, 29, 72, .25);
        }

        .ca-danger-inner {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
        }

        .ca-danger-icon {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-md);
            background: var(--red-soft);
            border: 1px solid rgba(225, 29, 72, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--red);
            flex-shrink: 0;
        }

        .dark .ca-danger-icon {
            background: rgba(225, 29, 72, .1);
            border-color: rgba(225, 29, 72, .25);
        }

        .ca-danger-body {
            flex: 1;
            min-width: 0;
        }

        .ca-danger-title {
            font-size: .88rem;
            font-weight: 700;
            color: var(--slate-800);
        }

        .dark .ca-danger-title {
            color: #f1f5f9;
        }

        .ca-danger-sub {
            font-size: .72rem;
            color: var(--slate-400);
            margin-top: 2px;
        }

        .ca-danger-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: var(--red-soft);
            border: 1px solid rgba(225, 29, 72, .22);
            border-radius: var(--radius-sm);
            color: var(--red);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .78rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s, box-shadow .15s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .ca-danger-btn:hover {
            background: #ffe4e6;
            box-shadow: 0 2px 8px rgba(225, 29, 72, .15);
        }

        .dark .ca-danger-btn {
            background: rgba(225, 29, 72, .1);
            border-color: rgba(225, 29, 72, .25);
        }

        .dark .ca-danger-btn:hover {
            background: rgba(225, 29, 72, .18);
        }

        /* ─ Section label ── */
        .ca-section-label {
            font-size: .68rem;
            font-weight: 700;
            color: var(--slate-400);
            letter-spacing: .6px;
            text-transform: uppercase;
            padding: 0 2px;
            margin-bottom: 6px;
        }

        /* ─ Card ── */
        .ca-card {
            background: rgba(255, 255, 255, .97);
            border: 1px solid rgba(37, 99, 235, .08);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .dark .ca-card {
            background: rgba(17, 24, 39, .95);
            border-color: rgba(255, 255, 255, .07);
        }

        /* ─ Field row ── */
        .ca-field {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-bottom: 1px solid rgba(37, 99, 235, .06);
        }

        .ca-field:last-child {
            border-bottom: none
        }

        .dark .ca-field {
            border-bottom-color: rgba(255, 255, 255, .05)
        }

        .ca-field__icon {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            background: var(--blue-50);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue-600);
            margin-top: 2px;
            border: 1px solid rgba(37, 99, 235, .12);
        }

        .dark .ca-field__icon {
            background: rgba(37, 99, 235, .12);
            border-color: rgba(37, 99, 235, .22);
            color: #60a5fa
        }

        .ca-field__body {
            flex: 1;
            min-width: 0
        }

        .ca-field__label {
            display: block;
            font-size: .68rem;
            font-weight: 700;
            color: var(--slate-400);
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .ca-field__input,
        .ca-field__textarea {
            display: block;
            width: 100%;
            background: #f8faff;
            border: 1.5px solid rgba(37, 99, 235, .12);
            border-radius: 10px;
            padding: 9px 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .875rem;
            font-weight: 500;
            color: var(--slate-800);
            outline: none;
            transition: border-color .18s, box-shadow .18s, background .18s;
            resize: none;
            line-height: 1.5;
            box-sizing: border-box;
        }

        .dark .ca-field__input,
        .dark .ca-field__textarea {
            background: #0f172a;
            border-color: rgba(255, 255, 255, .1);
            color: #f1f5f9;
        }

        .ca-field__input::placeholder,
        .ca-field__textarea::placeholder {
            color: var(--slate-300)
        }

        .dark .ca-field__input::placeholder,
        .dark .ca-field__textarea::placeholder {
            color: #475569
        }

        .ca-field__input:focus,
        .ca-field__textarea:focus {
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .dark .ca-field__input:focus,
        .dark .ca-field__textarea:focus {
            background: #1e293b;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .2);
        }

        .ca-field__input.is-invalid,
        .ca-field__textarea.is-invalid {
            border-color: #e11d48;
            box-shadow: 0 0 0 3px rgba(225, 29, 72, .1);
        }

        .ca-field__error {
            display: block;
            margin-top: 5px;
            font-size: .72rem;
            color: #e11d48;
            font-weight: 600;
        }

        /* ─ Map ── */
        .ca-map-trigger {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px;
            cursor: pointer;
            transition: background .15s;
            border-bottom: 1px solid rgba(37, 99, 235, .06);
        }

        .ca-map-trigger:hover {
            background: var(--blue-50)
        }

        .dark .ca-map-trigger {
            border-bottom-color: rgba(255, 255, 255, .05)
        }

        .dark .ca-map-trigger:hover {
            background: rgba(37, 99, 235, .07)
        }

        .ca-map-trigger__ico {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border-radius: var(--radius-md);
            background: var(--blue-50);
            border: 1px solid rgba(37, 99, 235, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue-600);
            transition: background .15s, transform .2s;
        }

        .dark .ca-map-trigger__ico {
            background: rgba(37, 99, 235, .12);
            border-color: rgba(37, 99, 235, .22);
            color: #60a5fa
        }

        .ca-map-trigger:hover .ca-map-trigger__ico {
            background: var(--blue-100);
            transform: scale(1.05)
        }

        .ca-map-trigger__body {
            flex: 1;
            min-width: 0
        }

        .ca-map-trigger__title {
            font-size: .88rem;
            font-weight: 700;
            color: var(--slate-800);
            line-height: 1.3;
        }

        .dark .ca-map-trigger__title {
            color: #f1f5f9
        }

        .ca-map-trigger__sub {
            font-size: .73rem;
            color: var(--slate-400);
            margin-top: 2px;
            font-weight: 500;
        }

        .ca-map-trigger__badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .3px;
            background: var(--blue-50);
            color: var(--blue-600);
            border: 1px solid rgba(37, 99, 235, .2);
        }

        .dark .ca-map-trigger__badge {
            background: rgba(37, 99, 235, .12);
            color: #60a5fa;
            border-color: rgba(37, 99, 235, .3)
        }

        .ca-map-expand {
            display: none;
            flex-direction: column;
            animation: caFadeUp .25s ease both;
        }

        .ca-map-expand.open {
            display: flex
        }

        @keyframes caFadeUp {
            from {
                opacity: 0;
                transform: translateY(8px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        #ca-map {
            width: 100%;
            height: 240px;
            z-index: 1;
            cursor: grab
        }

        #ca-map:active {
            cursor: grabbing
        }

        .ca-map-hint {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: rgba(37, 99, 235, .04);
            border-top: 1px solid rgba(37, 99, 235, .08);
            font-size: .73rem;
            color: var(--slate-400);
            font-weight: 500;
        }

        .dark .ca-map-hint {
            background: rgba(37, 99, 235, .07);
            border-top-color: rgba(37, 99, 235, .15)
        }

        .ca-map-hint svg {
            flex-shrink: 0;
            color: var(--blue-600)
        }

        .dark .ca-map-hint svg {
            color: #60a5fa
        }

        .ca-map-result {
            display: none;
            flex-direction: column;
            gap: 4px;
            padding: 12px 16px;
            border-top: 1px solid rgba(37, 99, 235, .08);
            background: var(--blue-50);
        }

        .ca-map-result.show {
            display: flex
        }

        .dark .ca-map-result {
            background: rgba(37, 99, 235, .09);
            border-top-color: rgba(37, 99, 235, .18)
        }

        .ca-map-result__chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--blue-600);
        }

        .dark .ca-map-result__chip {
            color: #60a5fa
        }

        .ca-map-result__addr {
            font-size: .8rem;
            color: var(--slate-700);
            line-height: 1.5;
            font-weight: 500;
        }

        .dark .ca-map-result__addr {
            color: var(--slate-300)
        }

        .ca-map-confirm {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin: 10px 16px 14px;
            padding: 11px 0;
            background: linear-gradient(135deg, var(--blue-600), var(--blue-700));
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
            transition: box-shadow .2s, transform .15s;
        }

        .ca-map-confirm:hover {
            box-shadow: 0 6px 20px rgba(37, 99, 235, .42);
            transform: translateY(-1px)
        }

        .ca-map-confirm.show {
            display: flex
        }

        .ca-map-trigger__detected {
            display: none;
            font-size: .73rem;
            color: var(--blue-600);
            margin-top: 3px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dark .ca-map-trigger__detected {
            color: #60a5fa
        }

        .ca-map-trigger__detected.show {
            display: block
        }

        /* ─ Toggle ── */
        .ca-toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 16px;
        }

        .ca-toggle-row__left {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .ca-toggle-row__ico {
            width: 32px;
            height: 32px;
            background: var(--blue-50);
            border-radius: var(--radius-sm);
            border: 1px solid rgba(37, 99, 235, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue-600);
            flex-shrink: 0;
        }

        .dark .ca-toggle-row__ico {
            background: rgba(37, 99, 235, .12);
            border-color: rgba(37, 99, 235, .22);
            color: #60a5fa
        }

        .ca-toggle-row__text .ca-toggle-row__title {
            font-size: .88rem;
            font-weight: 700;
            color: var(--slate-800)
        }

        .dark .ca-toggle-row__text .ca-toggle-row__title {
            color: #f1f5f9
        }

        .ca-toggle-row__text .ca-toggle-row__sub {
            font-size: .72rem;
            color: var(--slate-400);
            margin-top: 1px
        }

        .ca-switch {
            position: relative;
            width: 44px;
            height: 26px;
            flex-shrink: 0
        }

        .ca-switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute
        }

        .ca-switch__track {
            position: absolute;
            inset: 0;
            background: var(--slate-200);
            border-radius: 13px;
            transition: background .22s;
            cursor: pointer;
        }

        .dark .ca-switch__track {
            background: var(--slate-300)
        }

        .ca-switch__thumb {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .2);
            transition: transform .22s cubic-bezier(.34, 1.56, .64, 1);
            pointer-events: none;
        }

        .ca-switch input:checked~.ca-switch__track {
            background: var(--blue-600)
        }

        .ca-switch input:checked~.ca-switch__thumb {
            transform: translateX(18px)
        }

        /* ─ Info strip ── */
        .ca-info-strip {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 10px 16px;
            background: var(--blue-50);
            border-top: 1px solid rgba(37, 99, 235, .08);
            font-size: .72rem;
            color: var(--slate-500);
            line-height: 1.5;
        }

        .dark .ca-info-strip {
            background: rgba(37, 99, 235, .08);
            border-top-color: rgba(37, 99, 235, .15)
        }

        .ca-info-strip svg {
            flex-shrink: 0;
            color: var(--blue-600);
            margin-top: 1px
        }

        .dark .ca-info-strip svg {
            color: #60a5fa
        }

        /* ─ Footer ── */
        .ca-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: rgba(255, 255, 255, .97);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-top: 1px solid rgba(37, 99, 235, .1);
            box-shadow: 0 -4px 24px rgba(37, 99, 235, .1);
            padding: 12px 14px max(12px, env(safe-area-inset-bottom));
        }

        .dark .ca-footer {
            background: rgba(15, 23, 42, .97);
            border-top-color: rgba(255, 255, 255, .07);
            box-shadow: 0 -4px 24px rgba(0, 0, 0, .3);
        }

        .ca-footer__inner {
            max-width: 720px;
            margin: 0 auto
        }

        .ca-footer__btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--blue-600), var(--blue-700));
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .9rem;
            font-weight: 800;
            cursor: pointer;
            letter-spacing: -.2px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, .35);
            transition: box-shadow .2s, transform .15s, opacity .2s;
        }

        .ca-footer__btn:hover {
            box-shadow: 0 6px 20px rgba(37, 99, 235, .45);
            transform: translateY(-1px)
        }

        .ca-footer__btn:disabled {
            opacity: .45;
            cursor: not-allowed;
            transform: none
        }

        /* ─ Leaflet override ── */
        .leaflet-control-attribution {
            display: none !important
        }

        .leaflet-control-zoom {
            border: 1px solid rgba(37, 99, 235, .15) !important;
            border-radius: var(--radius-sm) !important;
            box-shadow: var(--shadow-md) !important;
        }

        .leaflet-control-zoom a {
            background: #fff !important;
            color: var(--blue-600) !important;
            font-weight: 800 !important;
        }

        .dark .leaflet-control-zoom a {
            background: #1e293b !important;
            color: #60a5fa !important
        }

        /* ─ Delete modal ── */
        .ca-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999;
            background: rgba(15, 23, 42, .55);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            align-items: flex-end;
            justify-content: center;
            padding: 0;
        }

        .ca-modal-overlay.open {
            display: flex
        }

        .ca-modal {
            width: 100%;
            max-width: 520px;
            background: #fff;
            border-radius: 22px 22px 0 0;
            padding: 24px 20px max(20px, env(safe-area-inset-bottom));
            box-shadow: 0 -8px 40px rgba(15, 23, 42, .18);
            animation: caModalUp .28s cubic-bezier(.22, 1, .36, 1);
        }

        .dark .ca-modal {
            background: #0f172a;
        }

        @keyframes caModalUp {
            from {
                transform: translateY(60px);
                opacity: 0
            }

            to {
                transform: none;
                opacity: 1
            }
        }

        .ca-modal__pill {
            width: 36px;
            height: 4px;
            border-radius: 99px;
            background: var(--slate-200);
            margin: 0 auto 20px;
        }

        .dark .ca-modal__pill {
            background: var(--slate-300)
        }

        .ca-modal__icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--red-soft);
            border: 2px solid rgba(225, 29, 72, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--red);
            margin: 0 auto 14px;
        }

        .dark .ca-modal__icon {
            background: rgba(225, 29, 72, .12);
            border-color: rgba(225, 29, 72, .28)
        }

        .ca-modal__title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--slate-800);
            text-align: center;
            margin-bottom: 6px;
        }

        .dark .ca-modal__title {
            color: #f1f5f9
        }

        .ca-modal__sub {
            font-size: .8rem;
            color: var(--slate-400);
            text-align: center;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .ca-modal__actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .ca-modal__del {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 13px;
            background: linear-gradient(135deg, #e11d48, #be123c);
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .88rem;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(225, 29, 72, .35);
            transition: box-shadow .2s, transform .15s;
        }

        .ca-modal__del:hover {
            box-shadow: 0 6px 20px rgba(225, 29, 72, .45);
            transform: translateY(-1px)
        }

        .ca-modal__cancel {
            padding: 13px;
            background: var(--slate-100);
            border: none;
            border-radius: var(--radius-md);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .88rem;
            font-weight: 700;
            color: var(--slate-600);
            cursor: pointer;
            transition: background .15s;
        }

        .dark .ca-modal__cancel {
            background: rgba(255, 255, 255, .07);
            color: var(--slate-400)
        }

        .ca-modal__cancel:hover {
            background: var(--slate-200)
        }

        .dark .ca-modal__cancel:hover {
            background: rgba(255, 255, 255, .12)
        }
    </style>

    {{-- ── Header ── --}}
    <div class="ca-header">
        <div class="ca-header__inner">
            <a href="javascript:history.back()" class="ca-header__back" aria-label="Kembali">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round"
                    stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="ca-header__titles">
                <div class="ca-header__title">Ubah Alamat</div>
                <div class="ca-header__sub">Perbarui detail lokasi pengiriman kamu</div>
            </div>
            <div class="ca-header__icon" aria-hidden="true">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- ── Body ── --}}
    <div class="ca-body">

        @if ($errors->any())
            <div class="ca-error ca-reveal" data-delay="0">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                    stroke-linejoin="round" viewBox="0 0 24 24" style="flex-shrink:0">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 8v4M12 16h.01" />
                </svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('customer.address.update', $address->id) }}" method="POST" id="caForm">
            @csrf
            @method('PUT')

            <input type="hidden" name="latitude" id="ca_lat" value="{{ old('latitude', $address->latitude) }}">
            <input type="hidden" name="longitude" id="ca_lng" value="{{ old('longitude', $address->longitude) }}">

            {{-- ── Card 1: Detail Alamat ── --}}
            <div class="ca-section-label ca-reveal" data-delay="0">Detail Alamat</div>
            <div class="ca-card ca-reveal" data-delay="40">

                {{-- Label --}}
                <div class="ca-field">
                    <div class="ca-field__icon" aria-hidden="true">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z" />
                            <line x1="7" y1="7" x2="7.01" y2="7" />
                        </svg>
                    </div>
                    <div class="ca-field__body">
                        <label class="ca-field__label" for="ca_label">Label</label>
                        <input id="ca_label" type="text" name="label"
                            class="ca-field__input {{ $errors->has('label') ? 'is-invalid' : '' }}"
                            placeholder="cth: Rumah, Kantor, Kos…" value="{{ old('label', $address->label) }}"
                            autocomplete="off">
                        @error('label')
                            <span class="ca-field__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Gunakan Lokasi / Map ── --}}
                <div class="ca-field" style="padding:0;border-bottom:1px solid rgba(37,99,235,.06);display:block">
                    <div class="ca-map-trigger" id="caMapTrigger" role="button" tabindex="0" aria-expanded="false"
                        aria-label="Gunakan lokasi saat ini">
                        <div class="ca-map-trigger__ico" aria-hidden="true">
                            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div class="ca-map-trigger__body" style="min-width:0">
                            <div style="display:flex;align-items:center;gap:7px">
                                <span class="ca-map-trigger__title">Perbarui Lokasi via Peta</span>
                                <span class="ca-map-trigger__badge">GPS</span>
                            </div>
                            <div class="ca-map-trigger__sub">Geser peta untuk pin titik lokasi tepat</div>
                            <div class="ca-map-trigger__detected" id="caMapDetected"></div>
                        </div>
                        <svg id="caMapChevron" width="16" height="16" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"
                            style="flex-shrink:0;color:var(--slate-300);transition:transform .25s">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </div>

                    <div class="ca-map-expand" id="caMapExpand">
                        <div id="ca-map"></div>
                        <div class="ca-map-hint">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4M12 8h.01" />
                            </svg>
                            Geser peta agar pin berada tepat di lokasi kamu
                        </div>
                        <div class="ca-map-result" id="caMapResult">
                            <div class="ca-map-result__chip">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" />
                                </svg>
                                Alamat Terdeteksi
                            </div>
                            <div class="ca-map-result__addr" id="caMapResultText">Mendeteksi lokasi…</div>
                        </div>
                        <button type="button" class="ca-map-confirm" id="caMapConfirm">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            Konfirmasi Lokasi Ini
                        </button>
                    </div>
                </div>

                {{-- Alamat Lengkap ── --}}
                <div class="ca-field" style="border-bottom:none">
                    <div class="ca-field__icon" aria-hidden="true">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div class="ca-field__body">
                        <label class="ca-field__label" for="ca_address">Alamat Lengkap</label>
                        <textarea id="ca_address" name="address"
                            class="ca-field__textarea {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="3"
                            placeholder="Nama jalan, nomor, RT/RW, kelurahan, patokan…">{{ old('address', $address->address) }}</textarea>
                        @error('address')
                            <span class="ca-field__error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- ── Card 2: Preferensi ── --}}
            <div class="ca-section-label ca-reveal" data-delay="80" style="margin-top:4px">Preferensi</div>
            <div class="ca-card ca-reveal" data-delay="120">
                <div class="ca-toggle-row">
                    <div class="ca-toggle-row__left">
                        <div class="ca-toggle-row__ico" aria-hidden="true">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <div class="ca-toggle-row__text">
                            <div class="ca-toggle-row__title">Jadikan alamat utama</div>
                            <div class="ca-toggle-row__sub">Akan otomatis dipilih saat checkout</div>
                        </div>
                    </div>
                    <label class="ca-switch" aria-label="Jadikan alamat utama">
                        <input type="checkbox" name="is_default" value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                        <div class="ca-switch__track"></div>
                        <div class="ca-switch__thumb"></div>
                    </label>
                </div>
                <div class="ca-info-strip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4M12 8h.01" />
                    </svg>
                    Kamu bisa mengubah alamat utama kapan saja di halaman daftar alamat.
                </div>
            </div>

        </form>

        {{-- ── Danger zone: Hapus Alamat ── --}}
        <div class="ca-section-label ca-reveal" data-delay="160" style="margin-top:4px">Zona Berbahaya</div>
        <div class="ca-danger-card ca-reveal" data-delay="200">
            <div class="ca-danger-inner">
                <div class="ca-danger-icon" aria-hidden="true">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                        <path d="M10 11v6M14 11v6" />
                        <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                    </svg>
                </div>
                <div class="ca-danger-body">
                    <div class="ca-danger-title">Hapus Alamat</div>
                    <div class="ca-danger-sub">Tindakan ini tidak dapat dibatalkan</div>
                </div>
                <button type="button" class="ca-danger-btn" id="caDeleteTrigger">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                        <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                    </svg>
                    Hapus
                </button>
            </div>
        </div>

    </div>

    {{-- ── Footer ── --}}
    <div class="ca-footer">
        <div class="ca-footer__inner">
            <button type="submit" form="caForm" class="ca-footer__btn">
                Simpan Perubahan
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round"
                    stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    {{-- ── Delete confirmation modal ── --}}
    <div class="ca-modal-overlay" id="caDeleteModal" role="dialog" aria-modal="true" aria-labelledby="caModalTitle">
        <div class="ca-modal">
            <div class="ca-modal__pill"></div>
            <div class="ca-modal__icon" aria-hidden="true">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                    <path d="M10 11v6M14 11v6" />
                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                </svg>
            </div>
            <div class="ca-modal__title" id="caModalTitle">Hapus alamat ini?</div>
            <div class="ca-modal__sub">
                Alamat <strong>{{ $address->label }}</strong> akan dihapus permanen.<br>
                Tindakan ini tidak bisa dibatalkan.
            </div>
            <div class="ca-modal__actions">
                <form action="{{ route('customer.address.destroy', $address->id) }}" method="POST" id="caDeleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ca-modal__del" style="width:100%">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                            <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                        </svg>
                        Ya, Hapus Sekarang
                    </button>
                </form>
                <button type="button" class="ca-modal__cancel" id="caDeleteCancel">Batal</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            /* ── Reveal animation ── */
            document.querySelectorAll('.ca-reveal').forEach(el => {
                const delay = parseInt(el.dataset.delay) || 0;
                setTimeout(() => el.classList.add('in'), delay + 40);
            });

            /* ── Map ── */
            const trigger = document.getElementById('caMapTrigger');
            const expand = document.getElementById('caMapExpand');
            const chevron = document.getElementById('caMapChevron');
            const mapResult = document.getElementById('caMapResult');
            const resultText = document.getElementById('caMapResultText');
            const confirmBtn = document.getElementById('caMapConfirm');
            const addrInput = document.getElementById('ca_address');
            const detected = document.getElementById('caMapDetected');
            const latInput = document.getElementById('ca_lat');
            const lngInput = document.getElementById('ca_lng');

            let map, marker, mapReady = false;

            function openMap() {
                expand.classList.add('open');
                trigger.setAttribute('aria-expanded', 'true');
                chevron.style.transform = 'rotate(90deg)';
                if (!mapReady) initMap();
            }
            function closeMap() {
                expand.classList.remove('open');
                trigger.setAttribute('aria-expanded', 'false');
                chevron.style.transform = '';
            }

            trigger.addEventListener('click', () => expand.classList.contains('open') ? closeMap() : openMap());
            trigger.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); trigger.click(); } });

            function initMap() {
                mapReady = true;
                const defLat = {{ $address->latitude ?? -6.2088 }};
                const defLng = {{ $address->longitude ?? 106.8456 }};

                map = L.map('ca-map', { center: [defLat, defLng], zoom: 16, zoomControl: true, attributionControl: false });
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

                const pinSvg = `<div style="width:36px;height:36px;position:relative;transform:translate(-50%,-100%)">
                <svg viewBox="0 0 36 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 0C9.163 0 2 7.163 2 16c0 11.084 14.08 25.764 15.297 26.996a.97.97 0 001.406 0C19.92 41.764 34 27.084 34 16 34 7.163 26.837 0 18 0z" fill="#2563eb"/>
                    <circle cx="18" cy="16" r="6" fill="#fff"/>
                </svg>
                <div style="position:absolute;bottom:-2px;left:50%;transform:translateX(-50%);width:6px;height:6px;background:rgba(37,99,235,.3);border-radius:50%;animation:caPinShadow 1.2s ease-in-out infinite"></div>
            </div>`;

                const pinStyle = document.createElement('style');
                pinStyle.textContent = '@keyframes caPinShadow{0%,100%{transform:translateX(-50%) scale(1);opacity:.4}50%{transform:translateX(-50%) scale(1.4);opacity:.15}}';
                document.head.appendChild(pinStyle);

                const pinIcon = L.divIcon({ className: '', html: pinSvg, iconSize: [36, 44], iconAnchor: [18, 44] });
                marker = L.marker([defLat, defLng], { icon: pinIcon }).addTo(map);

                map.on('moveend', () => {
                    const c = map.getCenter();

                    marker.setLatLng(c);

                    latInput.value = c.lat;
                    lngInput.value = c.lng;

                    reverseGeocode(c.lat, c.lng);
                });

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        pos => {
                            latInput.value = pos.coords.latitude;
                            lngInput.value = pos.coords.longitude;

                            map.setView(
                                [pos.coords.latitude, pos.coords.longitude],
                                17
                            );
                        },
                        () => reverseGeocode(defLat, defLng)
                    );
                } else {
                    reverseGeocode(defLat, defLng);
                }
            }

            let gcTimer;
            function reverseGeocode(lat, lng) {
                mapResult.classList.add('show');
                resultText.textContent = 'Mendeteksi alamat…';
                confirmBtn.classList.remove('show');
                clearTimeout(gcTimer);
                gcTimer = setTimeout(async () => {
                    try {
                        const r = await fetch(
                            `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&accept-language=id`,
                            { headers: { 'User-Agent': 'EcomApp/1.0' } }
                        );
                        const d = await r.json();
                        const addr = d.display_name || 'Alamat tidak ditemukan';
                        resultText.textContent = addr;
                        confirmBtn._addr = addr;
                        confirmBtn.classList.add('show');
                    } catch {
                        resultText.textContent = 'Gagal mendeteksi — isi alamat secara manual.';
                    }
                }, 800);
            }

            confirmBtn.addEventListener('click', () => {

                const center = map.getCenter();

                latInput.value = center.lat;
                lngInput.value = center.lng;

                const addr = confirmBtn._addr || '';
                addrInput.value = addr;

                const preview = addr.length > 48
                    ? addr.slice(0, 48) + '…'
                    : addr;

                detected.textContent = '📍 ' + preview;
                detected.classList.add('show');

                closeMap();

                addrInput.parentElement.parentElement.style.background =
                    'rgba(37,99,235,.04)';

                setTimeout(() =>
                    addrInput.parentElement.parentElement.style.background = '',
                    900
                );
            });

            /* ── Submit loading state ── */
            document.getElementById('caForm').addEventListener('submit', function () {
                const btn = document.querySelector('.ca-footer__btn');
                btn.disabled = true;
                btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="animation:caSpin .7s linear infinite"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Menyimpan…`;
            });

            const spinStyle = document.createElement('style');
            spinStyle.textContent = '@keyframes caSpin{to{transform:rotate(360deg)}}';
            document.head.appendChild(spinStyle);

            /* ── Delete modal ── */
            const modal = document.getElementById('caDeleteModal');
            const deleteTrigger = document.getElementById('caDeleteTrigger');
            const deleteCancel = document.getElementById('caDeleteCancel');

            deleteTrigger.addEventListener('click', () => modal.classList.add('open'));
            deleteCancel.addEventListener('click', () => modal.classList.remove('open'));
            modal.addEventListener('click', e => { if (e.target === modal) modal.classList.remove('open'); });
            document.addEventListener('keydown', e => { if (e.key === 'Escape') modal.classList.remove('open'); });

        });
    </script>

</x-app-layout>