<?php

namespace Modules\Recruitment\Http\Controllers\Admin\Quiz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Models\Quiz\QuizCourses;

class QuizCoursesController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        $courses = QuizCourses::latest()->paginate(10);
        return view('recruitment::admin.quiz.course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('recruitment::admin.quiz.course.create');
    }

    /**
     * Store a newly created course in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        QuizCourses::create($validated + ['user_id' => auth()->id()]);

        return response()->json(['message' => 'Course created successfully.']);
    }


    /**
     * Show the form for editing the specified course.
     */
    public function edit(QuizCourses $course)
    {
        return view('recruitment::admin.quiz.course.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, QuizCourses $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return response()->json(['message' => 'Course updated successfully.']);
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(QuizCourses $course)
    {
        $course->delete();
        return redirect()->route('admin.quiz.courses.index')->with('success', 'Course deleted successfully.');
    }
}
