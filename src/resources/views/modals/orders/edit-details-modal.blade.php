<div class="modal fade" tabindex="-1" role="dialog" id="modalEditDetails">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h5 class="modal-title">
                    <i class="fas fa-pencil"></i>
                    {{ trans('seat-industry::ai-orders.modals.editDetails.title', ['code' => $order->order_id]) }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ trans('seat-industry::ai-orders.modals.editDetails.desc') }}</p>

                <form
                        id="formEditDetails" method="POST"
                        action="{{ route('seat-industry.editDetails', ['order' => $order->id]) }}"
                        class="form-horizontal"
                >
                    @csrf
                    @can("seat-industry.same-user",$order->user_id)
                        <div class="form-group">
                            <label for="reference">{{trans('seat-industry::ai-orders.fields.reference')}}</label>
                            <input type="text" maxlength="32" id="reference" class="form-control"
                                   value="{{$order->reference}}" name="reference"/>
                        </div>
                    @endcan
                    <div class="form-group">
                        <label for="observations">{{trans('seat-industry::ai-orders.fields.observations')}}</label>
                        <textarea
                                id="observations"
                                class="form-control"
                                name="observations"
                        >{{ $order->observations }}</textarea>
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