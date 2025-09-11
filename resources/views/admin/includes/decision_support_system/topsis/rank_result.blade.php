<x-modal.base id="rank-result-step-modal">
    <x-slot:title>Perhitungan Rangking <sub>(akan di rangking dari hasil)</sub></x-slot:title>
    <x-slot:body>
        @foreach($employees as $employeeIndex => $employee)
            <div class="d-block">
                <div class="card">
                    <div class="card-body">
                        <h6>{{ $employee->user->name }}</h6>
                        <span class="formula">
                            V<sub>i</sub> = D<sub>i</sub><sup>-</sup> / D<sub>i</sub><sup>+</sup> + D<sub>i</sub><sup>-</sup>
                        </span>
                        <span class="d-block">
                            @php
                                $result = collect($results)->where('id', $employee->id)->first();

                                if (!$result) continue;
                            @endphp
                            V<sub>i</sub> = {{ $idealSolutionResults['negative'][$employeeIndex] }} / {{ $idealSolutionResults['positive'][$employeeIndex] }} + {{ $idealSolutionResults['negative'][$employeeIndex] }} = {{ $result['result'] }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </x-slot:body>

    <x-slot:customModalFooter></x-slot:customModalFooter>
</x-modal.base>
