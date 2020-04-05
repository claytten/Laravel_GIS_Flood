<?php

namespace App\Providers;

use App\FooterDescription;
use App\Menu;
use App\Reachus;
use App\SocialmediaAccount;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Navbar and Topbar
        View::composer('layouts.partials.public.navbar', function ($view) {
            $menu = new Menu;
            $topbar_menus = $menu->getTopbarFrontHTML();
            $navbar_menus = $menu->getNavbarFrontHTML();

            $view->with([
                'topbar_menus' => $topbar_menus,
                'navbar_menus' => $navbar_menus
            ]);
        });

        // Footer
        View::composer('layouts.partials.public.footer', function ($view) {
            $view
                ->with('footerDesc', FooterDescription::firstOrFail())
                ->with('socialmediaAccounts', SocialmediaAccount::all())
                ->with('reachUs', Reachus::firstOrFail());
        });
    }
}
