@extends('web::layouts.grids.12')

@section('title', trans('seat-industry::ai-settings.settings_title'))
@section('page_header', trans('seat-industry::ai-settings.settings_title'))


@section('full')
    <div class="card">
        <div class="card-body">
            <h4 class="card-header">
                {{trans('seat-industry::ai-settings.settings_title')}}
            </h4>
            <div class="card-text my-3 mx-3">
                <form action="{{ route("seat-industry.saveSettings") }}" method="POST">
                    @csrf
                    <h5>{{trans('seat-industry::ai-settings.price_settings_title')}}</h5>

                    <div class="form-group">
                        <label for="priceprovider">{{trans('seat-industry::ai-settings.default_price_provider_label')}}</label>
                        @include("pricescore::utils.instance_selector",["id"=>"priceprovider","name"=>"defaultPriceProvider","instance_id"=>$default_price_provider])
                        <small class="text-muted">{!! trans('seat-industry::ai-settings.default_price_provider_hint', ['route' => route('pricescore::settings')]) !!}</small>
                    </div>

                    <div class="form-group">
                        <label for="mpp">{{trans('seat-industry::ai-settings.mmpp_label')}}</label>
                        <input type="number" value="{{ $mpp }}" step="0.1" id="mpp"
                               name="minimumprofitpercentage" class="form-control">
                        <small class="text-muted">{{trans('seat-industry::ai-settings.mmpp_hint')}}</small>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="allowPriceBelowAutomatic" class="form-check-input"
                                   name="allowPriceBelowAutomatic" @checked($allowPriceBelowAutomatic)>
                            <label for="allowPriceBelowAutomatic"
                                   class="form-check-label">{{trans('seat-industry::ai-settings.allow_manual_prices_label')}}</label>
                        </div>
                        <small class="text-muted">{{trans('seat-industry::ai-settings.allow_manual_prices_hint')}}</small>
                    </div>

                    <h5>{{trans('seat-industry::ai-settings.general_settings_title')}}</h5>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="removeExpiredDeliveries" class="form-check-input"
                                   name="removeExpiredDeliveries" @checked($removeExpiredDeliveries)>
                            <label for="removeExpiredDeliveries"
                                   class="form-check-label">{{trans('seat-industry::ai-settings.remove_expired_deliveries_label')}}</label>
                        </div>
                        <small class="text-muted">{{trans('seat-industry::ai-settings.remove_expired_deliveries_hint')}}</small>
                    </div>

                    <div class="form-group">
                        <label for="defaultLocation">{{trans('seat-industry::ai-settings.default_location_label')}}</label>
                        <select id="defaultLocation" class="form-control" name="defaultLocation">
                            @foreach($stations as $station)
                                <option value="{{ $station->station_id }}" @selected($station->station_id == $defaultOrderLocation )>{{ $station->name }}</option>
                            @endforeach
                            @foreach($structures as $structure)
                                <option value="{{ $structure->structure_id }}" @selected($structure->structure_id == $defaultOrderLocation )>{{ $structure->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            {{trans('seat-industry::ai-settings.default_location_hint')}}
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="priceProviderWhitelist">{{trans('seat-industry::ai-settings.price_provider_whitelist_label')}}</label>
                        <select id="priceProviderWhitelist" class="form-control" name="priceProviderWhitelist[]"
                                multiple>
                            @foreach(\RecursiveTree\Seat\PricesCore\Models\PriceProviderInstance::all() as $instance)
                                @if(in_array($instance->id, $allowedPriceProviders))
                                    <option value="{{ $instance->id }}" selected>{{ $instance->name }}</option>
                                @else
                                    <option value="{{ $instance->id }}">{{ $instance->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <small class="text-muted">
                            {{trans('seat-industry::ai-settings.price_provider_whitelist_hint')}}
                        </small>
                    </div>

                    <div class="form-group">
                        <button type="submit"
                                class="btn btn-primary">{{trans('seat-industry::ai-settings.update_settings_btn')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@push("javascript")
    <script>
        $(document).ready(function () {
            $("#defaultLocation").select2()
            $('[data-toggle="tooltip"]').tooltip()
            $('.data-table').DataTable();
        });
    </script>
@endpush