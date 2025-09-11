<x-modal.base id="average-step-modal">
    <x-slot:title>Perhitungan Rata - Rata</x-slot:title>
    <x-slot:body>
        @php
            $sum = 0;
        @endphp
        @foreach($criteria as $index => $criterion)
            <div class="d-block">
                @foreach($employees as $employee)
                    @if($criterion->value_type->isOption())
                        @php
                            $value = optional(optional($employee->criteriaOptions->where('criteria_id', $criterion->id)->first())->criteriaOption)->value;
                        @endphp
                        <td>{{ $value }}²</td>
                    @else
                        @php
                            $value = optional($employee->criteriaValues->where('criteria_id', $criterion->id)->first())->value;
                        @endphp
                        <td>{{ $value }}²</td>
                    @endif

                    @php
                        $sum += pow($value, 2);
                    @endphp

                    @if(!$loop->last)
                        +
                    @else
                        = √{{ $sum }} = {{ $averages[$index] }}
                    @endif
                @endforeach
            </div>
        @endforeach
    </x-slot:body>

    <x-slot:customModalFooter></x-slot:customModalFooter>
</x-modal.base>
