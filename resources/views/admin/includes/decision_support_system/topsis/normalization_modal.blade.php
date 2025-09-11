<x-modal.base id="normalization-step-modal">
    <x-slot:title>Normalization Step</x-slot:title>
    <x-slot:body>
        @foreach($criteria as $index => $criterion)
            <div class="d-block">
                <div class="card">
                    <div class="card-body">
                        <h6>{{ $criterion->name }} ({{ $criterion->alphabet() }})</h6>
                        @foreach($employees as $employee)
                            @if($criterion->value_type->isOption())
                                @php
                                    $value = optional(optional($employee->criteriaOptions->where('criteria_id', $criterion->id)->first())->criteriaOption)->value;
                                @endphp
                                <span>{{ $value }} / {{ $averages[$index] }} = {{ round($value / $averages[$index], $precision) }}</span>
                            @else
                                @php
                                    $value = optional($employee->criteriaValues->where('criteria_id', $criterion->id)->first())->value;
                                @endphp
                                <span>{{ $value }} / {{ $averages[$index] }} = {{ round($value / $averages[$index], $precision) }}</span>
                            @endif
                                <br>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </x-slot:body>

    <x-slot:customModalFooter></x-slot:customModalFooter>
</x-modal.base>
