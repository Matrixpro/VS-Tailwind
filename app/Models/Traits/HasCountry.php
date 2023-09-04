<?php

namespace App\Models\Traits;

use App\Models\Country;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCountry
{
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    protected function countryCode(): Attribute
    {
        return Attribute::make(
            get: fn(): ?string => $this->country?->code,
        );
    }
}
