<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Article;
use App\Models\Advertisement;
use App\Observers\ArticleObserver;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();
        // Forcer la locale pour les dates
        App::setLocale(config('app.locale'));
        Carbon::setLocale(config('app.locale'));

        // Enregistrer l'observer pour le modèle Article
        Article::observe(ArticleObserver::class);

        // Partager la bannière publicitaire haute avec le layout app
        View::composer('layouts.app', function ($view) {
            try {
                $bannerTop = Advertisement::active()
                    ->forPosition('home', null, 'top_banner')
                    ->first();

                $view->with('bannerTop', $bannerTop);
            } catch (\Exception $e) {
                // En cas d'erreur, ne pas afficher de publicité
                $view->with('bannerTop', null);
            }
        });
    }
}
