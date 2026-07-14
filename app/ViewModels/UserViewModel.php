<?php

namespace App\ViewModels;

use App\Models\User;
use Inertia\PropertyContext;
use Inertia\ProvidesInertiaProperty;

class UserViewModel implements ProvidesInertiaProperty
{
    public function __construct(
        protected readonly User $user,
    ) {}

    /**
     * Serialize the authenticated user for Inertia.
     *
     * @return array<string, int|string|null>
     */
    public function toInertiaProperty(PropertyContext $property): array
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'emailVerifiedAt' => $this->user->email_verified_at?->toISOString(),
            'createdAt' => $this->user->created_at?->toISOString(),
            'updatedAt' => $this->user->updated_at?->toISOString(),
        ];
    }
}
