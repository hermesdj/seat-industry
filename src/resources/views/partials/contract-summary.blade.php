<table class="table">
    <tbody>
    <tr>
        <td>
            {{ trans('seat-industry::ai-deliveries.contract.contract_type') }}
        </td>
        <td>
            <b>{{trans('seat-industry::ai-deliveries.contract.item_exchange')}}</b>
        </td>
    </tr>
    <tr>
        <td>
            {{ trans('seat-industry::ai-deliveries.contract.location') }}
        </td>
        <td>
            <b>
                @include("seat-industry::partials.longTextTooltip",["text"=>$delivery->order->location()->name,"length"=>25])
            </b>
        </td>
    </tr>
    <tr>
        <td>
            {{ trans('seat-industry::ai-deliveries.contract.contract_to') }}*
        </td>
        <td>
            <b
                    onClick="SelfCopy(this)"
                    data-container="body"
                    data-toggle="popover"
                    data-placement="top"
                    data-content="Copied!"
            >
                {{ $delivery->order->deliver_to ? $delivery->order->deliverToCharacter->name : $delivery->order->user->name }}
            </b>
        </td>
    </tr>
    <tr>
        <td>
            {{ trans('seat-industry::ai-deliveries.contract.payment') }}*
        </td>
        <td>
            <b
                    onClick="SelfCopy(this)"
                    data-container="body"
                    data-toggle="popover"
                    data-placement="top" data-content="Copied!"
            >
                <span class="isk-info">{{ number($delivery->totalPrice() / 100) }}</span>
            </b>
            <b>ISK</b>
        </td>
    </tr>
    <tr>
        <td>
            {{ trans('seat-industry::ai-deliveries.contract.expiration') }}
        </td>
        <td>
            <b>6</b>
        </td>
    </tr>
    <tr>
        <td>
            {{ trans('seat-industry::ai-deliveries.contract.description') }}*
        </td>
        <td>
            <b
                    onClick="SelfCopy(this)"
                    data-container="body"
                    data-toggle="popover"
                    data-placement="top"
                    data-content="Copied!"
            >
                {{ $delivery->delivery_code }}
            </b>
        </td>
    </tr>
    </tbody>
</table>

@push('javascript')
    <script>
        function SelfCopy(object) {
            navigator.clipboard.writeText(object.innerText);

            $(object).popover().click(function () {
                setTimeout(function () {
                    $(object).popover('hide');
                }, 1000);
            });
        }
    </script>
@endpush