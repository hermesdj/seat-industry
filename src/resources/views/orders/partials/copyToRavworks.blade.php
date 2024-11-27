<a
        style="color: darkgoldenrod; cursor: pointer;"
        onclick='RavworksCopy(this, {{json_encode($ravworksText)}})'
        data-container="body"
        data-toggle="popover"
        data-placement="top"
        data-content="{{trans('seat-industry::ai-common.messages.copy_response')}}"
>
    <small>{{trans('seat-industry::industry.ravworks.copyToClipboard')}}</small>
</a>

@push('javascript')
    <script>
        function RavworksCopy(object, content) {
            navigator.clipboard.writeText(content);

            $(object).popover().click(function () {
                setTimeout(function () {
                    $(object).popover('hide');
                }, 1000);
            });
        }
    </script>
@endpush
