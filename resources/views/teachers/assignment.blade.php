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
                                <td>
                                    <i class="bi bi-cloud-arrow-down btn btn-success"></i>
                                    <i class="bi bi-eye btn btn-info" id="viewAssignment"
                                        assignment-id="{{ $item->id }}" student-id="{{ $item->user->id }}"></i>
                                </td>
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

    <div class="modal" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close" id="modalClose">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('assignment.award') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="attachments">Award</label>
                            <input type="hidden" name="assignment_id" value="" id="assignmentId">
                            <input id="awardedMark" class="form-control" type="text" value="" name="awarded_mark">
                        </div>
                        <div class="form-group mb-3">
                            <label for="comments">Comments</label>
                            <textarea name="comments" id="commentMade" cols="" rows="" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info" id="submitAward">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script type="module">
        $(function() {
            let viewAssignmentButtons = document.querySelectorAll('#viewAssignment');
            viewAssignmentButtons.forEach((element) => {
                element.addEventListener('click', (e) => {
                    $("#assignmentId").val(element.getAttribute('assignment-id'))
                    let studentName = element.parentElement.parentElement.children[0].textContent;
                    $("#staticBackdropLabel").text(studentName);
                    $('#myModal').show();

                    $("#submitAward").click(function(e) {
                        e.preventDefault();
                        let data = {
                            student_id: element.getAttribute('student-id'),
                            assignment_id: element.getAttribute('assignment-id'),
                            awarded_mark: $("#awardedMark").val(),
                            comments: $("#commentMade").val(),
                        };

                        axios.post('/assignment/award', data)
                            .then((res) => {
                                console.log(res.status);
                                if (res.status === 200) {
                                    window.location.reload();
                                }
                            })
                            .catch((err) => {
                                console.log(err);
                            });

                    });

                    $("#modalClose").click(function() {
                        $('#myModal').hide();
                    });

                });
            });
        });
    </script>
@endsection
