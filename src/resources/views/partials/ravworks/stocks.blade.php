<ul class="nav nav-tabs" id="stockTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="personal-stock-tab" data-toggle="tab"
                data-target="#personalStock" type="button" role="tab" aria-controls="personalStock"
                aria-selected="true">Personal Stocks
        </button>
    </li>
    @can('seat-industry.corp_delivery')
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="corporation-stock-tab" data-toggle="tab"
                    data-target="#corporationStock" type="button" role="tab"
                    aria-controls="corporationStock"
                    aria-selected="false">Corporation Stocks
            </button>
        </li>
    @endcan
</ul>
<div class="tab-content" id="stockTabsContent">
    <div class="tab-pane fade show active" id="personalStock" role="tabpanel"
         aria-labelledby="personal-stock-tab" style="height: 100%">
                    <textarea id="corporationStocks" name="corporationStocks" rows="8" cols="50"
                              style="width: 100%; white-space: pre-wrap;">{!! htmlspecialchars($buildPlan->toRavworksPersonalStockText()) !!}</textarea>
        @if($buildPlan->hasPersonalStocks())
            @include('seat-industry::orders.partials.copyToRavworks', ['ravworksText' => $buildPlan->toRavworksPersonalStockText()])
        @else
            <small class="text-danger">
                <i class="fas fa-exclamation-triangle"></i>
                {!! trans('seat-industry::industry.ravworks.errors.noPersonalStock', ['code' => $code]) !!}
            </small>
            @include('seat-industry::orders.partials.ravworksStockTip', ['code' => $code])
        @endif
    </div>
    <div class="tab-pane fade" id="corporationStock" role="tabpanel"
         aria-labelledby="corporation-stock-tab" style="height: 100%">
                     <textarea id="productionTarget" name="productionTarget" rows="8" cols="50"
                               style="width: 100%; white-space: pre-wrap;">{!! htmlspecialchars($buildPlan->toRavworksCorporationStockText()) !!}</textarea>
        @if($buildPlan->hasCorporationStocks())
            @include('seat-industry::orders.partials.copyToRavworks', ['ravworksText' => $buildPlan->toRavworksCorporationStockText()])
        @else
            <small class="text-danger">
                <i class="fas fa-exclamation-triangle"></i>
                {!! trans('seat-industry::industry.ravworks.errors.noCorporationStock', ['code' => $code] ) !!}
            </small>
            @include('seat-industry::orders.partials.ravworksStockTip', ['code' => $code])
        @endif
    </div>
</div>