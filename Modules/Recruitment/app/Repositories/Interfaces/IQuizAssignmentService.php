<?php

namespace Modules\Recruitment\Services\Interfaces;

use Modules\Recruitment\Models\McqTestCandidate;

interface IQuizAssignmentService
{
    /**
     * Assign a quiz to a candidate
     *
     * @param int $quizId
     * @param int $candidateId
     * @param array $data
     * @return McqTestCandidate
     */
    public function assignQuizToCandidate($quizId, $candidateId, $data = []);

    /**
     * Assign a quiz to multiple candidates
     *
     * @param int $quizId
     * @param array $candidateIds
     * @param array $data
     * @return array
     */
    public function assignQuizToMultipleCandidates($quizId, $candidateIds, $data = []);

    /**
     * Update the status of a quiz assignment
     *
     * @param int $assignmentId
     * @param string $status
     * @param array $data
     * @return McqTestCandidate
     */
    public function updateAssignmentStatus($assignmentId, $status, $data = []);

    /**
     * Get all assignments for a quiz
     *
     * @param int $quizId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAssignmentsForQuiz($quizId);

    /**
     * Get all assignments for a candidate
     *
     * @param int $candidateId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAssignmentsForCandidate($candidateId);

    /**
     * Delete a quiz assignment
     *
     * @param int $assignmentId
     * @return bool
     */
    public function deleteAssignment($assignmentId);
} 