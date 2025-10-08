@extends('layouts.admin.admin')

@section('content-title', 'Copeland')

@section('content-body')
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Copeland</h4>
                <div class="card-header-action">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#average-step-modal">Lihat Perhitungan</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Karyawan</th>
                            @foreach($criteria as $criterion)
                                <th>{{ $criterion->name }} ({{ $criterion->alphabet() }})</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->user->name }}</td>
                                @foreach($criteria as $criterion)
                                    @if($criterion->value_type->isOption())
                                        @php
                                            $value = optional(optional($employee->criteriaOptions->where('criteria_id', $criterion->id)->first())->criteriaOption)->value;
                                        @endphp
                                        <td>{{ $value }}</td>
                                    @else
                                        @php
                                            $value = optional($employee->criteriaValues->where('criteria_id', $criterion->id)->first())->value;
                                        @endphp
                                        <td>{{ $value }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Rangking</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Ranking</th>
                            <th>Karyawan</th>
                            <th>Hasil</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $result)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $result['name'] }}</td>
                                <td>{{ $result['total'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
