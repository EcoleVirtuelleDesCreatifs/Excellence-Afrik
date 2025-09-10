<?php

namespace App\Observers;

use App\Models\Article;
use App\Events\ArticleStatusChanged;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     * Déclencher notification si l'article est créé directement en statut "pending"
     */
    public function created(Article $article): void
    {
        // Si l'article est créé directement en statut "pending", envoyer notification
        if ($article->status === 'pending') {
            event(new ArticleStatusChanged($article, 'draft', 'pending'));
        }
    }

    /**
     * Store the old status before update
     */
    private static $oldStatuses = [];

    /**
     * Handle the Article "updating" event.
     * This is called before the model is updated, so we can compare old and new status
     */
    public function updating(Article $article): void
    {
        // Vérifier si le statut a changé
        if ($article->isDirty('status')) {
            $oldStatus = $article->getOriginal('status');
            $newStatus = $article->status;
            
            // Ne pas déclencher pour les créations (old status null)
            if ($oldStatus && $oldStatus !== $newStatus) {
                // Stocker l'ancien statut dans un tableau statique (pas en base)
                self::$oldStatuses[$article->id] = $oldStatus;
            }
        }
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        // Vérifier si nous avons stocké un ancien statut
        if (isset(self::$oldStatuses[$article->id])) {
            $oldStatus = self::$oldStatuses[$article->id];
            $newStatus = $article->status;
            
            // Déclencher l'event de changement de statut
            event(new ArticleStatusChanged($article, $oldStatus, $newStatus));
            
            // Nettoyer le tableau
            unset(self::$oldStatuses[$article->id]);
        }
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        //
    }
}
