<select id="{{ $id ?? "deliverToId" }}" name="{{ $name ?? "deliverToName" }}"
        class="form-control">
    @foreach(auth()->user()->characters as $character)
        @if($character->character_id == $character_id ?? null)
            <option value="{{ $character->character_id }}" selected>{{ $character->name }}</option>
        @else
            <option value="{{ $character->character_id }}">{{ $character->name }}</option>
        @endif
    @endforeach
</select>
