<x-filament-panels::page>
    {{-- Page content --}}
    <div>
        <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">
            Modules disponibles
        </h2>
    
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.25rem;">
            @foreach($panels as $panel)
                <div style="
                    border-radius: 0.75rem;
                    border: 1px solid #e5e7eb;
                    background: white;
                    padding: 1.5rem;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.07);
                    display: flex;
                    flex-direction: column;
                    gap: 0.75rem;
                ">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <x-dynamic-component :component="$panel['icon']" style="width:1.5rem; height:1.5rem; color:#6366f1;" />
                        <span style="font-weight: 600; font-size: 1rem; color: #111827;">
                            {{ $panel['label'] }}
                        </span>
                    </div>
    
                    <div style="display: flex; gap: 0.5rem; margin-top: auto;">
                        <a
                            href="{{ $panel['url'] }}"
                            style="
                                flex: 1;
                                text-align: center;
                                padding: 0.4rem 0.75rem;
                                background: #6366f1;
                                color: white;
                                border-radius: 0.5rem;
                                font-size: 0.875rem;
                                font-weight: 500;
                                text-decoration: none;
                            "
                        >
                            Accéder
                        </a>
    
                        @if($panel['doc'])
                            <a
                                href="{{ $panel['doc'] }}"
                                target="_blank"
                                style="
                                    padding: 0.4rem 0.75rem;
                                    background: #f3f4f6;
                                    color: #374151;
                                    border-radius: 0.5rem;
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    text-decoration: none;
                                "
                                title="Documentation"
                            >
                                📖
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
</x-filament-panels::page>
