@if($deliveries->isEmpty())
    <div class="alert alert-warning" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        @isset($order)
            {{trans('seat-industry::ai-orders.empty_deliveries')}}
        @else
            {{trans('seat-industry::ai-deliveries.empty_deliveries')}}
        @endisset
    </div>
@else
    <table class="data-table table table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('seat-industry::ai-deliveries.headers.code')}}</th>
            @if($showOrder ?? false)
                <th>{{trans('seat-industry::ai-orders.order_id')}}</th>
            @endif
            <th>{{trans('seat-industry::ai-common.amount_header')}}</th>
            <th>{{trans('seat-industry::ai-common.completion_header')}}</th>
            @if($showOrder ?? false)
                <th>{{trans('seat-industry::ai-common.order_price_header')}}</th>
            @endif
            <th>{{trans('seat-industry::ai-common.delivery_price_header')}}</th>
            <th>{{trans('seat-industry::ai-common.accepted_header')}}</th>
            @if($showOrder ?? false)
                <th>{{trans('seat-industry::ai-common.ordered_by_header')}}</th>
            @endif
            @isset($order)
                <th>{{trans('seat-industry::ai-common.producer_header')}}</th>
            @endif
            <th>{{trans('seat-industry::ai-common.location_header')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($deliveries as $delivery)
            <tr>
                <td>
                    <a href="{{ route("seat-industry.deliveryDetails", ['delivery' => $delivery->id]) }}">{{$delivery->delivery_code}}</a>
                </td>
                @if($showOrder ?? false)
                    <td>
                        <a href="{{ route("seat-industry.orderDetails", ['order' => $delivery->order_id]) }}">{{ $delivery->order->order_id . " - " . $delivery->order->reference }}</a>
                    </td>
                @endif
                <td data-order="{{ $delivery->totalQuantity() }}" data-filter="_">
                    {{ number($delivery->totalQuantity(),0) }}
                </td>
                <td data-order="{{ $delivery->completed_at?carbon($delivery->completed_at)->timestamp:0 }}"
                    data-filter="_">
                    @include("seat-industry::partials.boolean",["value"=>$delivery->completed])
                    @if($delivery->completed_at)
                        @include("seat-industry::partials.time",["date"=>$delivery->completed_at])
                    @endif
                </td>
                @if($showOrder ?? false)
                    <td data-order="{{ $delivery->order->price }}" data-filter="_">
                        {{ number($delivery->order->totalValue()) }} ISK
                    </td>
                @endif
                <td data-order="{{ $delivery->order->price * $delivery->quantity }}" data-filter="_">
                    {{ number($delivery->totalPrice() / 100) }} ISK
                </td>
                <td data-order="{{ $delivery->accepted }}" data-filter="_">
                    @include("seat-industry::partials.time",["date"=>$delivery->accepted])
                </td>
                @if($showOrder ?? false)
                    <td data-order="{{ $delivery->order->user->id ?? 0}}"
                        data-filter="{{ $delivery->order->user->main_character->name ?? trans('web::seat.unknown')}}">
                        @include("web::partials.character",["character"=>$delivery->order->user->main_character ?? null])
                    </td>
                @endif
                @isset($order)
                    <td data-order="{{ $delivery->user->id ?? 0}}"
                        data-filter="{{ $delivery->user->main_character->name ?? trans('web::seat.unknown')}}">
                        @include("web::partials.character",["character"=>$delivery->user->main_character ?? null])
                    </td>
                @endif
                <td data-order="{{ $delivery->order->location_id }}"
                    data-filter="{{ $delivery->order->location()->name }}">
                    @include("seat-industry::partials.longTextTooltip",["text"=>$delivery->order->location()->name])
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif