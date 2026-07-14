<?php

namespace App\ViewModels;

use Inertia\PropertyContext;
use Inertia\ProvidesInertiaProperty;
use Laravel\Passkeys\Passkey;

class PasskeyViewModel implements ProvidesInertiaProperty
{
    public function __construct(
        protected readonly Passkey $passkey,
    ) {}

    /**
     * Serialize a passkey for account settings.
     *
     * @return array<string, int|string|null>
     */
    public function toInertiaProperty(PropertyContext $property): array
    {
        return [
            'id' => $this->passkey->id,
            'name' => $this->passkey->name,
            'authenticator' => $this->passkey->authenticator,
            'createdAtDiff' => $this->passkey->created_at?->diffForHumans(),
            'lastUsedAtDiff' => $this->passkey->last_used_at?->diffForHumans(),
        ];
    }
}
