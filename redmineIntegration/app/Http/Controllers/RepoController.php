<?php

namespace App\Http\Controllers;

use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RepoController extends Controller
{
    private function generateRepoData($integration, $endpoint, $method = "GET", $params = [], $post_data = [], $data = [], $issue_id = 0, $format = 'json'): array
    {
        return [
            'integration' => $integration,
            'endpoint' => $endpoint,
            'method' => $method,
            'params' => $params,
            'post_data' => $post_data,
            'data' => $data,
            'issue_id' => $issue_id,
            'format' => $format,
        ];
    }

    /**
     * @throws \Exception
     */
    private function CallRepo($baseRepo, $repoData)
    {
        try {
            return $baseRepo->CallRepo($repoData)->request();
        } catch (\Exception $e) {
            Log::error($e);
            throw new \Exception($e);
        }
    }

    public function get_projects()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('redmine.url', 'projects');
        $this->CallRepo($baseRepo, $repoData);
    }

    public function get_issues()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('redmine.url', 'issues');
        $this->CallRepo($baseRepo, $repoData);
    }

    public function get_agile_info()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('redmine.url', 'get_agile_info');
        $this->CallRepo($baseRepo, $repoData);
    }

    public function get_users()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('redmine.url', 'users');
        $this->CallRepo($baseRepo, $repoData);
    }

    public function get_time_entries()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('redmine.url', 'time_entries');
        $this->CallRepo($baseRepo, $repoData);
    }

    public function get_related_issues()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('redmine.url', 'time_entries');
        $this->CallRepo($baseRepo, $repoData);
    }

    public function get_statuses()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('redmine.url', 'issue_statuses');
        $this->CallRepo($baseRepo, $repoData);
    }

    public function update_issue()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('redmine.url', 'issue_statuses');
        $this->CallRepo($baseRepo, $repoData);
    }
}
