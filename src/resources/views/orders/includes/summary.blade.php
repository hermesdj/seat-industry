<div class="row">
    <div class="col">
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-orders.fields.code')}}</div>
            <div class="col-sm-8">{{$order->order_id}}</div>
        </div>
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-orders.fields.reference')}}</div>
            <div class="col-sm-8">{{$order->reference}}</div>
        </div>
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-orders.fields.quantities')}}</div>
            <div class="col-sm-8"> {{$order->assignedQuantity()}} / {{$order->totalQuantity()}}</div>
        </div>
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-common.price_provider_label')}}</div>
            <div class="col-sm-8"><b>{{$order->profit}}%</b> {{$order->priceProviderInstance->name}}</div>
        </div>
    </div>
    <div class="col">
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-common.character_header')}}</div>
            <div class="col-sm-8">@include("web::partials.character",["character"=>$order->user->main_character ?? null])</div>
        </div>
        @if($order->deliver_to != $order->user->main_character->character_id)
            <div class="row mb-1">
                <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-common.deliver_to_header')}}</div>
                <div class="col-sm-8">@include("web::partials.character",["character"=>$order->deliverToCharacter ?? $order->user->main_character])</div>
            </div>
        @endif
        @if($order->corporation != null)
            <div class="row mb-1">
                <div class="col-sm-4 text-bold text-muted">{{trans('seat-industry::ai-orders.fields.corporation')}}</div>
                <div class="col-sm-8">@include("web::partials.corporation",["corporation"=>$order->corporation])</div>
            </div>
        @endif
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-orders.fields.location')}}</div>
            <div class="col-sm-8">@include("seat-industry::partials.longTextTooltip",["text"=>$order->location()->name,"length"=>40])</div>
        </div>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col">
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-orders.fields.date')}}</div>
            <div class="col-sm-8">@include("seat-industry::partials.time",["date"=>$order->created_at])</div>
        </div>
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-common.until_header')}}</div>
            <div class="col-sm-8">@include("seat-industry::partials.time",["date"=>$order->produce_until])</div>
        </div>
    </div>
    <div class="col">
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-common.confirmed_header')}}</div>
            <div class="col-sm-8">
                @if($order->confirmed)
                    <span class="badge badge-success">{{trans('seat-industry::ai-orders.status.available')}}</span>
                @else
                    <span class="badge badge-danger">{{trans('seat-industry::ai-orders.status.unconfirmed')}}</span>
                @endif
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-common.completion_header')}}</div>
            <div class="col-sm-8">
                @include("seat-industry::partials.boolean",["value"=>$order->completed])
                @if($order->completed_at)
                    @include("seat-industry::partials.time",["date"=>$order->completed_at])
                @endif
            </div>
        </div>
    </div>
</div>