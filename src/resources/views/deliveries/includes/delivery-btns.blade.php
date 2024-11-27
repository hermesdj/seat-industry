@can("seat-industry.same-user",$delivery->user_id)
    <div class="d-flex flex-row mb-3">
        <form action="{{ route("seat-industry.setDeliveryState", ['delivery' => $delivery->id]) }}"
              method="POST"
              class="mx-1"
        >
            @csrf
            @if($delivery->completed)
                <button type="submit"
                        class="btn btn-warning text-nowrap confirmform btn-block"
                        data-seat-action="{{trans('seat-industry::ai-deliveries.mark_in_progress_action')}}">
                    <i class="fas fa-clock"></i>&nbsp;
                    {{trans('seat-industry::ai-deliveries.status_in_progress')}}
                </button>
                <input type="hidden" name="completed" value="0">
            @else
                <button type="submit"
                        class="btn btn-success text-nowrap confirmform btn-block"
                        data-seat-action="{{trans('seat-industry::ai-deliveries.mark_delivered_action')}}">
                    <i class="fas fa-check"></i>&nbsp;
                    {{trans('seat-industry::ai-deliveries.status_delivered')}}
                </button>
                <input type="hidden" name="completed" value="1">
            @endif
        </form>
        @if(!$delivery->completed || auth()->user()->can("seat-industry.admin"))
            <form action="{{ route("seat-industry.deleteDelivery", ['delivery' => $delivery->id]) }}"
                  method="POST"
                  class="mx-1">
                @csrf
                <button type="submit"
                        class="btn btn-danger">
                    <i class="fas fa-times"></i>&nbsp;
                    {{trans('seat-industry::ai-deliveries.cancel_delivery_btn')}}
                </button>
            </form>
        @endif
    </div>
@endcan