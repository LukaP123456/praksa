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

    public function getProjects()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('redmine.url', 'projects');
        try {
            return $baseRepo->CallRepo($repoData)->request();
        } catch (\Exception $e) {
            Log::error($e);
            throw new \Exception($e);
        }
    }

    public function getIssues()
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData('redmine.url', 'issues');
        try {
            return $baseRepo->CallRepo($repoData)->request();
        } catch (\Exception $e) {
            Log::error($e);
            throw new \Exception($e);
        }
    }

    public function getAgileInfo()
    {
        $baseRepo = new BaseRepository();
        $repoData = [
            'integration' => 'redmine.url',
            'endpoint' => 'issues',
            'params' => ['some params'],
            'method' => 'GET',
            'post_data' => [1],
            'data' => ['issue_id' => [39016]],
            'issue_id' => 222,
            'format' => 'json',
        ];
        return $baseRepo->CallRepo($repoData)->get_issues();
    }

    public function getUsers()
    {
        $baseRepo = new BaseRepository();
        $repoData = [
            'integration' => 'redmine.url',
            'endpoint' => 'issues',
            'params' => ['some params'],
            'method' => 'GET',
            'post_data' => [1],
            'data' => ['issue_id' => [39016]],
            'issue_id' => 222,
            'format' => 'json',
        ];
        return $baseRepo->CallRepo($repoData)->get_issues();
    }
}
