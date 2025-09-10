<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class NotificationHelper
{
    /**
     * Récupérer la liste des emails d'administrateurs
     */
    public static function getAdminEmails(): array
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

    /**
     * Tester l'envoi d'email avec le système actuel
     */
    public static function testEmailSystem(): array
    {
        $results = [];
        
        // 1. Vérifier la configuration mail
        $mailer = config('mail.default');
        $results['mail_driver'] = $mailer;
        
        // 2. Vérifier les emails d'admins
        $adminEmails = self::getAdminEmails();
        $results['admin_emails'] = $adminEmails;
        $results['admin_emails_count'] = count($adminEmails);
        
        // 3. Vérifier la queue
        $queueConnection = config('queue.default');
        $results['queue_connection'] = $queueConnection;
        
        // 4. Vérifier les templates
        $templates = [
            'article-submitted' => view()->exists('emails.article-submitted'),
            'article-published' => view()->exists('emails.article-published'),
            'article-rejected' => view()->exists('emails.article-rejected'),
        ];
        $results['templates'] = $templates;
        
        return $results;
    }

    /**
     * Envoyer un email de test
     */
    public static function sendTestEmail($to, $subject = 'Test Excellence Afrik', $message = 'Ceci est un email de test.')
    {
        try {
            Mail::raw($message, function ($mail) use ($to, $subject) {
                $mail->to($to)
                     ->subject($subject)
                     ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            Log::info('Test email sent successfully', ['to' => $to, 'subject' => $subject]);
            return ['success' => true, 'message' => 'Email envoyé avec succès'];
        } catch (\Exception $e) {
            Log::error('Failed to send test email', ['error' => $e->getMessage(), 'to' => $to]);
            return ['success' => false, 'message' => 'Erreur : ' . $e->getMessage()];
        }
    }

    /**
     * Logger les informations de notification pour debug
     */
    public static function logNotification($type, $article, $user, $additionalData = [])
    {
        Log::info("Notification {$type}", array_merge([
            'article_id' => $article->id,
            'article_title' => $article->title,
            'article_status' => $article->status,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'timestamp' => now()->toISOString(),
        ], $additionalData));
    }
}