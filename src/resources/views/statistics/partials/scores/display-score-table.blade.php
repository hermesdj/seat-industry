<div class="card">
    <div class="card-body">
        <div class="card-subtitle mb-2 text-muted">{{$title}}</div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{trans('seat-industry::stats.scoreboard.headers.name')}}</th>
                <th scope="col" class="text-center">{{$scoreHeader}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rows as $row)
                <tr>
                    <td>
                        @if($loop->index <= 2)
                            @if($loop->index == 0)
                                <i class="fas fa-trophy" style="color: gold;"></i>
                            @elseif($loop->index == 1)
                                <i class="fas fa-trophy" style="color: silver;"></i>
                            @elseif($loop->index == 2)
                                <i class="fas fa-trophy" style="color: #ff5733;"></i>
                            @endif
                        @endif
                        #{{$loop->index + 1}}
                    </td>
                    <td>@include("web::partials.character",["character"=>$row->user->main_character ?? null])</td>
                    <td class="text-center">
                        @if($row->text)
                            {{$row->text}}
                        @else
                            {{$row->value}}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>