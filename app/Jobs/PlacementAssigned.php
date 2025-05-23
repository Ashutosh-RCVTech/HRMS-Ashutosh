<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Modules\Recruitment\Models\CollegeCandidatePlacement;
use Modules\Recruitment\Mail\QuizInvitationMail;
use Modules\Recruitment\Models\CollegeCandidate;
use Modules\Recruitment\Models\Placement\Placements;
use Modules\Recruitment\Models\CandidateUser;
use Illuminate\Support\Facades\Log;

class PlacementAssigned implements ShouldQueue
{
    use Queueable;

    protected $candidates;
    protected $placementId;

    protected $collegeId;

    /**
     * Create a new job instance.
     *
     * @param array $candidates
     * @param int|string $placementId
     */
    public function __construct(array $candidates, $placementId, $collegeId)
    {
        $this->candidates = $candidates;
        $this->placementId = $placementId;
        $this->collegeId = $collegeId;

        // foreach ($this->candidates as $row) {

        //     $collegeCandidate = CollegeCandidate::where('candidate_id', $row['id'])
        //                 ->where('college_id', $this->collegeId)->first();
        //                 $candidate = CandidateUser::find($row['id']);
        //                 dd($candidate);

        // }


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            foreach ($this->candidates as $row) {
                try {


                    // Generate a random quiz password for the assignment.


                    $collegeCandidate = CollegeCandidate::where('candidate_id', $row['id'])
                        ->where('college_id', $this->collegeId)->first();
                    $candidate = CandidateUser::find($row['id']);
                    // Create the quiz assignment for the candidate.
                    if (!$collegeCandidate) {
                       $collegeCandidate=  CollegeCandidate::create([
                            'candidate_id' => $candidate->id,
                            'college_id' => $this->collegeId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    $collegeCandidatePlacementId = CollegeCandidatePlacement::where('college_candidate_id', $collegeCandidate->id)
                        ->where('placement_id', $this->placementId)->first();

                    Log::info($collegeCandidatePlacementId);
                    if (!$collegeCandidatePlacementId) {
                        CollegeCandidatePlacement::create([
                            'college_candidate_id' => $collegeCandidate->id,
                            'placement_id' => $this->placementId,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }


                    // Retrieve the quiz details.
                    $placement = Placements::find($this->placementId);

                    Log::info($placement);

                    // Send quiz invitation via email to the candidate.


                    Mail::to($row['email'])->send(new QuizInvitationMail($candidate, $placement));

                    Log::info($placement);
                } catch (\Exception $e) {
                    // Log the error for this specific row and continue processing the next rows.
                    Log::error("Error processing candidate with email {$row['email']}: " . $e->getMessage(), ['exception' => $e]);
                    continue;
                }
            }
        } catch (\Exception $e) {
            // Log any global errors that occur during the import job.
            Log::error("Error in ImportCandidate job: " . $e->getMessage(), ['exception' => $e]);
        }
    }
}
