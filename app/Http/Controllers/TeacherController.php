<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use App\Models\Grading;
use App\Models\StudentSubmissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    // Teacher Dashboard
    function index()
    {
        return view('home');
    }

    // Teacher view asignment
    function Assignments()
    {
        $assignments = Assignments::where(['user_id' => Auth::user()->id])->get();
        return view('teachers.assignments', ['assignments' => $assignments]);
    }

    // Teacher stores assignment
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

    // Teacher view thei assgnment
    function ViewAssignment($id)
    {
        $assignment = Assignments::findOrFail($id);
        $submissions = StudentSubmissions::where(['assignments_id' => $assignment->id])->with(['user', 'assignment','grading'])->get();
        return view('teachers.assignment')->with(['assignment' => $assignment, 'submissions' => $submissions]);
    }

    function AwardAssignment(Request $request)
    {
        $request->validate([
            'awarded_mark' => 'required',
            'assignment_id' => 'required',
            'student_id' => 'required',
            'comments' => 'required',
        ]);

        $data = [
            'user_id' => $request->student_id,
            'comments' => $request->comments,
            'assignments_id' => $request->assignment_id,
            'grade' => $request->awarded_mark,
        ];

        $graded = Grading::create($data);

        if ($graded) {
            return response()->json(['message' => 'Graded successfully'], 200);
        } else {
            return response()->json(['message' => 'An error occurred'], 412);
        }
    }
}
