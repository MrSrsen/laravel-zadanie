<?php

namespace App\Console\Commands;

use App\Entities\Article;
use App\Entities\Subscriber;
use App\EntityRepositories\ArticleRepository;
use App\EntityRepositories\SubscriberRepository;
use App\Mail\NewArticles;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Webmozart\Assert\Assert;

class SendArticleEmailsCommand extends Command
{
    protected $signature = 'app:send-article-emails';

    protected $description = 'Send articles to subscribers';

    private SubscriberRepository $subscriberRepository;
    private ArticleRepository $articleRepository;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->subscriberRepository = $this->entityManager->getRepository(Subscriber::class);
        $this->articleRepository = $this->entityManager->getRepository(Article::class);
    }

    public function handle(): void
    {
        // Avoid loading all the entities here, avoid memory spikes
        $subscriberIds = $this->subscriberRepository->getAllActiveBuilder()
            ->select('s.id')
            ->getQuery()
            ->getResult();
        $this->info(\sprintf('Found [%d] subscribers for notifying.', \count($subscriberIds)));

        $articles = $this->articleRepository->findForSending();
        $this->info(\sprintf('Found [%d] articles for notifying.', \count($articles)));

        foreach ($subscriberIds as $subscriberId) {
            $subscriber = $this->subscriberRepository->find($subscriberId);
            Assert::notNull($subscriber);

            $this->info(\sprintf('Queuing for [%s <%s>].', $subscriber->getFullName(), $subscriber->getEmail()));

            Mail::to($subscriber->getEmail())
                ->queue(new NewArticles($subscriber, $articles));

            // We assume big amount of subscribers, clear EM continuously to avoid memory spikes
            $this->entityManager->clear();
        }

        $this->info('Marking articles as published.');

        $now = now();
        // Refresh entities in EM
        $articles = $this->articleRepository->findBy(['id' => array_map(fn (Article $article) => $article->getId(), $articles)]);
        foreach ($articles as $article) {
            $article->setPublishedAt($now->toDateTimeImmutable());
        }

        $this->entityManager->flush();

        $this->info('Done.');
    }
}
