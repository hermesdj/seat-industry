<table class="prepare-delivery-item-table table table-striped table-hover">
    <thead>
    <tr>
        <th>{{trans('seat-industry::ai-deliveries.items.headers.type')}}</th>
        <th>{{trans('seat-industry::ai-deliveries.items.headers.available_quantity')}}</th>
        <th>{{trans('seat-industry::ai-deliveries.items.headers.selected_quantity')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td data-sort="{{$item->type->typeName}}">
                @include("web::partials.type",[
                    'type_id'   => $item->type_id,
                    'type_name' => $item->type->typeName,
                    'variation' => $item->type->group->categoryID == 9 ? 'bpc' : 'icon',
                ])
            </td>
            <td class="text-center" data-sort="{{$item->quantity}}">
                {{\HermesDj\Seat\Industry\Helpers\IndustryHelper::formatNumber($item->availableQuantity(), 0)}}
            </td>
            <td class="text-center" data-sort="{{$item->unit_price / 100}}">
                <input
                        style="background-color: transparent;"
                        type="number"
                        step="1"
                        name="quantities[{{$item->id}}]"
                        max="{{$item->availableQuantity()}}"
                        min="0"
                        class="form-control"
                        value="{{$item->availableQuantity()}}"
                />
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@push("javascript")
    <script>
        $(document).ready(function () {
            $('.prepare-delivery-item-table').DataTable({
                stateSave: true,
                paging: false
            });
        });
    </script>
@endpush
