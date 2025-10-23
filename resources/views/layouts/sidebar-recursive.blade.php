@props(['menu'])

@php
    $hasChildren = $menu->children->isNotEmpty();
    $isActive = request()->routeIs($menu->route);
    $isChildActive = $hasChildren ? $menu->children->contains(function ($child) {
        return request()->routeIs($child->route);
    }) : false;
    $isOpen = $isActive || $isChildActive;
@endphp

<li class="menu-item {{ $isActive ? 'active' : '' }} {{ $isOpen ? 'open' : '' }}">
    <a href="{{ $hasChildren ? 'javascript:void(0);' : (Route::has($menu->route) ? route($menu->route) : '#') }}" 
       class="menu-link {{ $hasChildren ? 'menu-toggle' : '' }}">
        <i class="menu-icon tf-icons {{ $menu->icon ?? 'ri-folder-line' }}"></i>
        <div data-i18n="{{ $menu->name }}">{{ $menu->name }}</div>
        @if($menu->badge ?? false)
            <div class="badge bg-danger rounded-pill ms-auto">{{ $menu->badge }}</div>
        @endif
    </a>

    @if ($hasChildren)
        <ul class="menu-sub">
            @foreach ($menu->children as $child)
                <x-menu-item :menu="$child" />
            @endforeach
        </ul>
    @endif
</li>