<?php
/** @var \App\Entities\Subscriber $subscriber */
/** @var array<\App\Entities\Article> $articles */
?>
@extends('template')
<h1>Hello, {{ $subscriber->getFullName() }}</h1>

<p>This is list of your new articles:</p>

<main>
    @foreach($articles as $article)
        <article>
            <h2>{{ $article->getTitle() }}</h2>
            @if(!empty($article->getSubtitle()))
                <h3>{{$article->getSubtitle()}}</h3>
            @endif
            <hr>
            <p>Author: {{$article->getBlogger()->getTitle()}}</p>
            <p>Category: {{$article->getCategory()->getTitle()}}</p>
            <hr>
            @if(!empty($article->getSummary()))
                <p>{{$article->getSummary()}}</p>
            @endif

            {!! $article->getContent() !!}
        </article>
    @endforeach
</main>
