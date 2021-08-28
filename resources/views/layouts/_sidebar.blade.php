<div class="scroll-sidebar">
    
    <nav class="sidebar-nav">
        <ul id="sidebarnav">
            @foreach ($menus['menu_utama'] as $parent_menu)
                @if (!empty($parent_menu[0]))
                    @if ($parent_menu[0]->menu_id == 1)
                        <li> 
                            <a class="waves-effect waves-dark" href="{{route($parent_menu[0]->slug)}}"><i class="{{$parent_menu[0]->icon}}"></i><span class="hide-menu">{{$parent_menu[0]->nama_menu}}</span></a>
                        </li>
                    @else
                        <li> 
                            <a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false"><i class="{{$parent_menu[0]->icon}}"></i><span class="hide-menu">{{$parent_menu[0]->nama_menu}}</span></a>
                            <ul aria-expanded="false" class="collapse">
                                @foreach ($menus['sub_menus'] as $sub_menu)
                                    @if (!empty($sub_menu[0]))
                                        @if ($sub_menu[0]->parent_menu_id == $parent_menu[0]->menu_id)
                                            <li><a href="{{route($sub_menu[0]->slug)}}">{{$sub_menu[0]->nama_menu}}</a></li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endforeach
        </ul>
    </nav>
</div>