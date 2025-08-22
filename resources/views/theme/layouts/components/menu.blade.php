
@php
    $menu = Menu::where('is_active', 1)->first();
@endphp


<ul class="menu-container">
    @foreach ($menu->parent_navigation() as $item)
        @include('theme.layouts.components.menu-item', ['item' => $item])
    @endforeach

    <li class="menu-item">
        <a class="menu-link" href="{{ route('product.front.list') }}"><div>Physical Books</div></a>
    </li>
    <li class="menu-item">
        <a class="menu-link" href="{{ route('product.front.ebook-list') }}"><div>E-Books</div></a>
    </li>
    {{-- <li class="menu-item" @if(!auth()->user()) hidden @endif>
        <a class="menu-link" href="{{ route('customer.subscription') }}"><div>Subscriptions</div></a>
    </li> --}}
</ul>
