<?php

namespace app\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

class ClockifyRepository
{
    public function clockify_request($endpoint, $params = [])
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
            if ($params) {
                foreach ($params as $key => $param) {
                    $query_params[] = $key . '=' . $param;
                }
            }

            $query_params = implode('&', $query_params);
            $res = $client->request("GET", $clockify_url . '/' . $endpoint . '?' . $query_params, $client_params);

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

    public function get_workspaces($data = [])
    {
        try {
            $response = $this->clockify_request('workspaces', $data);
            return $response;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_users($workspace_id, $data = [])
    {
        try {
            $response = $this->clockify_request('workspaces/' . $workspace_id . '/users', $data);
            return $response;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_projects($workspace_id, $data = [])
    {
        try {
            $response = $this->clockify_request('workspaces/' . $workspace_id . '/projects', $data);
            return $response;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_tasks($workspace_id, $project_id, $data = [])
    {
        try {
            $response = $this->clockify_request('workspaces/' . $workspace_id . '/projects/' . $project_id . '/tasks', $data);
            return $response;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_tags($workspace_id, $data = [])
    {
        try {
            $response = $this->clockify_request('workspaces/' . $workspace_id . '/tags', $data);
            return $response;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_time_entries($workspace_id, $user_id, $data = [])
    {
        try {
            $response = $this->clockify_request('workspaces/' . $workspace_id . '/user/' . $user_id . '/time-entries', $data);
            return $response;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }
}
