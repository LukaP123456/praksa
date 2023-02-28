<?php

namespace App\Jobs;

use App\Http\Controllers\RepoController;
use App\Models\Issues;
use App\Models\Projects;
use App\Repositories\BaseRepository;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompareData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $repoController = new RepoController();
        $apiDataProjects = $repoController->callRepo(
            'redmine.url',
            'projects',
            'json',
            'GET',
            [
                'paginate' => 1
            ]
        );

        $apiDataIssues = $repoController->callRepo(
            'redmine.url',
            'issues',
            'json',
            'GET',
            [
                'paginate' => 1
            ]
        );
        info($apiDataProjects);

        for ($i = 0; $i < count($apiDataProjects); $i++) {
            info($apiDataProjects[$i]['id']);
            $Data = Projects::firstOrNew(
                ['redmine_id' => $apiDataProjects[$i]['id']],
                [
                    'redmine_id' => $apiDataProjects[$i]['id'],
                    'name' => $apiDataProjects[$i]['name'],
                    'created_at' => $apiDataProjects[$i]['created_on'],
                    'updated_at' => $apiDataProjects[$i]['updated_on'],
                ]
            );
            $Data->save();
        }

//        for ($i = 0; $i < count($apiDataIssues); $i++) {
//            info($apiDataIssues[$i]['id']);
//
//            $assignee_id = $response[$i]['assigned_to']['id'] ?? null;
//            $assignee = $response[$i]['assigned_to']['name'] ?? null;
//
//            $Data = Issues::firstOrNew(
//                ['redmine_id' => $apiDataIssues[$i]['id']],
//                [
//                    'redmine_id' => $apiDataIssues[$i]['id'],
//                    'project_id' => $apiDataIssues[$i]['project']['id'],
//                    'tracker_id' => $apiDataIssues[$i]['tracker']['id'],
//                    'tracker' => $apiDataIssues[$i]['tracker']['name'],
//                    'title' => $apiDataIssues[$i]['subject'],
//                    'description' => $apiDataIssues[$i]['description'],
//                    'assignee_id' => $assignee_id,
//                    'assignee' => $assignee,
//                    'created_at' => now(),
//                    'updated_at' => null,
//                ]
//            );
//            $Data->save();
//        }
//
//        info($Data);

    }
}
