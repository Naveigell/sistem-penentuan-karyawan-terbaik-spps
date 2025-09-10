@extends('layouts.admin.admin')

@section('content-title', 'Criteria')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Criteria</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.criteria.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Criterion</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-2">Name</th>
                            <th class="col-2">Weight</th>
                            <th class="col-2">Type</th>
                            <th class="col-2">Value Type</th>
                            <th class="col-2">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($criteria as $criterion)
                            <tr>
                                <td>
                                    <x-iterate :pagination="$criteria" :loop="$loop"></x-iterate>
                                </td>
                                <td>{{ $criterion->name }}</td>
                                <td>{{ $criterion->weight }}</td>
                                <td>{!! $criterion->type->toHtmlBadge() !!}</td>
                                <td>{!! $criterion->value_type->toHtmlBadge() !!}</td>
                                <td>
                                    <a href="{{ route('admin.criteria.edit', $criterion) }}" class="btn btn-warning"><i class="fa fa-pen"></i></a>
                                    <button class="btn btn-danger btn-action trigger--modal-delete cursor-pointer" data-url="{{ route('admin.criteria.destroy', $criterion) }}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">Data Empty</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $criteria->links() }}
            </div>
        </div>
    </div>
@endsection

@section('content-modal')
    <x-modal.delete :name="'Criteria'"></x-modal.delete>
@endsection
