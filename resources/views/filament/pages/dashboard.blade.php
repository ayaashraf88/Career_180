<x-filament-panels::page>
    @if (method_exists($this, 'getHeaderWidgets'))
        <x-filament-widgets::widgets
            :columns="1"
            :widgets="$this->getHeaderWidgets()"
            class="fi-dashboard-header-widgets gap-6"
        />
    @endif

    <x-filament-widgets::widgets
        :columns="2"
        :widgets="$this->getWidgets()"
        class="fi-dashboard-widgets gap-6"
    />

    @if (method_exists($this, 'getFooterWidgets'))
        <x-filament-widgets::widgets
            :columns="1"
            :widgets="$this->getFooterWidgets()"
            class="fi-dashboard-footer-widgets gap-6"
        />
    @endif
</x-filament-panels::page>