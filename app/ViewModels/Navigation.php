<?php

namespace App\ViewModels;

use Inertia\PropertyContext;
use Inertia\ProvidesInertiaProperty;
use StackTrace\Ui\Breadcrumbs\BreadcrumbItem;
use StackTrace\Ui\Breadcrumbs\BreadcrumbList;
use StackTrace\Ui\Link;
use StackTrace\Ui\Menu\Menu;
use StackTrace\Ui\Menu\MenuItem;

class Navigation implements ProvidesInertiaProperty
{
    /**
     * Serialize the application's navigation for Inertia.
     *
     * @return array<string, Menu|BreadcrumbList>
     */
    public function toInertiaProperty(PropertyContext $property): array
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
                    action: Link::to('https://github.com/stacktracelabs/laravel-ui-starter-kit', isExternal: true),
                ))
                ->add(MenuItem::make(
                    id: 'documentation',
                    title: 'StackTrace UI documentation',
                    action: Link::to('https://ui.stacktrace.sk', isExternal: true),
                )),
            'footer' => Menu::make()
                ->add(MenuItem::make(
                    id: 'repository',
                    title: 'Repository',
                    action: Link::to('https://github.com/stacktracelabs/laravel-ui-starter-kit', isExternal: true),
                ))
                ->add(MenuItem::make(
                    id: 'documentation',
                    title: 'Documentation',
                    action: Link::to('https://ui.stacktrace.sk', isExternal: true),
                )),
            'settings' => $this->settingsNavigation(),
            'user' => Menu::make()
                ->add(MenuItem::make(
                    id: 'settings',
                    title: 'Settings',
                    action: Link::to(route('profile.edit', absolute: false)),
                )),
            'breadcrumbs' => $this->breadcrumbs($property),
        ];
    }

    /**
     * Build the dashboard navigation item.
     */
    protected function dashboardMenuItem(): MenuItem
    {
        return MenuItem::make(
            id: 'dashboard',
            title: 'Dashboard',
            action: Link::to(route('dashboard', absolute: false)),
        );
    }

    /**
     * Build the settings navigation.
     */
    protected function settingsNavigation(): Menu
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

    /**
     * Build breadcrumbs for the current route.
     */
    protected function breadcrumbs(PropertyContext $property): BreadcrumbList
    {
        return match ($property->request->route()?->getName()) {
            'dashboard' => BreadcrumbList::make()
                ->append(BreadcrumbItem::make('Dashboard')),
            'profile.edit', 'profile.update', 'profile.destroy' => $this->settingsBreadcrumbs('Profile'),
            'security.edit', 'user-password.update' => $this->settingsBreadcrumbs('Security'),
            'appearance.edit' => $this->settingsBreadcrumbs('Appearance'),
            default => BreadcrumbList::make(),
        };
    }

    /**
     * Build a settings breadcrumb trail.
     */
    protected function settingsBreadcrumbs(string $current): BreadcrumbList
    {
        return BreadcrumbList::make()->append(
            BreadcrumbItem::make('Settings', Link::to(route('profile.edit', absolute: false))),
            BreadcrumbItem::make($current),
        );
    }
}
