@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if (Auth::user()->user_type == 'student')
            <div class="card">
                <div class="card-header">
                    Available assignments
                </div>
                <div class="card-body">
                    @if (isset($assignments) && count($assignments) > 0)
                        <div class="table-responsive">
                            <table
                                class="table table-striped-columns
                        table-hover
                        table-bordered
                        table-info
                        align-middle">
                                <thead class="table-light">
                                    <caption>Available assignments</caption>
                                    <tr>
                                        <th class="text-nowrap">Due date</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Score</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($assignments as $item)
                                        {{ $item }}
                                        <tr class="table-light">
                                            <td class="text-nowrap" scope="row">
                                                {{ date('jS M Y', strtotime($item->due_date)) }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ Str::words($item->description, 50) }}</td>
                                            <td>{{ $item->grade == null ? 'Not graded' : $item->grade->grade }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <i class="bi bi-eye btn btn-info" id="viewAssignment"
                                                        assignment-id="{{ $item->id }}"></i>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="bg-white rounded shadow">
                            <div class="p-3">No assignments</div>
                        </div>
                    @endif
                </div>
            </div>
        @else
        @endif

        <div class="modal" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="myModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"></h5>
                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close" id="modalClose">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="dueDate"></div>
                        <div id="assignmentDesc" class="mb-3"></div>
                        <form action="{{ route('assignment.submit') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="attachments">Attach file</label>
                                <input type="hidden" name="assignment_id" value="" id="assignmentId">
                                <input id="attachment" class="form-control" type="file" value=""
                                    name="attachment_file">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <script type="module">
        $(function() {
            let viewAssignmentButtons = document.querySelectorAll('#viewAssignment');
            viewAssignmentButtons.forEach((element) => {
                element.addEventListener('click', (e) => {
                    console.log(element.getAttribute('assignment-id'));
                    $('#myModal').show();
                    axios.get('/assignment/' + element.getAttribute('assignment-id') + '/view')
                        .then((res) => {
                            var dueDate = res.data.due_date;
                            var formattedDate = new Date(dueDate).toLocaleDateString('en', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });
                            $('#dueDate').html('<p>Due date: ' + formattedDate + '</p>');
                            $("#staticBackdropLabel").text(res.data.title);
                            $("#assignmentDesc").text(res.data.description);
                            $("#assignmentId").val(res.data.id);
                        }).catch((err) => {
                            console.log(err);
                        });

                    $("#modalClose").click(function() {
                        $('#myModal').hide();
                    });

                });
            });
        });
    </script>
@endsection
