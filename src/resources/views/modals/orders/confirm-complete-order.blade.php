<div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmCompleteOrder">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h5 class="modal-title">
                    <i class="fas fa-pencil"></i>
                    {{ trans('seat-industry::ai-orders.modals.completeOrder.title', ['code' => $order->order_id]) }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{!! trans('seat-industry::ai-orders.modals.completeOrder.desc') !!}</p>
                <form
                        action="{{ route("seat-industry.completeOrder", ['order' => $order->id]) }}"
                        method="POST"
                        class="mx-1"
                >
                    @csrf
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-light" data-dismiss="modal">
                            <i class="fas fa-times-circle"></i> {{ trans('web::seat.back') }}
                        </button>
                        <button
                                type="submit"
                                class="btn btn-success"
                        >
                            <i class="fas fa-check-circle"></i>&nbsp;
                            {{trans('seat-industry::ai-orders.btns.completeOrder')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>