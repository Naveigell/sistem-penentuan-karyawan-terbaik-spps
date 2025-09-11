@extends('layouts.admin.admin')

@section('content-title', 'Kriteria')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <form action="{{ route('admin.employees.criteria.store', $employee) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4>Kriteria</h4>
                </div>
                <div class="card-body">
                    <div class="row container">
                        @foreach($criteria as $criterion)
                            <div class="form-group col-4">
                                <label for="">{{ ucwords($criterion->name) }}</label>
                                @if($criterion->value_type->isNominal())
                                    @php
                                        $value = optional($employee->criteriaValues->where('criteria_id', $criterion->id)->first())->value;
                                    @endphp
                                    <input type="text" class="form-control @error('criteria.' . $criterion->id) is-invalid @enderror" name="criteria[{{ $criterion->id }}]" value="{{ old('criteria.' . $criterion->id, $value) }}">
                                    @error('criteria.' . $criterion->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @elseif($criterion->value_type->isOption())
                                    @php
                                        $value = optional($employee->criteriaOptions->where('criteria_id', $criterion->id)->first())->criteria_option_id;
                                    @endphp
                                    <select name="criteria[{{ $criterion->id }}]" id="" class="form-control @error('criteria.' . $criterion->id) is-invalid @enderror">
                                        @foreach($criterion->options as $option)
                                            <option @if($option->id == old('criteria.' . $criterion->id, $value)) selected @endif value="{{ $option->id }}">{{ $option->label }}</option>
                                        @endforeach
                                    </select>
                                    @error('criteria.' . $criterion->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @else
                                    @php
                                        $value = optional($employee->criteriaValues->where('criteria_id', $criterion->id)->first())->value;
                                    @endphp
                                    <div class="row">
                                        <div class="col-10"><input type="range" class="form-control" min="{{ $criterion->range->min }}" max="{{ $criterion->range->max }}" value="{{ old('criteria.' . $criterion->id, $value) }}" name="criteria[{{ $criterion->id }}]" oninput="outputValue{{ $criterion->id }}.value = this.value"></div>
                                        <div class="col-2 d-flex justify-content-center align-items-center"><output id="outputValue{{ $criterion->id }}">{{ old('criteria.' . $criterion->id, $value) }}</output></div>
                                        <div class="col-12">
                                            <input type="hidden" class="form-control @error('criteria.' . $criterion->id) is-invalid @enderror">
                                            @error('criteria.' . $criterion->id)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content-modal')
    <x-modal.delete :name="'Karyawan'"></x-modal.delete>
@endsection
