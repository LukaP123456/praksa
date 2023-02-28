<?php

namespace App\Http\Controllers;

use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\StreamInterface;

class RepoController extends Controller
{
    /**
     * Generates the array with all the data needed to instantiate a Repository class
     * @param $integration
     * @param $endpoint
     * @param $format
     * @param $method
     * @param $params
     * @param $post_data
     * @param $data
     * @param $issue_id
     * @return array
     */
    public function generateRepoData($integration, $endpoint, $format, $method, $params, $post_data, $data, $issue_id): array
    {
        return [
            'integration' => $integration,
            'endpoint' => $endpoint,
            'format' => $format,
            'method' => $method,
            'params' => $params,
            'post_data' => $post_data,
            'data' => $data,
            'issue_id' => $issue_id,
        ];
    }

    /**
     * Calls the wanted Repository class based on the $integration, temporarily $integration is just a string value like
     * redmine.url or clockify.url
     * The $baseRepo variable returns an instance of a class based on the $integration value
     *
     * @param $integration
     * @param $endpoint
     * @param $format
     * @param $method
     * @param $params
     * @param $post_data
     * @param $data
     * @param $issue_id
     * @return array|mixed|StreamInterface
     * @throws \Exception
     */
    public function callRepo($integration, $endpoint, $format = 'json', $method = "GET", $params = [], $post_data = [], $data = [], $issue_id = 0)
    {
        $baseRepo = new BaseRepository();
        $repoData = $this->generateRepoData($integration, $endpoint, $format, $method, $params, $post_data, $data, $issue_id);
        return $baseRepo->CallRepo($repoData)->repo_request();

//        try {
//        } catch (\Exception $e) {
//            Log::error($e);
//            throw new \Exception($e);
//        }
    }

    /**
     * @throws \Exception
     */
    public function get_projects()
    {
        return $this->callRepo(
            'redmine.url',
            'projects',
            'json',
            'GET',
            [
                'paginate' => 1
            ]
        );
    }

    /**
     * @throws \Exception
     */
    public function get_single_project(int $project_id)
    {
        return $this->callRepo(
            'redmine.url',
            'projects',
            'json',
            'GET',
            [
                'single' => $project_id,
                'trackers' => 'trackers',
                'issue_categories' => 'issue_categories',
            ]);
    }

    /**
     * @throws \Exception
     */
    public function get_trackers()
    {
        return $this->callRepo('redmine.url', 'trackers');
    }

    /**
     * 100 is the max number of issues it can return
     * Some issues don't have the assigned_to value
     * @throws \Exception
     */
    public function get_issues()
    {
        return $this->callRepo(
            'redmine.url',
            'issues',
            'json',
            'GET',
            [
                'paginate' => 1
            ]
        );
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
