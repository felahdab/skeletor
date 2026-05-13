<div>
    <style>
        .ps-wrapper { margin-bottom: 2rem; }
        .ps-title { font-size: 1.5rem; font-weight: 800; color: #111827; margin: 0 0 0.25rem; }
        .ps-subtitle { font-size: 0.875rem; color: #6b7280; margin: 0; }
        .ps-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; }

        .ps-card {
            position: relative;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            background: white;
            padding: 1.75rem 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .ps-card:hover {
            box-shadow: 0 6px 20px rgba(99,102,241,0.15);
            border-color: #a5b4fc;
        }

        .ps-icon-wrap {
            width: 3rem; height: 3rem;
            border-radius: 0.75rem;
            background: #eef2ff;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .ps-icon { width: 1.5rem; height: 1.5rem; color: #6366f1; }
        .ps-label { font-weight: 700; font-size: 1rem; color: #111827; }
        .ps-desc { font-size: 0.78rem; color: #9ca3af; margin-top: 0.1rem; line-height: 1.4; }
        .ps-divider { border-top: 1px solid #f3f4f6; }

        .ps-actions { display: flex; gap: 0.5rem; }
        .ps-btn-access {
            flex: 1;
            display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
            padding: 0.5rem 1rem;
            background: #6366f1; color: white;
            border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
        }
        .ps-btn-access:hover { background: #4f46e5; }
        .ps-btn-doc {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0.5rem 0.75rem;
            background: #f9fafb; color: #374151;
            border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: 500;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            transition: background 0.2s;
        }
        .ps-btn-doc:hover { background: #f3f4f6; }
        .ps-empty {
            grid-column: 1 / -1;
            text-align: center; padding: 3rem;
            color: #9ca3af; font-size: 0.95rem;
        }

        /* ── Dark mode ── */
        .dark .ps-title   { color: #f9fafb; }
        .dark .ps-subtitle { color: #9ca3af; }

        .dark .ps-card {
            background: #1f2937;
            border-color: #374151;
            box-shadow: 0 1px 4px rgba(0,0,0,0.3);
        }
        .dark .ps-card:hover {
            border-color: #818cf8;
            box-shadow: 0 6px 20px rgba(99,102,241,0.25);
        }

        .dark .ps-icon-wrap { background: #312e81; }
        .dark .ps-icon { color: #818cf8; }
        .dark .ps-label  { color: #f9fafb; }
        .dark .ps-divider { border-color: #374151; }

        .dark .ps-btn-access { background: #4f46e5; }
        .dark .ps-btn-access:hover { background: #4338ca; }

        .dark .ps-btn-doc {
            background: #374151;
            color: #d1d5db;
            border-color: #4b5563;
        }
        .dark .ps-btn-doc:hover { background: #4b5563; }

        .dark .ps-empty { color: #6b7280; }
    </style>

    <div class="ps-wrapper">
        <h2 class="ps-title">Modules disponibles</h2>
        <p class="ps-subtitle">Sélectionnez un module pour y accéder</p>
    </div>

    <div class="ps-grid">
        @forelse($panels as $panel)
            <div class="ps-card">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div class="ps-icon-wrap">
                        <x-dynamic-component :component="$panel['icon']" class="ps-icon" />
                    </div>
                    <div>
                        <div class="ps-label">{{ $panel['label'] }}</div>
                        @if($panel['description'])
                            <div class="ps-desc">
                                {{ \Illuminate\Support\Str::limit($panel['description'], 60) }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="ps-divider"></div>

                <div class="ps-actions">
                    <a href="{{ $panel['url'] }}" class="ps-btn-access">
                        <x-heroicon-s-arrow-right style="width:1rem;height:1rem;" />
                        Accéder
                    </a>

                    @if($panel['doc'])
                        <a href="{{ $panel['doc'] }}" target="_blank" title="Documentation" class="ps-btn-doc">
                            <x-heroicon-o-book-open style="width:1rem;height:1rem;" />
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="ps-empty">Aucun module disponible.</div>
        @endforelse
    </div>
</div>
