<?php

namespace Modules\RedmineIntegration\Repositories;

use Validator;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GitlabRepository
{
    public function request($gitlab_api_key, $endpoint, $params = [], $method = "GET", $post_data = null)
    {
        $gitlab_url = config('redmineintegration.gitlab_url');
        $client = new Client();
        try {
            $client_params = [
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 30,
                'connect_timeout' => 30
            ];
            if ($post_data) {
                $client_params['body'] = json_encode($post_data);
            }
            $query_params = [];
            if ($params) {
                foreach ($params as $key => $param) {
                    $query_params[] = $key . '=' . $param;
                }
            }
            $query_params[] = 'private_token=' . $gitlab_api_key;
            $query_params = implode('&', $query_params);
            $res = $client->request($method, $gitlab_url.'/'.$endpoint. '?' . $query_params, $client_params);

            $response = json_decode($res->getBody(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            \Log::error($e);
            throw new \Exception($responseBodyAsString);
        } catch (\Exception $e) {
            \Log::error($e);
            throw new \Exception($e);
        }
        return $response;
    }

    public function get_projects($api_key, $data) {
        try {
            $response = $this->gitlab_request($api_key, 'projects', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }

    public function get_branches($api_key, $project_id, $data) {
        try {
            $response = $this->gitlab_request($api_key, 'projects/'. $project_id .'/repository/branches', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }

    public function get_merge_requests($api_key, $data) {
        try {
            $response = $this->gitlab_request($api_key, 'merge_requests', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }

    public function create_merge_request($api_key, $project_id, $data) {
        try {
            $response = $this->gitlab_request($api_key, 'projects/'. $project_id .'/merge_requests', [], 'POST', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }
}
