<?php

namespace App\Http\Controllers;

use App\Entities\Subscriber;
use App\EntityRepositories\SubscriberRepository;
use App\Http\Resources\SubscriberResource;
use App\Utils\DoctrinePaginator;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class SubscriberController
{
    private SubscriberRepository $subscriberRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->subscriberRepository = $this->entityManager->getRepository(Subscriber::class);
    }

    public function show(Request $request, string $subscriber): JsonResponse
    {
        $subscriber = $this->subscriberRepository->find($subscriber)
            ?? throw new NotFoundHttpException('Subscriber not found.');

        return new JsonResponse(SubscriberResource::make($subscriber)->toArray($request));
    }

    public function list(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $page = max(1, $page);

        $items = $request->query->getInt('items', 50);
        $items = max(100, min($items, 3));

        $firstName = $request->query->getString('firstName');
        $lastName = $request->query->getString('lastName');
        $email = $request->query->getString('email');

        $query = $this->subscriberRepository->getAllActiveBuilder(
            firstName: $firstName,
            lastName: $lastName,
            email: $email,
        );

        return new JsonResponse(
            (new DoctrinePaginator($query->getQuery()))
                ->paginate($page, $items)
                ->map(fn (Subscriber $subscriber) => SubscriberResource::make($subscriber)->toArray($request))
                ->toArray()
        );
    }
}
