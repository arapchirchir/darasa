<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use App\Models\StudentSubmissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    function index()
    {
        return view('home');
    }

    function Assignments()
    {
        $assignments = Assignments::where(['user_id' => Auth::user()->id])->get();
        return view('teachers.assignments', ['assignments' => $assignments]);
    }

    function StoreAssignment(Request $request)
    {
        $request->validate([
            'due_date' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        $data = [
            'user_id' => Auth::user()->id,
            'due_date' => $request->due_date,
            'title' => $request->title,
            'description' => $request->description,
        ];

        $stored = Assignments::create($data);
        if ($stored) {
            return redirect()->route('assignments');
        }
    }

    function ViewAssignment($id)
    {
        $assignment = Assignments::findOrFail($id);
        $submissions = StudentSubmissions::where(['assignments_id' => $assignment->id])->with(['user', 'assignment'])->get();
        return view('teachers.assignment')->with(['assignment' => $assignment, 'submissions' => $submissions]);
    }
}
