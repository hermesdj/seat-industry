<div class="modal fade" tabindex="-1" role="dialog" id="{{$modalId}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-box-open"></i>
                    {{ trans('seat-industry::industry.modals.containers.title') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-sm table-hover" id="containers_table">
                        <thead>
                        <tr>
                            <th class="text-left">{{trans('seat-industry::industry.modals.containers.headers.container')}}</th>
                            <th class="text-right">{{trans('seat-industry::industry.modals.containers.headers.name')}}</th>
                            <th class="text-right">{{trans('seat-industry::industry.modals.containers.headers.location')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($containers as $container)
                            <tr>
                                <td class="text-left">@include('web::partials.type', ['type_id' => $container->type->typeID, 'type_name' => $container->type->typeName])</td>
                                <td class="text-right">{{$container->name}}</td>
                                <td class="text-right">
                                    @if(in_array($container->location_flag, ['CorpSAG1', 'CorpSAG2', 'CorpSAG3', 'CorpSAG4', 'CorpSAG5', 'CorpSAG6', 'CorpSAG7', 'CorpDeliveries']))
                                        @if(in_array($container->container->location_flag, ['Impounded', 'OfficeFolder']))
                                            @if($container->container->location_type == 'station')
                                                {{$container->container->station->name}}
                                            @elseif($container->container->location_flag == 'Impounded' && $container->container->location_type == 'other')
                                                {{$container->container->structure->name}}
                                            @elseif($container->container->location_flag == 'OfficeFolder' && $container->location_type == 'item')
                                                {{$container->container->structure->name}}
                                            @else
                                                {{$container->container->container->name}}
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>