<ul class="nav nav-tabs" id="productionTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="production-tab" data-toggle="tab" data-target="#productionTab"
                type="button" role="tab"
                aria-controls="productionTab"
                aria-selected="true"
        >
            {{trans('seat-industry::industry.ravworks.produce')}}
        </button>
    </li>
</ul>
<div class="tab-content" id="productionTabsContent">
    <div class="tab-pane fade show active" id="productionTab" role="tabpanel"
         aria-labelledby="production-tab" style="height: 100%">
                    <textarea id="productionTarget" name="productionTarget" rows="8" cols="50"
                              style="width: 100%; white-space: pre-wrap;">{!! htmlspecialchars($buildPlan->toRavworksText()) !!}</textarea>
        @if($buildPlan->hasProduction())
            @include('seat-industry::orders.partials.copyToRavworks', ['ravworksText' => $buildPlan->toRavworksText()])
        @else
            <a
                    href="#"
                    data-container="body"
                    data-toggle="popover"
                    data-placement="top"
                    data-content="{!! trans('seat-industry::industry.ravworks.stockTip', ['code' => $order->order_id]) !!}"
            >
                <small class="text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    {!! trans('seat-industry::industry.ravworks.errors.noProduction', ['code' => $order->order_id]) !!}
                </small>
            </a>
        @endif
    </div>
</div>