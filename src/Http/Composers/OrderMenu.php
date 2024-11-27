<?php

namespace Seat\HermesDj\Industry\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\Web\Exceptions\PackageMenuBuilderException;
use Seat\Web\Http\Composers\AbstractMenu;

class OrderMenu extends AbstractMenu
{
    /**
     * @var Order
     */
    private $order;

    public function __construct()
    {
        $this->order = request()->order;
    }

    public function getRequiredKeys(): array
    {
        return ['name', 'permission', 'highlight_view', 'route'];
    }

    /**
     * @throws PackageMenuBuilderException
     */
    public function compose(View $view): void
    {
        $menu = [];
        $menuConfig = config('package.seat-industry.order.menu');

        if (! empty($menuConfig)) {
            foreach ($menuConfig as $menuData) {
                $menu[] = $menuData;
            }
        }

        $view->with('menu', $menu);
    }

    protected function userHasPermission(array $permissions): bool
    {
        return Gate::any($permissions, $this->order);
    }
}
