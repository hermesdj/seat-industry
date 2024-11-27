<?php

namespace Seat\HermesDj\Industry\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Seat\Web\Http\Composers\AbstractMenu;

class DeliveryMenu extends AbstractMenu
{
    private $delivery;

    public function __construct()
    {
        $this->delivery = request()->delivery;
    }

    public function getRequiredKeys(): array
    {
        return ['name', 'permission', 'highlight_view', 'route'];
    }

    public function compose(View $view): void
    {
        $menu = [];
        $menuConfig = config('package.seat-industry.delivery.menu');

        if (! empty($menuConfig)) {
            foreach ($menuConfig as $menuData) {
                $menu[] = $menuData;
            }
        }

        $view->with('menu', $menu);
    }

    protected function userHasPermission(array $permissions): bool
    {
        return Gate::any($permissions, $this->delivery);
    }
}
