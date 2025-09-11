<x-modal.base id="ideal-solution-distance-step-modal">
    <x-slot:title>Ideal Solution Distance Step</x-slot:title>
    <x-slot:body>
        @foreach($employees as $employeeIndex => $employee)
            <div class="d-block">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $employee->user->name }}</h4>
                    </div>
                    <div class="card-body">
                        @foreach($idealSolutionResults as $key => $result)
                            <h6>{{ ucwords($key) }}</h6>
                            <span>√</span>
                            @foreach($weightedNormalizations[$employee->id] as $index => $normalization)
                                <span>({{ $normalization }} - {{ $idealSolutions[$key][$index] }})² </span>

                                @if($loop->last) = {{ $idealSolutionResults[$key][$employeeIndex] }} @else + @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </x-slot:body>

    <x-slot:customModalFooter></x-slot:customModalFooter>
</x-modal.base>
