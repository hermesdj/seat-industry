<table class="order-data-table table table-striped table-hover">
    <thead>
    <tr>
        @can("seat-industry.order_priority")
            <th>{{trans('seat-industry::ai-common.tags_header')}}</th>
        @endcan
        @isset($displayStatus)
            @if($displayStatus)
                <th>{{trans('seat-industry::ai-common.headers.order_status')}}</th>
            @endif
        @endisset
        <th>{{trans('seat-industry::ai-orders.order_id')}}</th>
        <th>{{trans('seat-industry::ai-common.quantity_header')}}</th>
        <th>{{trans('seat-industry::ai-common.completion_header')}}</th>
        <th>{{trans('seat-industry::ai-common.total_price_header')}}</th>
        <th>{{trans('seat-industry::ai-common.location_header')}}</th>
        <th>{{trans('seat-industry::ai-common.created_header')}}</th>
        <th>{{trans('seat-industry::ai-common.until_header')}}</th>
        <th>{{trans('seat-industry::ai-common.character_header')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            @can("seat-industry.order_priority")
                <td data-sort="{{ $order->priority }}" data-filter="_">
                    @include("treelib::partials.priority",["priority"=>$order->priority])
                    @if($order->is_repeating)
                        <span class="badge badge-secondary">{{trans('seat-industry::ai-common.repeating_badge')}}</span>
                    @endif
                </td>
            @endcan
            @isset($displayStatus)
                @if($displayStatus)
                    <td>
                        @if($order->confirmed)
                            <span class="badge badge-success">{{trans('seat-industry::ai-orders.status.available')}}</span>
                        @else
                            <span class="badge badge-danger">{{trans('seat-industry::ai-orders.status.unconfirmed')}}</span>
                        @endif
                    </td>
                @endif
            @endisset
            <td>
                <a href="{{ route("seat-industry.orderDetails", ['order' => $order->id]) }}">{{ $order->order_id }}
                    - {{$order->reference}}</a>
            </td>
            <td data-sort="{{ $order->quantity - $order->assignedQuantity() }}" data-filter="_">
                {{number($order->assignedQuantity(),0)}}/{{ number($order->totalQuantity(),0) }}
            </td>
            <td data-sort="{{ $order->completed_at?carbon($order->completed_at)->timestamp:0 }}" data-filter="_">
                @include("seat-industry::partials.boolean",["value"=>$order->completed])
                @if($order->completed_at)
                    @include("seat-industry::partials.time",["date"=>$order->completed_at])
                @endif
            </td>
            <td data-sort="{{ $order->price / 100 }}" data-filter="_">
                {{ number(($order->totalValue())) }} ISK
            </td>
            <td data-sort="{{ $order->location_id }}" data-filter="{{ $order->location()->name }}">
                @include("seat-industry::partials.longTextTooltip",["text"=>$order->location()->name,"length"=>25])
            </td>
            <td data-sort="{{ carbon($order->created_at)->timestamp }}" data-filter="_">
                @include("seat-industry::partials.time",["date"=>$order->created_at])
            </td>
            <td data-sort="{{ carbon($order->produce_until)->timestamp }}" data-filter="_">
                @include("seat-industry::partials.time",["date"=>$order->produce_until])
            </td>
            <td data-sort="{{ $order->user->id ?? 0 }}"
                data-filter="{{ $order->user->main_character->name ?? "deleted user"}}">
                @include("web::partials.character",["character"=>$order->user->main_character ?? null])
            </td>
        </tr>
    @endforeach
    </tbody>
</table>