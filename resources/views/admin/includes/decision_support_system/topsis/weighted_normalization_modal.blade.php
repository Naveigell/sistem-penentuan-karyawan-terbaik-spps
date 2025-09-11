<x-modal.base id="weighted-normalization-step-modal">
    <x-slot:title>Perhitungan Normalisasi dengan Bobot Kriteria</x-slot:title>
    <x-slot:body>
        @foreach($employees as $employee)
            <div class="d-block">
                <div class="card">
                    <div class="card-body">
                        <h6>{{ $employee->user->name }}</h6>
                        @foreach($normalizations[$employee->id] as $index => $normalization)
                            @php
                                $criterion = $criteria[$index];
                            @endphp
                            <span>{{ $normalization }} x {{ $criterion ? $criterion->weight : 'undefined' }} = {{ $normalization * ($criterion ? $criterion->weight : 0) }}</span>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </x-slot:body>

    <x-slot:customModalFooter></x-slot:customModalFooter>
</x-modal.base>
