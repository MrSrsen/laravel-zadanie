<?php

namespace App\Mail;

use App\Entities\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class NewArticles extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly Subscriber $subscriber,
        public readonly array $articles,
    ) {
    }

    public function content(): Content
    {
        return new Content(view: 'articles');
    }
}
