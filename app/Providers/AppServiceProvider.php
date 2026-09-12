<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // L'application utilise Bootstrap 5 (et non Tailwind) : on aligne
        // le rendu de la pagination (ex. bouton "Suivant" sur la liste des
        // projets) sur le même framework CSS pour un affichage correct.
        Paginator::useBootstrapFive();
    }
}
