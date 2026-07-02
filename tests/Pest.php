<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind different classes or traits.
|
*/

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

function skipUnlessFortifyHas(string $feature, ?string $message = null): void
{
    if (! Features::enabled($feature)) {
        Assert::markTestSkipped($message ?? "Fortify feature [{$feature}] is not enabled.");
    }
}
