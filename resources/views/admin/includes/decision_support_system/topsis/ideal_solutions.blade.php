<x-modal.base id="ideal-solution-step-modal">
    <x-slot:title>Perhitungan Solusi Ideal</x-slot:title>
    <x-slot:body>
        @foreach($idealSolutions as $key => $idealSolution)
            <div class="d-block">
                <div class="card">
                    <div class="card-body">
                        <h6>{{ ucwords($key) }}</h6>
                        @foreach($criteria as $index => $criterion)
                            @if($criterion->type->isBenefit() && $key == 'positive')
                                <span class="d-block">{{ $criterion->name }} ({{ $criterion->alphabet() }}) = max({{ $criterion->name }}) = {{ $idealSolution[$index] }}</span>
                            @elseif($criterion->type->isBenefit() && $key == 'negative')
                                <span class="d-block">{{ $criterion->name }} ({{ $criterion->alphabet() }}) = min({{ $criterion->name }}) = {{ $idealSolution[$index] }}</span>
                            @elseif($criterion->type->isCost() && $key == 'positive')
                                <span class="d-block">{{ $criterion->name }} ({{ $criterion->alphabet() }}) = min({{ $criterion->name }}) = {{ $idealSolution[$index] }}</span>
                            @elseif($criterion->type->isCost() && $key == 'negative')
                                <span class="d-block">{{ $criterion->name }} ({{ $criterion->alphabet() }}) = max({{ $criterion->name }}) = {{ $idealSolution[$index] }}</span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </x-slot:body>

    <x-slot:customModalFooter></x-slot:customModalFooter>
</x-modal.base>
