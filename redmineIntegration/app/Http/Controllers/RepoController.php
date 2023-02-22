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
    private function callRepo($integration, $type)
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData($integration, $type);
        try {
            return $baseRepo->CallRepo($repoData)->request();
        } catch (\Exception $e) {
            Log::error($e);
            throw new \Exception($e);
        }
    }

    /**
     * @throws \Exception
     */
    public function get_projects()
    {
        return $this->callRepo('redmine.url', 'projects');
    }

    /**
     * @throws \Exception
     */
    public function get_issues()
    {
        return $this->callRepo('redmine.url', 'issues');
    }

    public function get_agile_info()
    {
        return $this->callRepo('redmine.url', 'agile_data');
    }

    public function get_users()
    {
        return $this->callRepo('redmine.url', 'users');
    }

    public function get_time_entries()
    {
        return $this->callRepo('redmine.url', 'time_entries');
    }

    public function get_related_issues()
    {
        return $this->callRepo('redmine.url', 'issues');//('issues/'.$data['issue_id'].'/relations', $data);
    }

    public function get_statuses()
    {
        return $this->callRepo('redmine.url', 'issue_statuses');
    }

    public function update_issue()
    {
        return $this->callRepo('redmine.url', 'issues');//('issues/'.$issue_id, ['format' => $format], "PUT", $post_data);
    }
}
