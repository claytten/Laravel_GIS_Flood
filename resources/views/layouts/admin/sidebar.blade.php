<aside class="mdl-layout__drawer">
    <header style="background-color: transparent">
        {{config('app.name')}}
    </header>
    <div class="scroll__wrapper" id="scroll__wrapper">
        <div class="scroller" id="scroller">
            <div class="scroll__container" id="scroll__container">
                <nav class="mdl-navigation">
                    <a class="mdl-navigation__link {{ !empty($menu) ? ($menu == "dashboard" ? 'mdl-navigation__link--current' : '') : '' }}" href="{{ route('admin.dashboard')}}">
                        <i class="material-icons" role="presentation">dashboard</i>
                        Dashboard
                    </a>
                    @if(Auth::guard('employee')->user()->can('admin-list'))
                    <div class="sub-navigation {{ !empty($menu) ? ($menu == "accounts" ? 'sub-navigation--show' : '') : '' }}">
                        <a class="mdl-navigation__link {{ !empty($menu) ? ($menu == "accounts" ? 'mdl-navigation__link--current' : '') : '' }} ">
                            <i class="material-icons">supervisor_account</i>
                            Account
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>
                        
                        <div class="mdl-navigation">
                            @if(Auth::guard('employee')->user()->can('admin-list'))
                            <a class="mdl-navigation__link {{ !empty($submenu) ? ($submenu == 'admins' ? 'mdl-navigation__link--current' : '') : '' }}" 
                            href="{{route('admin.admin.index')}}">
                                Admin
                            </a>
                            @endif

                            @if(Auth::guard('employee')->user()->can('roles-list'))
                            <a class="mdl-navigation__link {{ !empty($submenu) ? ($submenu == 'roles' ? 'mdl-navigation__link--current' : '') : '' }}"
                                href="{{ route('admin.role.index')}}">
                                Role
                            </a>
                            @endif

                            @if(Auth::guard('employee')->user()->can('customer-list'))
                            <a class="mdl-navigation__link" {{ !empty($submenu) ? ($submenu == 'customers' ? 'mdl-navigation__link--current' : '') : '' }}
                                href="ui-form-components.html">
                                Customer
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if(Auth::guard('employee')->user()->can('maps-list'))
                    <a class="mdl-navigation__link {{ !empty($menu) ? ($menu == "maps" ? 'mdl-navigation__link--current' : '') : '' }}" href="{{ route('admin.dashboard')}}">
                        <i class="material-icons" role="presentation">map</i>
                        maps
                    </a>
                    @endif
                    
                    <div class="mdl-layout-spacer"></div>
                    <hr>
                    <div class="mdl-navigation__link">
                        <i class="material-icons" role="presentation">favorite_border</i>
                        me
                    </div>
                </nav>
            </div>
        </div>
        <div class='scroller__bar' id="scroller__bar"></div>
    </div>
</aside>