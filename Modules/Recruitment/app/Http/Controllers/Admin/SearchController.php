<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Recruitment\Models\JobOpening;
use Modules\Recruitment\Models\CandidateUser;
use Modules\Recruitment\Models\College;
use Modules\Recruitment\Models\Client;
use Modules\Recruitment\Models\JobApplication;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->get('q');
        $results = [
            'jobs' => [],
            'candidates' => [],
            'colleges' => [],
            'clients' => [],
            'applications' => []
        ];

        if (strlen($searchTerm) >= 2) {
            // Search Jobs
            $results['jobs'] = JobOpening::where('title', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%")
                ->limit(5)
                ->get()
                ->map(function ($job) {
                    return [
                        'type' => 'job',
                        'id' => $job->id,
                        'title' => $job->title,
                        'subtitle' => $job->client->name ?? 'No Client',
                        'url' => route('admin.jobs.show', $job->id),
                        'icon' => 'briefcase'
                    ];
                });

            // Search Candidates
            $results['candidates'] = CandidateUser::where('name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%")
                ->limit(5)
                ->get()
                ->map(function ($candidate) {
                    return [
                        'type' => 'candidate',
                        'id' => $candidate->id,
                        'title' => $candidate->name,
                        'subtitle' => $candidate->email,
                        'url' => route('admin.candidates.show', $candidate->id),
                        'icon' => 'user'
                    ];
                });

            // Search Colleges
            $results['colleges'] = College::where('name', 'like', "%{$searchTerm}%")
                ->orWhere('location', 'like', "%{$searchTerm}%")
                ->limit(5)
                ->get()
                ->map(function ($college) {
                    return [
                        'type' => 'college',
                        'id' => $college->id,
                        'title' => $college->name,
                        'subtitle' => $college->location,
                        'url' => route('admin.colleges.show', $college->id),
                        'icon' => 'academic-cap'
                    ];
                });

            // Search Clients
            $results['clients'] = Client::where('name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%")
                ->limit(5)
                ->get()
                ->map(function ($client) {
                    return [
                        'type' => 'client',
                        'id' => $client->id,
                        'title' => $client->name,
                        'subtitle' => $client->email,
                        'url' => route('admin.clients.show', $client->id),
                        'icon' => 'office-building'
                    ];
                });

            // Search Job Applications
            $results['applications'] = JobApplication::with(['candidate', 'job'])
                ->whereHas('candidate', function ($candidateQuery) use ($searchTerm) {
                    $candidateQuery->where('name', 'like', "%{$searchTerm}%");
                })
                ->orWhereHas('job', function ($jobQuery) use ($searchTerm) {
                    $jobQuery->where('title', 'like', "%{$searchTerm}%");
                })
                ->limit(5)
                ->get()
                ->map(function ($application) {
                    return [
                        'type' => 'application',
                        'id' => $application->id,
                        'title' => $application->candidate->name ?? 'Unknown Candidate',
                        'subtitle' => $application->job->title ?? 'Unknown Job',
                        'url' => route('admin.job-applications.show', $application->id),
                        'icon' => 'document-text'
                    ];
                });
        }

        return response()->json([
            'query' => $searchTerm,
            'results' => $results
        ]);
    }
}