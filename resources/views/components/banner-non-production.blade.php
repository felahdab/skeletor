@props(['style', 'fixed', 'position'])

@php
$fixed = $fixed ?? true;
$position = $position ?? "top";
$borderPosition = $position === 'top' ? 'bottom' : 'top';

$style = $style ?? 'light';
$styles =  [
            'light' => [
                'text' => '#1f2937',
                'background' => '#f38484',
                'border' => '#e8eaec',
            ],
            'dark' => [
                'text' => '#f3f4f6',
                'background' => '#1f2937',
                'border' => '#374151',
            ],
];
$default = $style === 'auto' ? 'light' : $style;
$flipped = $default === 'dark' ? 'light' : 'dark';
@endphp

<style>
    :root {
        --non-production-banner-height: 50px;

        --non-production-light-bg-color: {{ $styles['light']['background'] }};
        --non-production-light-text-color: {{ $styles['light']['text'] }};
        --non-production-light-border-color: {{ $styles['light']['border'] }};
        --non-production-light-button-bg-color: {{ implode(',', sscanf($styles['dark']['background'], "#%02x%02x%02x")) }};
        --non-production-light-button-text-color: {{ $styles['dark']['text'] }};

        --non-production-dark-bg-color: {{ $styles['dark']['background'] }};
        --non-production-dark-text-color: {{ $styles['dark']['text'] }};
        --non-production-dark-border-color: {{ $styles['dark']['border'] }};
        --non-production-dark-button-bg-color: {{ implode(',', sscanf($styles['light']['background'], "#%02x%02x%02x")) }};
        --non-production-dark-button-text-color: {{ $styles['light']['text'] }};
    }
    html {
        margin-{{ $position }}: var(--non-production-banner-height);
    }


    #non-production-banner {
        position: {{ $fixed ? 'fixed' : 'absolute' }};
        height: var(--non-production-banner-height);
        {{ $position }}: 0;
        width: 100%;
        display: flex;
        column-gap: 20px;
        justify-content: center;
        align-items: center;
        background-color: var(--non-production-{{ $default }}-bg-color);
        color: var(--non-production-{{ $default }}-text-color);
        border-{{ $borderPosition }}: 1px solid var(--non-production-{{ $default }}-border-color);
        z-index: 45;
    }

    @if($style === 'auto')
    .dark #non-production-banner {
        background-color: var(--non-production-dark-bg-color);
        color: var(--non-production-dark-text-color);
        border-{{ $borderPosition }}: 1px solid var(--non-production-dark-border-color);
    }
    @endif

    #non-production-banner a {
        display: block;
        padding: 4px 20px;
        border-radius: 5px;
        background-color: rgba(var(--non-production-{{ $default }}-button-bg-color), 0.7);
        color: var(--non-production-{{ $default }}-button-text-color);
    }

    @if($style === 'auto')
    .dark #non-production-banner a {
        background-color: rgba(var(--non-production-dark-button-bg-color), 0.7);
        color: var(--non-production-dark-button-text-color);
    }
    @endif

    #non-production-banner a:hover {
        background-color: rgb(var(--non-production-{{ $default }}-button-bg-color));
    }

    @if($style === 'auto')
    .dark #non-production-banner a:hover {
        background-color: rgb(var(--non-production-dark-button-bg-color));
    }
    @endif

    @if($fixed)
    div.fi-layout > aside.fi-sidebar {
        height: calc(100vh - var(--non-production-banner-height));
    }

    @if($position === 'top')
    .fi-topbar {
        top: var(--non-production-banner-height);
    }
    div.fi-layout > aside.fi-sidebar {
        top: var(--non-production-banner-height);
    }
    @endif

    @else
    div.fi-layout > aside.fi-sidebar {
        padding-bottom: var(--non-production-banner-height);
    }
    @endif

    @media print{
        aside, body {
            margin-top: 0;
        }

        #non-production-banner {
            display: none;
        }
    }
</style>

<div id="non-production-banner">
    <div>
        <strong>Cette application n'est pas en production. Les données peuvent être altérées sans préavis !</strong>
    </div>

    @if(app('impersonate')->isImpersonating())
        @php
        $display = $display ?? Filament\Facades\Filament::getUserName(Filament\Facades\Filament::auth()->user());
        @endphp
        <div>
            {{ __('filament-impersonate::banner.impersonating') }} <strong>{{ $display }}</strong>
        </div>
        <a href="{{ route('filament-impersonate.leave') }}">{{ __('filament-impersonate::banner.leave') }}</a>
    @endif
</div>
