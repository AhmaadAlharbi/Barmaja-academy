<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');
        // Build your locale data
        $localeData = [
            'current' => LaravelLocalization::getCurrentLocale(),
            'supported' => collect(LaravelLocalization::getSupportedLocales())
                ->map(fn($props, $code) => [
                    'code'   => $code,
                    'native' => $props['native'],
                    'url'    => LaravelLocalization::getLocalizedURL($code, null, [], true),
                ])
                ->values()
                ->toArray()
        ];

        // Build localized navigation URLs
        $navigation = [
            'home' => LaravelLocalization::localizeURL('/'),
            'courses' => LaravelLocalization::localizeURL('/courses/list'),
            'blog' => LaravelLocalization::localizeURL('/blogs/list'),
            'contact' => LaravelLocalization::localizeURL('/contact-us'),
            'login' => LaravelLocalization::localizeURL('/login'),
            'register' => LaravelLocalization::localizeURL('/register'),
            'dashboard' => LaravelLocalization::localizeURL('/dashboard'),
            'profile' => LaravelLocalization::localizeURL('/profile'),
        ];

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            // Updated structure to match Vue component expectations
            'locale' => $localeData,
            // Add navigation URLs globally
            'navigation' => $navigation,
        ];
    }
}