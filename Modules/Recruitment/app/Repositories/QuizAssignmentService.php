<?php

namespace Modules\Recruitment\Services;

use Illuminate\Support\Facades\DB;
use Modules\Recruitment\Models\Quiz\Quizes;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Models\McqTestCandidate;

use Modules\Recruitment\Services\Interfaces\IQuizAssignmentService;

class QuizAssignmentService implements IQuizAssignmentService
{
    /**
     * Assign a quiz to a candidate
     *
     * @param int $quizId
     * @param int $candidateId
     * @param array $data
     * @return McqTestCandidate
     */
    public function assignQuizToCandidate($quizId, $candidateId, $data = [])
    {
        $quiz = Quizes::findOrFail($quizId);
        $candidate = CandidateUser::findOrFail($candidateId);

        // Check if assignment already exists
        $existingAssignment = McqTestCandidate::where('quiz_id', $quizId)
            ->where('candidate_id', $candidateId)
            ->first();

        if ($existingAssignment) {
            // Update existing assignment
            $existingAssignment->update([
                'status' => $data['status'] ?? $existingAssignment->status,
                'notes' => $data['notes'] ?? $existingAssignment->notes,
                'assigned_at' => $data['assigned_at'] ?? $existingAssignment->assigned_at ?? now(),
            ]);

            return $existingAssignment;
        }

        // Create new assignment
        return McqTestCandidate::create([
            'quiz_id' => $quizId,
            'candidate_id' => $candidateId,
            'status' => $data['status'] ?? 'pending',
            'assigned_at' => $data['assigned_at'] ?? now(),
            'notes' => $data['notes'] ?? null,
        ]);
    }

    /**
     * Assign a quiz to multiple candidates
     *
     * @param int $quizId
     * @param array $candidateIds
     * @param array $data
     * @return array
     */
    public function assignQuizToMultipleCandidates($quizId, $candidateIds, $data = [])
    {
        $results = [];
        $errors = [];

        foreach ($candidateIds as $candidateId) {
            try {
                $assignment = $this->assignQuizToCandidate($quizId, $candidateId, $data);
                $results[] = $assignment;
            } catch (\Exception $e) {
                $errors[] = [
                    'candidate_id' => $candidateId,
                    'error' => $e->getMessage()
                ];
            }
        }

        return [
            'success' => $results,
            'errors' => $errors
        ];
    }

    /**
     * Update the status of a quiz assignment
     *
     * @param int $assignmentId
     * @param string $status
     * @param array $data
     * @return QuizCandidateAssignment
     */
    public function updateAssignmentStatus($assignmentId, $status, $data = [])
    {
        $assignment = McqTestCandidate::findOrFail($assignmentId);

        $updateData = [
            'status' => $status,
        ];

        if ($status === 'completed') {
            $updateData['completed_at'] = now();
        }

        if (isset($data['notes'])) {
            $updateData['notes'] = $data['notes'];
        }

        $assignment->update($updateData);

        return $assignment;
    }

    /**
     * Get all assignments for a quiz
     *
     * @param int $quizId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAssignmentsForQuiz($quizId)
    {
        return McqTestCandidate::with('candidateUser')
            ->where('quiz_id', $quizId)
            ->get();
    }

    /**
     * Get all assignments for a candidate
     *
     * @param int $candidateId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAssignmentsForCandidate($candidateId)
    {
        return McqTestCandidate::with('quiz')
            ->where('candidate_id', $candidateId)
            ->get();
    }

    /**
     * Delete a quiz assignment
     *
     * @param int $assignmentId
     * @return bool
     */
    public function deleteAssignment($assignmentId)
    {
        $assignment = McqTestCandidate::findOrFail($assignmentId);
        return $assignment->delete();
    }
}
