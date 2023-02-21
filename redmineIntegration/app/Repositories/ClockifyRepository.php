<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

class ClockifyRepository
{
    public string $endpoint;
    public array $params;
    public array $data;
    public int $workspace_id;
    public int $project_id;
    public int $user_id;

    /**
     * @param string $endpoint
     * @param array $params
     * @param array $data
     * @param int $workspace_id
     * @param int $project_id
     * @param int $user_id
     */
    public function __construct(string $endpoint, array $params, array $data, int $workspace_id, int $project_id, int $user_id)
    {
        $this->endpoint = $endpoint;
        $this->params = $params;
        $this->data = $data;
        $this->workspace_id = $workspace_id;
        $this->project_id = $project_id;
        $this->user_id = $user_id;
    }


    public function clockify_request()
    {
        $clockify_url = config('redmineintegration.clockify_url');
        $clockify_api_key = config('redmineintegration.clockify_api_key');

        $client = new Client();
        try {
            $client_params = [
                'headers' => ['Content-Type' => 'application/json', 'X-Api-Key' => $clockify_api_key],
                'timeout' => 30,
                'connect_timeout' => 30
            ];
            $query_params = [];
            if ($this->params) {
                foreach ($this->params as $key => $param) {
                    $query_params[] = $key . '=' . $param;
                }
            }

            $query_params = implode('&', $query_params);
            $res = $client->request("GET", $clockify_url . '/' . $this->endpoint . '?' . $query_params, $client_params);

            $response = json_decode($res->getBody(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            Log::error($e);
            $response = [];
        } catch (\Exception $e) {
            Log::error($e);
            $response = [];
        }
        return $response;
    }

    public function get_workspaces()
    {
        try {
            return $this->clockify_request('workspaces', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_users()
    {
        try {
            return $this->clockify_request('workspaces/' . $this->workspace_id . '/users', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_projects()
    {
        try {
            return $this->clockify_request('workspaces/' . $this->workspace_id . '/projects', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_tasks()
    {
        try {
            return $this->clockify_request('workspaces/' . $this->workspace_id . '/projects/' . $this->project_id . '/tasks', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_tags()
    {
        try {
            return $this->clockify_request('workspaces/' . $this->workspace_id . '/tags', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_time_entries()
    {
        try {
            return $this->clockify_request('workspaces/' . $this->workspace_id . '/user/' . $this->user_id . '/time-entries', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }
}
