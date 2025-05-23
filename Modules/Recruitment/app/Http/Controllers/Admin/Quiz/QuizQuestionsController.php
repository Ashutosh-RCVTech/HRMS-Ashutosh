<?php

namespace Modules\Recruitment\Http\Controllers\Admin\Quiz;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Models\ExamAttempt;
use Modules\Recruitment\Models\Quiz\Quizes;
use Modules\Recruitment\Models\Quiz\QuizCourses;
use Modules\Recruitment\Models\Quiz\QuizOptions;
use Modules\Recruitment\Models\Quiz\QuizQuestions;
use Modules\Recruitment\Models\Quiz\QuizCategories;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Date;

class QuizQuestionsController extends Controller
{
    public function index($id)
    {

        $quizes = Quizes::where("course_id", $id)->latest()->paginate(5);
        // dd("comes");
        return view('recruitment::admin.quiz.quizes.index', compact('quizes', 'id'));
    }

    public function create($id)
    {
        return view('recruitment::admin.quiz.quizes.create', compact('id'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'course_id' => 'required',
            'name' => 'required|string|max:255',
            'score' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'categories' => 'required|array|min:1',
            'categories.*.name' => 'required|string|max:255',
            'categories.*.questions' => 'required|array|min:1',
            'categories.*.questions.*.question' => 'required|string|max:500',
            'categories.*.questions.*.opt1' => 'required|string|max:255',
            'categories.*.questions.*.opt2' => 'required|string|max:255',
            'categories.*.questions.*.opt3' => 'required|string|max:255',
            'categories.*.questions.*.opt4' => 'required|string|max:255',
            'categories.*.questions.*.opt1_ans_status' => 'required',
            'categories.*.questions.*.opt2_ans_status' => 'required',
            'categories.*.questions.*.opt3_ans_status' => 'required',
            'categories.*.questions.*.opt4_ans_status' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $quiz = Quizes::create([
                'course_id' => $validatedData['course_id'],
                'name' => $validatedData['name'],
                'passing_marks' => $validatedData['passing_marks'],
                'marks' => $validatedData['score'],
                'duration' => $validatedData['duration'],

            ]);

            foreach ($validatedData['categories'] as $index => $categoryData) {
                $category = QuizCategories::create([
                    'quiz_id' => $quiz->id,
                    'name' => $categoryData['name'],
                    'active_status' => 1,
                ]);

                foreach ($categoryData['questions'] as $qIndex => $questionData) {
                    $question = QuizQuestions::create([
                        'category_id' => $category->id,
                        'question_text' => $questionData['question'],
                        'quiz_id' => $quiz->id,
                    ]);

                    $correctAnswers = 0;
                    $existingOptions = [];
                    foreach (['opt1', 'opt2', 'opt3', 'opt4'] as $optionKey) {
                        $optionValue = trim($questionData[$optionKey]);

                        if (in_array($optionValue, $existingOptions)) {
                            DB::rollBack();
                            return response()->json(['error' => ["categories.{$index}.questions.{$qIndex}" => "Each option must be unique."]], 422);
                        }

                        $existingOptions[] = $optionValue;
                        $isCorrect = isset($questionData["{$optionKey}_ans_status"]) && $questionData["{$optionKey}_ans_status"] === 'true';
                        if ($isCorrect) {
                            $correctAnswers++;
                        }

                        QuizOptions::create([
                            'question_id' => $question->id,
                            'option_text' => $questionData[$optionKey],
                            'is_correct' => $isCorrect ? 1 : 0,
                        ]);
                    }

                    if ($correctAnswers === 0) {
                        DB::rollBack();
                        return response()->json(['error' => ["categories.{$index}.questions.{$qIndex}" => "Each question must have at least one correct answer."]], 422);
                    }
                }
            }

            DB::commit();

            return response()->json(['success' => 'Quiz created successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function destroy($id)
    {
        $quiz = Quizes::find($id);
        Quizes::destroy($id);

        return redirect()->route('admin.quiz.quizes.index', $quiz->course_id)->with('success', 'Quiz deleted successfully.');
    }

    public function editQuizBasicInfo($id)
    {
        $quiz = Quizes::find($id);
        return view('recruitment::admin.quiz.quizes.editQuizBasicInfo', compact('quiz'));
    }

    public function updateQuizBasicInfo(Request $request)
    {

        $request->validate([
            'quiz_id' => 'required|exists:quizes,id',
            'name' => 'required|string|max:255',
            'score' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
        ]);

        $quiz = Quizes::find($request->quiz_id);
        $quiz->name = $request->name;
        $quiz->marks = $request->score;
        $quiz->duration = $request->duration;
        $quiz->passing_marks = $request->passing_marks;

        $quiz->save();

        return redirect()->route('admin.quiz.quizes.index', $quiz->course_id)->with('success', 'Quiz Updated successfully.');
    }

    public function show($id)
    {
        $quiz = Quizes::with(['categories.questions.options'])->findOrFail($id);


        return view('recruitment::admin.quiz.quizes.showQuiz', compact('quiz'));
    }

    public function updateCategoriesStatus($id)
    {
        $quiz_categories = QuizCategories::findOrFail($id);
        $quiz_categories->active_status = !$quiz_categories->active_status;
        $quiz_categories->save();

        return redirect()->back()->with('success', 'Status Changed successfully.');
    }

    public function createNewCategory($id)
    {
        return view('recruitment::admin.quiz.quizes.createnewQuizCategory', compact('id'));
    }

    public function storeNewCategory(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizes,id',
            'name' => 'required|string|max:255',
        ]);

        QuizCategories::create([
            'quiz_id' => $request->quiz_id,
            'name' => $request->name,
            'active_status' => 1,
        ]);

        return redirect()->route('admin.quiz.quizes.show', $request->quiz_id)->with('success', 'Category created successfully.');
    }

    public function editCategories(Request $request, $id)
    {
        $category = QuizCategories::findOrFail($id);
        return view('recruitment::admin.quiz.quizes.editQuizCategory', compact('category'));
    }

    public function updateCategories(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:quiz_categories,id',
            'name' => 'required|string|max:255',
        ]);

        $category = QuizCategories::findOrFail($request->category_id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.quiz.quizes.show', $category->quiz_id)->with('success', 'Category updated successfully.');
    }

    public function createNewQuestion($quizId = null, $categoryId = null)
    {
        //passing category id 
        return view('recruitment::admin.quiz.quizes.createNewQuestion', compact('quizId', 'categoryId'));
    }

    public function storeNewQuestion(Request $request)
    {

        $request->validate([
            'category_id' => 'required|exists:quiz_categories,id',
            'question' => 'required|string|max:500',
            'options.*' => 'required|string|max:255',
            'correct_option.*' => 'required',
        ]);

        try {
            $question = QuizQuestions::create([
                'category_id' => $request->category_id,
                'question_text' => $request->question,
                'quiz_id' => $request->quiz_id,
            ]);

            foreach ($request->options as $index => $optionText) {
                QuizOptions::create([
                    'question_id' => $question->id,
                    'option_text' => $optionText,
                    'is_correct' => $request->correct_option[$index] && $request->correct_option[$index] == 'true' ? 1 : 0,
                ]);
            }
            return response()->json(['success' => 'Question added successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function editQuestion($id)
    {
        $question = QuizQuestions::with('options')->findOrFail($id);
        return view('recruitment::admin.quiz.quizes.editQuestion', compact('question'));
    }

    public function updateQuestion(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:quiz_questions,id',
            'question' => 'required|string|max:500',
            'options.*' => 'required|string|max:255',
            'correct_option.*' => 'required',
        ]);
        try {
            $question = QuizQuestions::findOrFail($request->question_id);
            $question->update(['question_text' => $request->question]);

            foreach ($question->options as $index => $option) {
                $option->update([
                    'option_text' => $request->options[$index],
                    'is_correct' => $request->correct_option[$index] && $request->correct_option[$index] == 'true' ? 1 : 0,
                ]);
            }

            return response()->json(['success' => 'Question upadated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function getExamResult(Request $request, $quizId, $status = 1)
    {
        $quiz = Quizes::find($quizId);

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }
        $perPage = $request->input('perPage', 15);
        $page = $request->input('page', 1);
        $quizPassingPercentage = $quiz->passing_marks;


        $examAttempts = ExamAttempt::where('quiz_id', $quizId)
            ->whereHas('candidate.candidateInfo') // Ensure both relations exist
            ->with('candidate.candidateInfo') // Fetch candidate & candidateInfo in one query
            ->when($status == 1, function ($query) use ($quizPassingPercentage) {
                return $query->where('score', '>=', $quizPassingPercentage);
            })
            ->when($status == 0, function ($query) use ($quizPassingPercentage) {
                return $query->where('score', '<', $quizPassingPercentage);
            })
            ->paginate($perPage, ['*'], 'page', $page);


        return view('recruitment::admin.quiz.quizes.showResult', compact('examAttempts', 'quizPassingPercentage'));
    }


    public function pdfExport(Request $request, $quizId, $status = 1)
    {
        $quiz = Quizes::find($quizId);

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $quizPassingPercentage = $quiz->passing_marks;

        // Retrieve 'perPage' and 'page' from request, with defaults
        $perPage = $request->input('perPage', 15);
        $page = $request->input('page', 1);

        // dd($perPage, $page);
        // Paginate exam attempts with specified perPage and page
        $examAttempts = ExamAttempt::where('quiz_id', $quizId)
            ->whereHas('candidate.candidateInfo')
            ->with('candidate.candidateInfo')
            ->when($status == 1, function ($query) use ($quizPassingPercentage) {
                return $query->where('score', '>=', $quizPassingPercentage);
            })
            ->when($status == 0, function ($query) use ($quizPassingPercentage) {
                return $query->where('score', '<', $quizPassingPercentage);
            })
            ->paginate($perPage, ['*'], 'page', $page);

        $statusText = $status == 1 ? 'Passed' : 'Failed';

        // Load the view with paginated data
        $pdf = Pdf::loadView('recruitment::admin.quiz.quizes.resultPdf', [
            'examAttempts' => $examAttempts,
            'statusText' => $statusText
        ]);

        return $pdf->download("quiz-results-$statusText-page-$page.pdf");
    }
}
