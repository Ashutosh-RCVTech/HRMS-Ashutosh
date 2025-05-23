<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Mail\NewCandidateMail;
use Modules\Recruitment\Mail\QuizInvitationMail;
use Modules\Recruitment\Models\CollegeCandidatePlacement;
use Modules\Recruitment\Models\Placement\Placements;
use Modules\Recruitment\Models\Quiz\Quizes;
use Modules\Recruitment\Models\McqTestCandidate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Modules\Recruitment\Models\CollegeCandidate;


class ImportCandidate implements ShouldQueue
{
    use Queueable;
    protected $validatedRows;
    protected $placement;
    protected $collegeId;

      /**
     * Create a new job instance.
     *
     * @param array $validatedRows
     * @param int|string $placement
     */
    public function __construct(array $validatedRows,$collegeId, $placement)
    {
        $this->validatedRows = $validatedRows;
        $this->placement = $placement;
        $this->collegeId = $collegeId;

     

        
      
      
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            foreach ($this->validatedRows as $row) {
                try {
                    // Check if the candidate exists by email.
                    $candidate = CandidateUser::where('email', $row['email'])->first();
                    $accountPassword = Str::random(10);
                    // If candidate does not exist, create a new candidate with a random account password.
                    if (!$candidate) {
                    
                        $candidate = CandidateUser::create([
                            'name'     => $row['name'],
                            'email'    => $row[ 'email'],
                            'password' => Hash::make($accountPassword),
                        ]);
    
                        // Send welcome email with the new candidate's details and account password.
                        Mail::to($candidate->email)->send(new NewCandidateMail($candidate, $accountPassword));
                    }
    
                    // Generate a random quiz password for the assignment.
               
    
                    $collegeCandidateId = CollegeCandidate::where('candidate_id', $candidate->id)
                    ->where('college_id',  $this->collegeId )->first();
                    // Create the quiz assignment for the candidate.
                    Log::info(   $collegeCandidateId );
                    if(!$collegeCandidateId ) {
                        $collegeCandidateId= CollegeCandidate::create([
                            'candidate_id' => $candidate->id,
                            'college_id'      =>  $this->collegeId,
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ]);
                    }

                    $collegeCandidatePlacementId=CollegeCandidatePlacement::
                    where('college_candidate_id',$collegeCandidateId->id)
                    ->where('placement_id',$this->placement)->first();

                    Log::info(  $collegeCandidatePlacementId);
                    if(!$collegeCandidatePlacementId){
                        CollegeCandidatePlacement::create([
                            'college_candidate_id'=>$collegeCandidateId->id,
                            'placement_id'=>$this->placement,
                            'created_at' => now(),
                            'updated_at'=> now()
                         ]);

                    }
                   
    
                    // Retrieve the quiz details.
                    $placement = Placements::find($this->placement);

                    Log::info($placement);
    
                    // Send quiz invitation em
                    // ail to the candidate.
                   
                   
                    Mail::to($candidate->email)->send(new QuizInvitationMail($candidate, $placement));
                
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
