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

class ArticlePublished extends Mailable
{
    use Queueable, SerializesModels;

    public Article $article;
    public User $author;

    /**
     * Create a new message instance.
     */
    public function __construct(Article $article, User $author)
    {
        $this->article = $article;
        $this->author = $author;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Félicitations ! Votre article a été publié - ' . $this->article->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.article-published',
            with: [
                'article' => $this->article,
                'author' => $this->author,
                'articleUrl' => route('articles.show', $this->article->slug),
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
