<?php

namespace App\Listeners;

use App\Events\ArticleStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticleSubmitted;
use App\Mail\ArticlePublished;
use App\Mail\ArticleRejected;
use App\Models\User;

class SendArticleNotification
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ArticleStatusChanged $event): void
    {
        $article = $event->article;
        $oldStatus = $event->oldStatus;
        $newStatus = $event->newStatus;
        $reason = $event->reason;

        // Récupérer l'auteur de l'article
        $author = User::find($article->user_id);
        
        if (!$author) {
            return;
        }

        // Déterminer quel type de notification envoyer
        if ($oldStatus === 'draft' && $newStatus === 'pending') {
            // Article soumis : notifier les admins et directeurs
            $this->sendSubmissionNotification($article, $author);
            
        } elseif ($oldStatus === 'pending' && $newStatus === 'published') {
            // Article publié : notifier l'auteur
            $this->sendPublishedNotification($article, $author);
            
        } elseif ($oldStatus === 'pending' && in_array($newStatus, ['draft', 'archived'])) {
            // Article rejeté : notifier l'auteur
            $this->sendRejectedNotification($article, $author, $reason);
        }
    }

    /**
     * Envoyer notification de soumission aux admins/directeurs
     */
    private function sendSubmissionNotification($article, $author)
    {
        $recipients = $this->getAdminEmails();
        
        if (!empty($recipients)) {
            Mail::to($recipients)->send(new ArticleSubmitted($article, $author));
        }
    }

    /**
     * Envoyer notification de publication à l'auteur
     */
    private function sendPublishedNotification($article, $author)
    {
        Mail::to($author->email)->send(new ArticlePublished($article, $author));
    }

    /**
     * Envoyer notification de rejet à l'auteur
     */
    private function sendRejectedNotification($article, $author, $reason = null)
    {
        Mail::to($author->email)->send(new ArticleRejected($article, $author, $reason));
    }

    /**
     * Récupérer les emails des administrateurs et directeurs
     */
    private function getAdminEmails(): array
    {
        $emails = [];
        
        // Emails depuis les variables d'environnement
        $adminEmails = env('ADMIN_EMAILS', '');
        $directorEmails = env('DIRECTOR_EMAILS', '');
        
        if (!empty($adminEmails)) {
            $emails = array_merge($emails, explode(',', $adminEmails));
        }
        
        if (!empty($directorEmails)) {
            $emails = array_merge($emails, explode(',', $directorEmails));
        }
        
        // Nettoyer les emails (supprimer espaces, quotes)
        return array_filter(array_map('trim', array_map(function($email) {
            return trim($email, '"\'');
        }, $emails)));
    }
}
