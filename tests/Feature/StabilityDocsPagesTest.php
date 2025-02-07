<?php

declare(strict_types=1);

use MoonShine\MoonShine;
use MoonShine\Pages\Page;
use Torchlight\Middleware\RenderTorchlight;

foreach (config('moonshine.locales') as $locale) {
    describe('Stability ' . str($locale)->upper() . ' docs', fn() => stabilityLocale($locale));
}

function stabilityLocale(string $locale): void {
    collect(MoonShine::getPages())
        ->map(fn(Page $page) => $page->url())
        ->each(fn (string $url) => stabilityDocPage($url, $locale));
}

function stabilityDocPage(string $url, string $locale): void {
    test($url)->withSession(['change-moonshine-locale' => $locale])
        ->withoutMiddleware(RenderTorchlight::class)
        ->get($url)
        ->assertOk();
}

