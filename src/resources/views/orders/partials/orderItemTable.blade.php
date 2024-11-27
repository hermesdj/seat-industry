<table class="order-item-table table table-striped table-hover">
    <thead>
    <tr>
        <th>{{trans('seat-industry::ai-orders.items.headers.type')}}</th>
        <th>{{trans('seat-industry::ai-orders.items.headers.quantity')}}</th>
        <th>{{trans('seat-industry::ai-orders.items.headers.unit_price')}}</th>
        <th>{{trans('seat-industry::ai-orders.items.headers.total')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr
                @if($item->assignedQuantity() == $item->quantity) class="bg-success"
                @elseif($item->assignedQuantity() > 0)
                    class="bg-warning"
                @endif
        >
            <td data-sort="{{$item->type->typeName}}">
                @include("web::partials.type",[
                    'type_id'   => $item->type_id,
                    'type_name' => $item->type->typeName,
                    'variation' => $item->type->group->categoryID == 9 ? 'bpc' : 'icon',
                ])
            </td>
            <td class="text-right" data-sort="{{$item->quantity}}">
                {{\Seat\HermesDj\Industry\Helpers\OrderHelper::formatNumber($item->assignedQuantity(), 0)}}
                /
                {{\Seat\HermesDj\Industry\Helpers\OrderHelper::formatNumber($item->quantity, 0)}}
            </td>
            <td class="text-right" data-sort="{{$item->unit_price / 100}}">
                {{\Seat\HermesDj\Industry\Helpers\OrderHelper::formatNumber($item->unit_price / 100)}}
                ISK
            </td>
            <td class="text-right" data-sort="{{$item->unit_price / 100 * $item->quantity}}">
                {{\Seat\HermesDj\Industry\Helpers\OrderHelper::formatNumber($item->unit_price / 100 * $item->quantity)}}
                ISK
            </td>
        </tr>
    @endforeach
    </tbody>
</table>