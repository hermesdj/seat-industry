<div class="modal fade" tabindex="-1" role="dialog" id="modalEditOrderTime">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h4 class="modal-title">
                    <i class="fas fa-pencil"></i>
                    {{ trans('seat-industry::ai-orders.modals.editTime.title', ['code' => $order->order_id]) }}
                </h4>
            </div>
            <div class="modal-body">
                <p>{{ trans('seat-industry::ai-orders.modals.editTime.desc') }}</p>

                <form
                        id="formEditOrderPrices" method="POST"
                        action="{{ route('Industry.extendOrderTime', ['orderId' => $order->id]) }}"
                        class="form-horizontal"
                >
                    @csrf
                    <div class="form-group">
                        <label for="time">{{trans('seat-industry::ai-orders.time_label')}}</label>
                        <input type="number" id="time" class="form-control" value="7" step="1" min="1"
                               name="time">
                        <small class="text-muted">{{trans('seat-industry::ai-orders.time_hint')}}</small>
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
