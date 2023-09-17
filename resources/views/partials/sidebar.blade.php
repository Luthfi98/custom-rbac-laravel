<!--**********************************
    Sidebar start
***********************************-->
@php
    $general = new GeneralHelper;
@endphp
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            @foreach ($general->getMenu() as $menu)
                @if ($menu->is_label)
                    <li class="menu-title">{{ strtoupper($menu->name) }}</li>
                    @foreach ($menu->child as $child)
                        @if ($child->path == '#')
                            <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                                <div class="menu-icon">
                                    <span class="{{ $child->icon }}"></span>
                                </div>
                                <span class="nav-text">{{ $child->name }}</span>
                                </a>
                                <ul aria-expanded="false">
                                    @foreach ($child->child as $subchild)
                                        <li><a href="{{ $subchild->path == '#' ? '#' : route($subchild->path) }}">{{ $subchild->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li><a href="{{ $child->path == '#' ? '#' : route($child->path) }}" class="" aria-expanded="false">
                                <div class="menu-icon">
                                    <span class="{{ $child->icon }}"></span>
                                </div>
                                    <span class="nav-text">{{ $child->name }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @else
                    @if ($menu->path == '#')
                        <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                            <div class="menu-icon">
                                <span class="{{ $menu->icon }}"></span>
                            </div>
                            <span class="nav-text">{{ $menu->name }}</span>
                            </a>
                            <ul aria-expanded="false">
                                @foreach ($menu->child as $child)
                                    <li><a href="{{ $child->path }}">{{ $child->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ $menu->path == '#' ? '#' : route($menu->path) }}" class="" aria-expanded="false">
                            <div class="menu-icon">
                                <span class="{{ $menu->icon }}"></span>
                            </div>
                                <span class="nav-text">{{ $menu->name }}</span>
                            </a>
                        </li>
                    @endif
                @endif
                    <hr style="margin:0.5rem 0">
            @endforeach
        </ul>
    </div>
</div>

<!--**********************************
    Sidebar end
***********************************-->
