<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use App\Models\StudentSubmissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    function index()
    {
        $assignments = Assignments::paginate(20);
        return view('home')->with(['assignments' => $assignments]);
    }

    function GetAssignment($id)
    {
        $assignment = Assignments::findOrFail($id);
        return $assignment;
    }

    function SubmitAssignment(Request $request)
    {
        $request->validate(['attachment_file' => 'required', 'assignment_id' => 'required']);
        if ($attached = $request->file('attachment_file')) {
            $name = $attached->hashName();
            $attached->storeAs('assignments', $name, 'public');

            $data = [
                'assignments_id' => $request->assignment_id,
                'user_id' => Auth::user()->id,
                'upload_file' => $name,
            ];

            StudentSubmissions::create($data);
            return redirect()->back();
        }
    }
}
