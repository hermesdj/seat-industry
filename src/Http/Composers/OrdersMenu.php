<?php

namespace Seat\HermesDj\Industry\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Seat\Web\Http\Composers\AbstractMenu;

class OrdersMenu extends AbstractMenu
{
    public function getRequiredKeys(): array
    {
        return ['name', 'permission', 'highlight_view', 'route'];
    }

    public function compose(View $view): void
    {
        $menu = [];
        $menuConfig = config('package.seat-industry.orders.menu');

        if (! empty($menuConfig)) {
            foreach ($menuConfig as $menuData) {
                if (isset($menuData['badgeValueClass']) && isset($menuData['badgeValueMethod'])) {
                    $badgeClass = $menuData['badgeValueClass'];
                    $badgeMethod = $menuData['badgeValueMethod'];
                    $menuData['value'] = call_user_func($badgeClass.'::'.$badgeMethod);
                }
                $menu[] = $menuData;
            }
        }

        $view->with('menu', $menu);
    }

    protected function userHasPermission(array $permissions): bool
    {
        return Gate::any($permissions);
    }
}
