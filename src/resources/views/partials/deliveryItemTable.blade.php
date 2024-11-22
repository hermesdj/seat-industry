<table class="delivery-item-table table table-striped table-hover">
    <thead>
    <tr>
        <th>{{trans('seat-industry::ai-orders.items.headers.type')}}</th>
        <th>{{trans('seat-industry::ai-orders.items.headers.quantity')}}</th>
        <th>{{trans('seat-industry::ai-orders.items.headers.unit_price')}}</th>
        <th>{{trans('seat-industry::ai-orders.items.headers.total')}}</th>
        <th>{{trans('seat-industry::ai-common.actions_header')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td data-sort="{{$item->orderItem->type->typeName}}">
                @include("web::partials.type",[
                    'type_id'   => $item->orderItem->type_id,
                    'type_name' => $item->orderItem->type->typeName,
                    'variation' => $item->orderItem->type->group->categoryID == 9 ? 'bpc' : 'icon',
                ])
            </td>
            <td class="text-right" data-sort="{{$item->quantity_delivered}}">
                {{\Seat\HermesDj\Industry\Helpers\OrderHelper::formatNumber($item->quantity_delivered, 0)}}
            </td>
            <td class="text-right" data-sort="{{$item->orderItem->unit_price / 100}}">
                {{\Seat\HermesDj\Industry\Helpers\OrderHelper::formatNumber($item->orderItem->unit_price / 100)}}
                ISK
            </td>
            <td class="text-right" data-sort="{{$item->orderItem->unit_price / 100 * $item->quantity_delivered}}">
                {{\Seat\HermesDj\Industry\Helpers\OrderHelper::formatNumber($item->orderItem->unit_price / 100 * $item->quantity_delivered)}}
                ISK
            </td>
            <td class="d-flex flex-row text-center align-middle" style="min-width: 120px;">
                @can("seat-industry.same-user",$delivery->user_id)
                    <form action="{{ route("Industry.setDeliveryItemState", ['deliveryId' => $delivery->id, 'itemId' => $item->id]) }}"
                          method="POST"
                          style="width: 50%"
                    >
                        @csrf
                        @if($item->completed)
                            <button type="submit" class="btn btn-warning btn-sm text-nowrap btn-block">
                                <i class="fas fa-clock"></i>
                            </button>
                            <input type="hidden" name="completed" value="0">
                        @else
                            <button type="submit" class="btn btn-success btn-sm text-nowrap btn-block">
                                <i class="fas fa-check"></i>
                            </button>
                            <input type="hidden" name="completed" value="1">
                        @endif
                    </form>

                    @if(!$item->completed || auth()->user()->can("Industry.admin"))
                        <form action="{{ route("Industry.deleteDeliveryItem",['deliveryId' => $delivery->id, 'itemId' => $item->id]) }}"
                              method="POST"
                              style="width: 50%">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm text-nowrap confirmform ml-1 btn-block"
                                    data-seat-action="{{trans('seat-industry::ai-deliveries.cancel_delivery_action')}}">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    @endif
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
