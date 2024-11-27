<table class="table">
    <tbody>
    <tr>
        <td>
            <b>{{ trans('seat-industry::ai-orders.summary.order_total') }}</b>
        </td>
        <td class="text-right">
            <b>{{number($order->totalValue())}} ISK</b>
        </td>
    </tr>
    <tr>
        <td>
            <b>{{ trans('seat-industry::ai-orders.summary.remaining') }}</b>
        </td>
        <td class="text-right">
            {{number($order->totalValue() - $order->totalDelivered() - $order->totalInDelivery())}} ISK
        </td>
    </tr>
    <tr>
        <td>
            <b>{{ trans('seat-industry::ai-orders.summary.in_delivery') }}</b>
        </td>
        <td class="text-right">
            {{number($order->totalInDelivery())}} ISK
        </td>
    </tr>
    <tr class="text-danger">
        <td>
            <b>{{ trans('seat-industry::ai-orders.summary.rejected') }}</b>
        </td>
        <td class="text-right">
            {{number($order->totalRejected())}} ISK
        </td>
    </tr>
    <tr class="text-success">
        <td>
            <b>{{ trans('seat-industry::ai-orders.summary.delivered') }}</b>
        </td>
        <td class="text-right">
            <b>{{number($order->totalDelivered())}} ISK</b>
        </td>
    </tr>
    </tbody>
</table>