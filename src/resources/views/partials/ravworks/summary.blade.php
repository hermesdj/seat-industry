@if($buildPlan->getPersonalStocks()->containers->count() > 0)
    @include('seat-industry::modals.industry.industry-containers-modal', ['modalId' => 'personalContainersModal', 'containers' => $buildPlan->getPersonalStocks()->containers])
@endif
@if($buildPlan->getCorporationStocks()->containers->count() > 0)
    @include('seat-industry::modals.industry.industry-containers-modal', ['modalId' => 'corporationContainersModal', 'containers' => $buildPlan->getCorporationStocks()->containers])
@endif
<div class="row px-3">
    <div class="col">
        <div class="row mb-1">
            <div class="col-sm-4 text-muted">{{trans('seat-industry::industry.buildPlan.fields.nbContainers')}}</div>
            <div class="col-sm-8">
                {{$buildPlan->getPersonalStocks()->containers->count()}}
                @if($buildPlan->getPersonalStocks()->containers->count() > 0)
                    @include('seat-industry::partials.ravworks.container-modal-btn', ['modalId' => 'personalContainersModal'])
                @endif
            </div>
        </div>
        @can('seat-industry.corp_delivery')
            <div class="row mb-1">
                <div class="col-sm-4 text-muted">{{trans('seat-industry::industry.buildPlan.fields.nbCorpContainers')}}</div>
                <div class="col-sm-8">
                    {{$buildPlan->getCorporationStocks()->containers->count()}}
                    @if($buildPlan->getCorporationStocks()->containers->count() > 0)
                        @include('seat-industry::partials.ravworks.container-modal-btn', ['modalId' => 'corporationContainersModal'])
                    @endif
                </div>
            </div>
        @endcan
    </div>
</div>