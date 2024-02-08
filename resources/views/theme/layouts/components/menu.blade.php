
@php
    $menu = Menu::where('is_active', 1)->first();
@endphp


<ul class="menu-container">
    @foreach ($menu->parent_navigation() as $item)
        @include('theme.layouts.components.menu-item', ['item' => $item])
    @endforeach

    <li class="menu-item">
        <a class="menu-link" href="{{ route('product.front.list') }}"><div>Books</div></a>
    </li>
    
</ul>
