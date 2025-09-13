<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;
use App\Models\User;

class ArticleRejected extends Mailable
{
    use Queueable, SerializesModels;

    public Article $article;
    public User $author;
    public ?string $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(Article $article, User $author, ?string $reason = null)
    {
        $this->article = $article;
        $this->author = $author;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📋 Article nécessite des révisions - ' . $this->article->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.article-rejected',
            with: [
                'article' => $this->article,
                'author' => $this->author,
                'reason' => $this->reason,
                'dashboardUrl' => route('dashboard.articles.edit', $this->article->id),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
