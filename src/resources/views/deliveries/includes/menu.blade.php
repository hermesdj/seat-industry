<ul class="nav nav-tabs">
    @foreach($menu as $menuEntry)
        @can($menuEntry['permission'])
            <li role="presentation" class="nav-item">
                <a
                        href="{{route($menuEntry['route'], $delivery)}}"
                        class="nav-link @if($viewname == $menuEntry['highlight_view']) active @endif"
                >
                    @if(array_key_exists('label', $menuEntry))
                        @if(array_key_exists('plural', $menuEntry))
                            {{trans_choice($menu_entry['label'], 2)}}
                        @else
                            {{trans($menuEntry['label'])}}
                        @endif
                    @else
                        {{$menuEntry['name']}}
                    @endif
                </a>
            </li>
        @endcan
    @endforeach
</ul>