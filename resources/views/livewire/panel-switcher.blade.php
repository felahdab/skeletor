@php
    $canSwitchPanels = true;
    $currentPanel = filament()->getCurrentPanel();
    $panels = filament()->getPanels();

    $getUrlScheme = (string) app()->environment('production') ? 'https://' : 'http://';

    $getPanelPath = fn (\Filament\Panel $panel): string => filled($domains = $panel->getDomains())
            ? str(collect($domains)->first())->prepend($getUrlScheme)->toString()
            : str($panel->getPath())->prepend('/')->toString();

    $getHref = fn (\Filament\Panel $panel): ?string => $canSwitchPanels && $panel->getId() !== $currentPanel->getId()
            ? $getPanelPath($panel)
            : null;

    $modalWidth = 'screen';
    $isSlideOver = false;
    $heading = 'heading';
    $renderIconAsImage = false;
    $iconSize = 16 ;

@endphp

<div class="flex flex-wrap items-center justify-center gap-4 md:gap-6">
    @foreach ($panels as $panel)
        <a
            href="{{ $getHref($panel) }}"
            class="flex flex-col items-center justify-center flex-1 hover:cursor-pointer group panel-switch-card"
        >
            <div
                @class([
                    "p-2 bg-white rounded-lg shadow-md dark:bg-gray-800 panel-switch-card-section",
                    "group-hover:ring-2 group-hover:ring-primary-600" => $panel->getId() !== $currentPanel->getId(),
                    "ring-2 ring-primary-600" => $panel->getId() === $currentPanel->getId(),
                ])
            >
                @if ($renderIconAsImage)
                    <img
                        class="rounded-lg panel-switch-card-image"
                        style="width: {{ $iconSize * 4 }}px; height: {{ $iconSize * 4 }}px;"
                        src="{{ $icons[$panel->getId()] ?? 'https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/3.x/art/banner.jpg' }}"
                        alt="Panel Image"
                    >
                @else
                    @php
                        $iconName = $icons[$panel->getId()] ?? 'heroicon-s-square-2-stack' ;
                    @endphp
                    @svg($iconName, 'text-primary-600 panel-switch-card-icon', ['style' => 'width: ' . ($iconSize * 4) . 'px; height: ' . ($iconSize * 4). 'px;'])
                @endif
            </div>
            <span
                @class([
                    "mt-2 text-sm font-medium text-center text-gray-400 dark:text-gray-200 break-words panel-switch-card-title",
                    "text-gray-400 dark:text-gray-200 group-hover:text-primary-600 group-hover:dark:text-primary-400" => $panel->getId() !== $currentPanel->getId(),
                    "text-primary-600 dark:text-primary-400" => $panel->getId() === $currentPanel->getId(),
                ])
            >
                {{ $labels[$panel->getId()] ?? str($panel->getId())->ucfirst()}}
            </span>
        </a>
    @endforeach
</div>
