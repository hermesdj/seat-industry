@if($profileList->isEmpty())
    <div class="card-header">
        {{trans('seat-industry::profiles.list.empty', ['list' => $listTitle])}}
    </div>
@else
    <div class="card-header">
        <h6 class="text-muted">{{$listTitle}}</h6>
    </div>
    <ul class="list-group list-group-flush">
        @foreach($profileList as $profile)
            <a
                    @if($activeProfile && $activeProfile->id === $profile->id)
                        class="list-group-item list-group-item-action active"
                    aria-current="true"
                    @else
                        class="list-group-item"
                    @endif
                    href="{{route('seat-industry.profile', ['profile' => $profile->id])}}"
            >
                {{$profile->name}}
            </a>
        @endforeach
    </ul>
@endif