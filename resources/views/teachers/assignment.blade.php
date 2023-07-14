@extends('layouts.app')
@section('titile', 'Assignment')
@section('content')
    <div class="container-fluid">
        <div class="row g-3 py-2 bg-white mb-3">
            <div class="col-sm-6">
                <a href="{{ route('assignments') }}" class="btn btn-info"><i class="bi bi-arrow-return-left"></i></a><span
                    class="px-2">{{ $assignment->title }}</span>
            </div>
            <div class="col-sm-6">
                <div>{{ date('jS M Y', strtotime($assignment->due_date)) }}</div>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-12 bg-white p-3 rounded shadow">{{ $assignment->description }}</div>
        </div>
        @if (isset($submissions) && count($submissions) > 0)
            <div class="table-responsive">
                <table
                    class="table table-striped
            table-hover
            table-bordered
            table-primary
            align-botton">
                    <thead class="table-light">
                        <caption>Submissions</caption>
                        <tr>
                            <th>Student name</th>
                            <th>Title</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($submissions as $item)
                            <tr class="table-primary">
                                <td scope="row">{{ $item->user->name }}</td>
                                <td>{{ $item->assignment->title }}</td>
                                <td><i class="bi bi-cloud-arrow-down btn btn-success"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        @else
            <div class="bg-white">
                <div class="p-4"> <i class="bi bi-info-circle-fill"></i> No attempts on this assignment</div>
            </div>
        @endif
    </div>
@endsection
