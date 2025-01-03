<select
        id="{{ $id ?? "price_provider_instance" }}"
        name="{{ $name ?? "price_provider_instance_id" }}"
        class="form-control form-control-sm"
        @cannot('seat-industry.change_price_provider') disabled @endcannot
>
    @foreach(\Seat\HermesDj\Industry\Helpers\OrderHelper::filteredPriceProviders() as $instance)
        @if($instance->id == $instance_id ?? null)
            <option value="{{ $instance->id }}" selected>{{ $instance->name }}</option>
        @else
            <option value="{{ $instance->id }}">{{ $instance->name }}</option>
        @endif
    @endforeach
</select>