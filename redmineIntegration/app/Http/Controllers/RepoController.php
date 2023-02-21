<?php

namespace App\Http\Controllers;

use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class RepoController extends Controller
{
    private function generateRepoData(string $endpoint, string $method = "GET", $post_data, $data, $issue_id, string $format = 'json')
    {
        return [
            'integration' => 'redmine.url',
            'endpoint' => $endpoint,
            'params' => ['some params'],
            'method' => $method,
            'post_data' => $post_data,
            'data' => $data,
            'issue_id' => $issue_id,
            'format' => $format,
        ];
    }

    public function getProjects()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('projects', 'GET', [1], ['data' => [1]], 1);
        return $baseRepo->CallRepo($repoData)->get_projects();
    }

    public function getIssues()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('issues', 'GET', [1], ['data' => [1]], 222);
        return $baseRepo->CallRepo($repoData)->get_issues();
    }

    public function getAgileInfo()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('issues', 'GET', [1], ['issue_id' => [39016]], 222);
        return $baseRepo->CallRepo($repoData)->get_issues();
    }

    public function getUsers()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('users', 'GET', [1], ['issue_id' => [39016]], 222);
        return $baseRepo->CallRepo($repoData)->get_users();
    }

    public function getTimeEntries()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('time_entries', 'GET', [1], ['issue_id' => [39016]], 222);
        return $baseRepo->CallRepo($repoData)->get_users();
    }
}
