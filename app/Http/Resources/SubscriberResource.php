<?php

namespace App\Http\Resources;

use App\Entities\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var Subscriber $subscriber */
        $subscriber = $this->resource;

        return [
            'id' => $subscriber->getId(),
            'fullName' => $subscriber->getFullName(),
            'firstName' => $subscriber->getFirstName(),
            'lastName' => $subscriber->getLastName(),
            'email' => $subscriber->getEmail(),
            'createdAt' => $subscriber->getCreatedAt()->format('c'),
            'updatedAt' => $subscriber->getUpdatedAt()?->format('c'),
        ];
    }
}
