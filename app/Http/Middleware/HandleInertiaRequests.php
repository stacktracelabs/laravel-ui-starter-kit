<?php

namespace App\Http\Middleware;

use App\ViewModels\Navigation;
use App\ViewModels\UserViewModel;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user() ? new UserViewModel($request->user()) : null,
            ],
            'navigation' => new Navigation,
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'ziggy' => [
                ...new Ziggy()->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
