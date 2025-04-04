<?php

namespace App\Factory;

use App\Entities\Subscriber;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;

class ArticleEmailFactory
{
    public function create(Subscriber $subscriber, array $articles): Envelope
    {
        $content = view('articles', [
            'subscriber' => $subscriber,
            'articles' => $articles,
        ])->render();

        return new Envelope(
            from: new Address('jeffrey@example.com', 'Jeffrey Way'),
            subject: 'New articles',
        );
    }
}
