<?php

namespace App\Helpers;

use App\Models\Advertisement;

class AdvertisementHelper
{
    /**
     * Récupère les publicités pour une page et position données
     */
    public static function getAdsForPage($pageType, $categorySlug = null, $position = 'top_banner', $limit = 1)
    {
        $query = Advertisement::active()
            ->forPosition($pageType, $categorySlug, $position);
        
        return $limit === 1 ? $query->first() : $query->take($limit)->get();
    }

    /**
     * Récupère une publicité aléatoire pour une position
     */
    public static function getRandomAdForPosition($position = 'top_banner', $currentPageType = null, $currentCategorySlug = null)
    {
        $query = Advertisement::active()
            ->where('position_in_page', $position);
            
        // Recherche d'abord les annonces générales (sans ciblage spécifique)
        $query->where(function($q) {
            $q->whereNull('category_slug')
              ->where('page_type', 'home'); // Utiliser seulement les annonces générales pour la home
        });
        
        return $query->inRandomOrder()->first();
    }

    /**
     * Détermine le type de page actuel
     */
    public static function getCurrentPageType()
    {
        $route = request()->route();
        
        if (!$route) {
            return 'home';
        }
        
        $routeName = $route->getName();
        
        if ($routeName === 'home') {
            return 'home';
        } elseif (str_starts_with($routeName, 'articles.category')) {
            return 'category';
        } elseif (str_starts_with($routeName, 'articles.show')) {
            return 'article';
        } elseif (str_starts_with($routeName, 'magazines.')) {
            return 'magazines';
        } elseif (str_starts_with($routeName, 'webtv.')) {
            return 'webtv';
        }
        
        return 'home';
    }

    /**
     * Récupère le slug de catégorie actuel si applicable
     */
    public static function getCurrentCategorySlug()
    {
        $route = request()->route();
        
        if (!$route) {
            return null;
        }
        
        // Si on est sur une page de catégorie
        if ($route->getName() === 'articles.category') {
            return $route->parameter('slug');
        }
        
        return null;
    }

    /**
     * Récupère la publicité à afficher pour le contexte actuel
     */
    public static function getCurrentAd($position = 'top_banner')
    {
        $pageType = self::getCurrentPageType();
        $categorySlug = self::getCurrentCategorySlug();
        
        // Si on est sur une page de catégorie, recherche spécifique d'abord
        if ($categorySlug) {
            $ad = self::getAdsForPage($pageType, $categorySlug, $position);
            if ($ad) {
                return $ad;
            }
        }
        
        // Recherche générale pour le type de page (UNIQUEMENT sans category_slug)
        $query = Advertisement::active()
            ->where('page_type', $pageType)
            ->where('position_in_page', $position)
            ->whereNull('category_slug') // IMPORTANT: Exclure les annonces avec category_slug
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc');
            
        $ad = $query->first();
        
        if ($ad) {
            return $ad;
        }
        
        // Si toujours pas trouvé, recherche globale (seulement annonces générales home)
        $ad = self::getRandomAdForPosition($position, $pageType, $categorySlug);
        
        return $ad;
    }
}