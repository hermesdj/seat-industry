@extends('web::layouts.grids.12')

@section('title', trans('seat-industry::ai-orders.create_order_title'))
@section('page_header', trans('seat-industry::ai-orders.create_order_title'))

@section('full')
    <div class="card">
        <div class="card-body">
            <div class="card-text">
                <form action="{{ route("seat-industry.submitOrder") }}" method="POST" id="orderForm">
                    @csrf

                    <div class="row">
                        <div class="col col-4">
                            <div
                                    class="form-group row"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="{{trans('seat-industry::ai-orders.reference_hint')}}"
                            >
                                <label for="reference"
                                       class="col-sm-3 col-form-label">
                                    {{trans('seat-industry::ai-orders.reference_label')}}
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" id="reference" class="form-control form-control-sm"
                                           maxlength="32"
                                           name="reference">
                                </div>
                            </div>
                            <div
                                    class="form-group row"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="{{trans('seat-industry::ai-orders.deliver_to_hint')}}"
                            >
                                <label for="deliverTo"
                                       class="col-sm-3 col-form-label">{{trans('seat-industry::ai-orders.deliver_to_label')}}</label>
                                <div class="col-sm-9">
                                    @include("seat-industry::utils.deliverToSelector",["id"=>"deliverTo","name"=>"deliverTo","character_id"=>auth()->user()->main_character->character_id])
                                </div>
                            </div>
                            <div
                                    class="form-group row"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="{{trans('seat-industry::ai-orders.quantity_hint')}}"
                            >
                                <label for="quantity"
                                       class="col-sm-3 col-form-label">{{trans('seat-industry::ai-orders.quantity_label')}}</label>
                                <div class="col-sm-9">
                                    <input type="number" id="quantity" class="form-control form-control-sm" value="1"
                                           min="1" step="1"
                                           name="quantity">
                                </div>
                            </div>
                            <div
                                    class="form-group row"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="{{trans('seat-industry::ai-common.price_provider_hint')}}"
                            >
                                <label for="priceprovider"
                                       class="col-sm-3 col-form-label">{{trans('seat-industry::ai-common.price_provider_label')}}</label>
                                <div class="col-sm-9">
                                    @include("seat-industry::utils.priceProviderSelector",["id"=>"priceprovider","name"=>"priceprovider","instance_id"=>$default_price_provider])
                                </div>
                            </div>
                            <div
                                    class="form-group row"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="{{trans('seat-industry::ai-orders.reward_hint', ['mpp' => $mpp])}}"
                            >
                                <label for="profit"
                                       class="col-sm-3 col-form-label">{{trans('seat-industry::ai-orders.reward_label')}}</label>
                                <div class="col-sm-9">
                                    <input
                                            type="number" id="profit" class="form-control form-control-sm"
                                            @if($mpp > 0.0) value="{{$mpp}}" @else value="0" @endif
                                            step="0.1"
                                            name="profit" min="{{$mpp}}"
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="days"
                                       class="col-sm-3 col-form-label">{{trans('seat-industry::ai-orders.days_to_complete_label')}}</label>
                                <div class="col-sm-9">
                                    <input type="number" id="days" class="form-control form-control-sm" name="days"
                                           min="1" step="1"
                                           value="30">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="location"
                                       class="col-sm-3 col-form-label">{{trans('seat-industry::ai-orders.location_label')}}</label>
                                <div class="col-sm-9">
                                    <select id="location" class="form-control form-control-sm" name="location">
                                        @foreach($stations as $station)
                                            <option value="{{ $station->station_id }}" @selected($station->station_id == $location_id)>{{ $station->name }}</option>
                                        @endforeach
                                        @foreach($structures as $structure)
                                            <option value="{{ $structure->structure_id }}" @selected($structure->structure_id == $location_id)>{{ $structure->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @can("seat-industry.order_priority")
                                <div class="form-group row">
                                    <label for="priority"
                                           class="col-sm-3 col-form-label">{{trans('seat-industry::ai-orders.priority_label')}}</label>
                                    <div class="col-sm-9">
                                        <select id="priority" class="form-control form-control-sm" name="priority">
                                            @foreach(\RecursiveTree\Seat\TreeLib\Helpers\PrioritySystem::getPriorityData() as $priority=>$data)
                                                <option value="{{$priority}}" @selected($priority == $defaultPriority)>{{trans('seat-industry::ai-orders.priority_' . $data["name"])}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endcan
                            @can("seat-industry.corp_delivery")
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="reserved_corp" id="reserved_corp"
                                               class="form-check-input"/>
                                        <label for="reserved_corp"
                                               class="form-check-label">{{trans('seat-industry::ai-orders.reserve_corp_btn')}}</label>
                                    </div>
                                </div>
                            @endcan
                        </div>
                        <div class="col col-8">
                            <div class="form-group">
                                <label for="itemsTextarea">{{trans('seat-industry::ai-orders.items_label')}}</label>
                                <textarea
                                        id="itemsTextarea"
                                        name="items"
                                        class="form-control"
                                        placeholder="{{trans('seat-industry::ai-orders.items_placeholder')}}"
                                        rows="20" style="height: 100%">{{ $multibuy ?? "" }}</textarea>
                            </div>
                        </div>
                    </div>

                    <button
                            type="submit"
                            class="btn btn-primary btn-lg btn-block"
                    >
                        {{trans('seat-industry::ai-orders.add_order_btn')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop
@push("javascript")
    <script>
        $(document).ready(function () {
            $("#location").select2()
            $('[data-toggle="tooltip"]').tooltip()
            $('.data-table').DataTable({
                pageLength: 50
            });
        });
    </script>

@endpush