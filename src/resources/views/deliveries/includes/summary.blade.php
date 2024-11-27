<div class="row">
    <div class="col">
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-deliveries.fields.order')}}</div>
            <div class="col-sm-8"><a
                        href="{{ route("seat-industry.orderDetails", ['order' => $delivery->order_id]) }}">{{ $delivery->order->order_id }}
                    - {{ $delivery->order->reference }}</a>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-deliveries.fields.accepted')}}</div>
            <div class="col-sm-8">@include("seat-industry::partials.time",["date"=>$delivery->accepted])</div>
        </div>
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-deliveries.fields.quantity')}}</div>
            <div class="col-sm-8">{{$delivery->totalQuantity()}}</div>
        </div>
    </div>
    <div class="col">
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-deliveries.fields.producer')}}</div>
            <div class="col-sm-8">@include("web::partials.character",["character"=>$delivery->user->main_character ?? null])</div>
        </div>
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::ai-deliveries.fields.completed')}}</div>
            <div class="col-sm-8">
                @include("seat-industry::partials.boolean",["value"=>$delivery->completed])
                @if($delivery->completed_at)
                    @include("seat-industry::partials.time",["date"=>$delivery->completed_at])
                @endif
            </div>
        </div>
    </div>
</div>
