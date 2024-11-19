@if(strlen($text)>($length ?? 20))
    @include("seat-industry::partials.tooltip",["tooltip"=>$text,"text"=>substr($text,0,($length ?? 20)) . "..."])
@else
    <span>{{ $text }}</span>
@endif