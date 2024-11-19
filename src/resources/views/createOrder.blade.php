@extends('web::layouts.grids.12')

@section('title', trans('seat-industry::ai-orders.create_order_title'))
@section('page_header', trans('seat-industry::ai-orders.create_order_title'))


@section('full')
    <div class="card">
        <div class="card-body">
            <h5 class="card-header d-flex flex-row align-items-baseline">
                {{trans('seat-industry::ai-orders.create_order_title')}}
                <a href="{{ route("Industry.orders") }}"
                   class="btn btn-danger ml-auto">{{trans('seat-industry::ai-common.cancel')}}</a>
            </h5>
            <p class="card-text">
            <form action="{{ route("Industry.submitOrder") }}" method="POST" id="orderForm">
                @csrf

                <div class="form-group">
                    <label for="deliverTo">{{trans('seat-industry::ai-orders.deliver_to_label')}}</label>
                    @include("seat-industry::utils.deliverToSelector",["id"=>"deliverTo","name"=>"deliverTo","character_id"=>auth()->user()->main_character->character_id])
                    <small class="text-muted">{{trans('seat-industry::ai-orders.deliver_to_hint')}}</small>
                </div>

                <div class="form-group">
                    <label for="reference">{{trans('seat-industry::ai-orders.reference_label')}}</label>
                    <input type="text" id="reference" class="form-control" maxlength="32"
                           name="reference">
                    <small class="text-muted">{{trans('seat-industry::ai-orders.reference_hint')}}</small>
                </div>

                <div class="form-group">
                    <label for="quantity">{{trans('seat-industry::ai-orders.quantity_label')}}</label>
                    <input type="number" id="quantity" class="form-control" value="1" min="1" step="1"
                           name="quantity">
                    <small class="text-muted">{{trans('seat-industry::ai-orders.quantity_hint')}}</small>
                </div>

                <div class="form-group">
                    <label for="itemsTextarea">{{trans('seat-industry::ai-orders.items_label')}}</label>
                    <textarea
                            id="itemsTextarea"
                            name="items"
                            class="form-control"
                            placeholder="{{trans('seat-industry::ai-orders.items_placeholder')}}"
                            rows="20">{{ $multibuy ?? "" }}</textarea>
                </div>

                @can('Industry.change_price_provider')
                    <div class="form-group">
                        <label for="priceprovider">{{trans('seat-industry::ai-common.price_provider_label')}}</label>
                        @include("seat-industry::utils.priceProviderSelector",["id"=>"priceprovider","name"=>"priceprovider","instance_id"=>$default_price_provider])
                        <small class="text-muted">{{trans('seat-industry::ai-common.price_provider_hint')}}</small>
                    </div>
                @endcan

                <div class="form-group">
                    <label for="profit">{{trans('seat-industry::ai-orders.reward_label')}}</label>
                    <input type="number" id="profit" class="form-control" value="0" step="0.1"
                           name="profit">
                    <small class="text-muted">{{trans('seat-industry::ai-orders.reward_hint', ['mpp' => $mpp])}}</small>
                </div>

                <div class="form-group">
                    <label for="days">{{trans('seat-industry::ai-orders.days_to_complete_label')}}</label>
                    <input type="number" id="days" class="form-control" name="days" min="1" step="1" value="30">
                </div>

                <div class="form-group">
                    <label for="location">{{trans('seat-industry::ai-orders.location_label')}}</label>
                    <select id="location" class="form-control" name="location">
                        @foreach($stations as $station)
                            <option value="{{ $station->station_id }}" @selected($station->station_id ==
                                $location_id)>{{ $station->name }}</option>
                        @endforeach
                        @foreach($structures as $structure)
                            <option value="{{ $structure->structure_id }}" @selected($structure->structure_id ==
                                $location_id)>{{ $structure->name }}</option>
                        @endforeach
                    </select>
                </div>

                @can("Industry.order_priority")
                    <div class="form-group">
                        <label for="priority">{{trans('seat-industry::ai-orders.priority_label')}}</label>
                        <select id="priority" class="form-control" name="priority">
                            @foreach(\HermesDj\Seat\TreeLib\Helpers\PrioritySystem::getPriorityData() as $priority=>$data)
                                <option value="{{$priority}}" @selected($priority == $defaultPriority)>{{trans('seat-industry::ai-orders.priority_' . $data["name"])}}</option>
                            @endforeach
                        </select>
                    </div>
                @endcan

                @if(\HermesDj\Seat\TreeLib\Helpers\SeatInventoryPluginHelper::pluginIsAvailable())
                    @can("Industry.add_to_seat_inventory")
                        <div class="form-group" style="display: none;">
                            <label for="addToSeatInventory">{{trans('seat-industry::ai-orders.seat_inventory_label')}}</label>
                            <div class="form-check">
                                <input type="checkbox" id="addToSeatInventory" class="form-check-input" checked
                                       name="addToSeatInventory">
                                <label for="addToSeatInventory"
                                       class="form-check-label">{{trans('seat-industry::ai-orders.seat_inventory_hint')}}</label>
                            </div>
                            <small class="text-muted">
                                {!! trans('seat-industry::ai-orders.seat_inventory_desc', ['route' => route("inventory.settings")]) !!}
                            </small>
                        </div>
                    @endcan
                @endif

                @can("Industry.create_repeating_orders")
                    <div class="form-group">
                        <label for="repetition">{{trans('seat-industry::ai-orders.repetition_label')}}</label>
                        <select id="repetition" name="repetition" class="form-control">
                            <option value="0"
                                    selected>{{trans('seat-industry::ai-orders.repetition_never')}}</option>
                            <option value="7">{{trans('seat-industry::ai-orders.repetition_weekly')}}</option>
                            <option value="14">{{trans('seat-industry::ai-orders.repetition_every_two_weeks')}}</option>
                            <option value="28">{{trans('seat-industry::ai-orders.repetition_monthly')}}</option>
                        </select>
                    </div>
                @endcan

                <button type="submit"
                        class="btn btn-primary">{{trans('seat-industry::ai-orders.add_order_btn')}}</button>
            </form>

            </p>
        </div>
    </div>
@stop
@push("javascript")
    <script>
        $(document).ready(function () {
            $("#location").select2()
            $('[data-toggle="tooltip"]').tooltip()
            $('.data-table').DataTable();
        });
    </script>

@endpush