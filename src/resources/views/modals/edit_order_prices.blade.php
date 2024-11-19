<div class="modal fade" tabindex="-1" role="dialog" id="modalEditOrderPrices">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h4 class="modal-title">
                    <i class="fas fa-pencil"></i>
                    {{ trans('seat-industry::ai-orders.modals.editPrices.title', ['code' => $order->order_id]) }}
                </h4>
            </div>
            <div class="modal-body">
                <p>{{ trans('seat-industry::ai-orders.modals.editPrices.desc') }}</p>

                <form
                        id="formEditOrderPrices" method="POST"
                        action="{{ route('Industry.updateOrderPrice', ['orderId' => $order->id]) }}"
                        class="form-horizontal"
                >
                    @csrf
                    @can('Industry.change_price_provider')
                        <div class="form-group">
                            <label for="priceprovider">{{trans('seat-industry::ai-common.price_provider_label')}}</label>
                            @include("seat-industry::utils.priceProviderSelector",["id"=>"priceprovider","name"=>"priceprovider","instance_id"=>$order->priceProvider])
                            <small class="text-muted">{{trans('seat-industry::ai-common.price_provider_hint')}}</small>
                        </div>
                    @endcan
                    <div class="form-group">
                        <label for="profit">{{trans('seat-industry::ai-orders.reward_label')}}</label>
                        <input type="number" id="profit" class="form-control" value="{{ $order->profit  }}" step="0.1"
                               name="profit">
                        <small class="text-muted">{{trans('seat-industry::ai-orders.reward_hint', ['mpp' => $mpp])}}</small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-light" data-dismiss="modal">
                            <i class="fas fa-times-circle"></i> {{ trans('web::seat.back') }}
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle"></i> {{ trans('web::seat.update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>