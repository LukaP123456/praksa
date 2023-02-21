<?php

namespace app\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

class GitlabRepository
{
    public string $endpoint;
    public array $params;
    public string $method;
    public array $post_data;
    public $data;
    public $gitlab_api_key;
    public $api_key;
    public int $project_id;

    /**
     * @param string $endpoint
     * @param array $params
     * @param string $method
     * @param array $post_data
     * @param $data
     * @param $gitlab_api_key
     * @param $api_key
     * @param int $project_id
     */
    public function __construct(string $endpoint, array $params, string $method, array $post_data, $data, $gitlab_api_key, $api_key, int $project_id)
    {
        $this->endpoint = $endpoint;
        $this->params = $params;
        $this->method = $method;
        $this->post_data = $post_data;
        $this->data = $data;
        $this->gitlab_api_key = $gitlab_api_key;
        $this->api_key = $api_key;
        $this->project_id = $project_id;
    }


    public function gitlab_request($gitlab_api_key, $endpoint, $params = [], $method = "GET", $post_data = null)
    {
        $gitlab_url = config('redmineintegration.gitlab_url');
        $client = new Client();
        try {
            $client_params = [
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 30,
                'connect_timeout' => 30
            ];
            if ($this->post_data) {
                $client_params['body'] = json_encode($this->post_data);
            }
            $query_params = [];
            if ($this->params) {
                foreach ($this->params as $key => $param) {
                    $query_params[] = $key . '=' . $param;
                }
            }
            $query_params[] = 'private_token=' . $this->gitlab_api_key;
            $query_params = implode('&', $query_params);
            $res = $client->request($this->method, $gitlab_url . '/' . $this->endpoint . '?' . $query_params, $client_params);

            $response = json_decode($res->getBody(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            Log::error($e);
            throw new \Exception($responseBodyAsString);
        } catch (\Exception $e) {
            Log::error($e);
            throw new \Exception($e);
        }
        return $response;
    }

    public function get_projects()
    {
        try {
            $response = $this->gitlab_request($this->api_key, 'projects', $this->data);
            return $response;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_branches()
    {
        try {
            $response = $this->gitlab_request($this->api_key, 'projects/' . $this->project_id . '/repository/branches', $this->data);
            return $response;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_merge_requests()
    {
        try {
            $response = $this->gitlab_request($this->api_key, 'merge_requests', $this->data);
            return $response;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function create_merge_request()
    {
        try {
            $response = $this->gitlab_request($this->api_key, 'projects/' . $this->project_id . '/merge_requests', [], 'POST', $this->data);
            return $response;
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }
}
