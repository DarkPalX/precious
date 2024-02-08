@php $page = $item->page; @endphp
@if (!empty($page) && $item->is_page_type() && $page->is_published())
    <li class="menu-item @if(url()->current() == $page->get_url() || ($page->id == 1 && url()->current() == env('APP_URL'))) current @endif">
        <a class="menu-link" href="{{$page->get_url()}}">
            <div>
                @if (!empty($page->label))
                    {{ $page->label }} 
                @else
                    {{ $page->name }} 
                @endif
            </div>
        </a>
        
        @if ($item->has_sub_menus())
            <ul>
                @foreach ($item->sub_pages as $subItem)
                    @include('theme.layouts.menu-item', ['item' => $subItem])
                @endforeach
            </ul>
        @endif
    </li>

@elseif ($item->is_external_type())
    <li class="menu-item">
        <a class="menu-link" href="{{ $item->uri }}" target="{{ $item->target }}"><div>{{ $item->label }}</div></a>
        @if ($item->has_sub_menus())
            <ul>
                @foreach ($item->sub_pages as $subItem)
                    @include('theme.layouts.menu-item', ['item' => $subItem])
                @endforeach
            </ul>
        @endif
    </li>
@endif