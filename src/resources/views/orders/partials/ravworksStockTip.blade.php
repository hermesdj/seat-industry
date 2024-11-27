<br/>
<a
        class="text-info"
        style="cursor: pointer;"
        data-container="body"
        data-toggle="popover"
        title="{{trans('seat-industry::industry.ravworks.stockTipTitle')}}"
        data-placement="top"
        data-html="true"
        data-content="{!! trans('seat-industry::industry.ravworks.stockTip', ['code' => $code]) !!}"
>
    {{trans('seat-industry::industry.ravworks.stockTipText')}}
    <i class="fas fa-question"></i>
</a>