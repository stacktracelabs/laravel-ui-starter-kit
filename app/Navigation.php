<?php

namespace App;

use Illuminate\Http\Request;
use StackTrace\Ui\Icon;
use StackTrace\Ui\Link;
use StackTrace\Ui\Menu\Menu;
use StackTrace\Ui\Menu\MenuItem;
use StackTrace\Ui\ViewModel;

class Navigation extends ViewModel
{
    public function __construct(
        private readonly Request $request,
    ) {}

    /**
     * @return array<string, Menu>
     */
    public function toView(): array
    {
        return [
            'sidebar' => Menu::make()
                ->add(
                    MenuItem::make(id: 'platform', title: 'Platform')
                        ->addChild($this->dashboardMenuItem()),
                ),
            'top' => Menu::make()
                ->add($this->dashboardMenuItem()),
            'headerRight' => Menu::make()
                ->add(MenuItem::make(
                    id: 'repository',
                    title: 'Repository',
                    action: Link::to('https://github.com/laravel/vue-starter-kit', isExternal: true),
                    icon: new Icon('folder'),
                ))
                ->add(MenuItem::make(
                    id: 'documentation',
                    title: 'Documentation',
                    action: Link::to('https://laravel.com/docs/starter-kits#vue', isExternal: true),
                    icon: new Icon('book-open'),
                )),
            'footer' => Menu::make()
                ->add(MenuItem::make(
                    id: 'repository',
                    title: 'Repository',
                    action: Link::to('https://github.com/laravel/vue-starter-kit', isExternal: true),
                    icon: new Icon('folder-git-2'),
                ))
                ->add(MenuItem::make(
                    id: 'documentation',
                    title: 'Documentation',
                    action: Link::to('https://laravel.com/docs/starter-kits#vue', isExternal: true),
                    icon: new Icon('book-open'),
                )),
            'settings' => $this->settingsNavigation(),
            'user' => Menu::make()
                ->add(MenuItem::make(
                    id: 'settings',
                    title: 'Settings',
                    action: Link::to(route('profile.edit', absolute: false)),
                    icon: new Icon('settings'),
                )),
            'breadcrumbs' => $this->breadcrumbsNavigation(),
        ];
    }

    public static function forRequest(Request $request): static
    {
        return new static($request);
    }

    private function dashboardMenuItem(): MenuItem
    {
        return MenuItem::make(
            id: 'dashboard',
            title: 'Dashboard',
            action: Link::to(route('dashboard', absolute: false)),
            icon: new Icon('layout-grid'),
        );
    }

    private function settingsNavigation(): Menu
    {
        return Menu::make()
            ->add(MenuItem::make(
                id: 'profile',
                title: 'Profile',
                action: Link::to(route('profile.edit', absolute: false)),
            ))
            ->add(MenuItem::make(
                id: 'security',
                title: 'Security',
                action: Link::to(route('security.edit', absolute: false)),
            ))
            ->add(MenuItem::make(
                id: 'appearance',
                title: 'Appearance',
                action: Link::to(route('appearance.edit', absolute: false)),
            ));
    }

    private function breadcrumbsNavigation(): Menu
    {
        return match ($this->request->route()?->getName()) {
            'dashboard' => Menu::make()
                ->add(MenuItem::make(id: 'dashboard', title: 'Dashboard')),
            'profile.edit', 'profile.update', 'profile.destroy' => Menu::make()
                ->add(MenuItem::make(id: 'profile-settings', title: 'Profile settings')),
            'security.edit', 'user-password.update' => Menu::make()
                ->add(MenuItem::make(id: 'security-settings', title: 'Security settings')),
            'appearance.edit' => Menu::make()
                ->add(MenuItem::make(id: 'appearance-settings', title: 'Appearance settings')),
            default => Menu::make(),
        };
    }
}
