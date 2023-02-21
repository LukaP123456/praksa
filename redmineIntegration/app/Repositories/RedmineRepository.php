<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

class RedmineRepository
{
    public string $endpoint;
    public array $params;
    public string $method;
    public array $post_data;
    public array $data;
    public int $issue_id;
    public string $format;

    /**
     * @param $endpoint
     * @param array $params
     * @param string $method
     * @param $post_data
     */
    public function __construct($endpoint, array $params, string $method, $post_data, array $data, int $issue_id, string $format = 'json')
    {
        $this->endpoint = $endpoint;
        $this->params = $params;
        $this->method = $method;
        $this->post_data = $post_data;
        $this->data = $data;
        $this->issue_id = $issue_id;
        $this->format = $format;
    }

    public function redmine_request($endpoint, $params = [], $method = "GET", $post_data = null)
    {
        $redmine_url = config('redmineintegration.redmine_url');
        $redmine_api_key = config('redmineintegration.redmine_api_key');

        $format = config('redmineintegration.redmine_response_format');
        if (isset($this->params['format'])) {
            $format = $this->params['format'];
        }
        $this->endpoint .= '.' . $format;

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

            $query_params[] = 'key=' . $redmine_api_key;
            $query_params = implode('&', $query_params);
            $res = $client->request($this->method, $redmine_url . '/' . $this->endpoint . '?' . $query_params, $client_params);

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
            return $this->redmine_request('projects', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_issues()
    {
        try {
            return $this->redmine_request('issues', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_agile_info()
    {
        try {
            return $this->redmine_request('issues/' . $this->data['issue_id'] . '/agile_data', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_users()
    {
        try {
            return $this->redmine_request('users', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_time_entries()
    {
        try {
            return $this->redmine_request('time_entries', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_related_issues()
    {
        try {
            return $this->redmine_request('issues/' . $this->data['issue_id'] . '/relations', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_statuses()
    {
        try {
            return $this->redmine_request('issue_statuses', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function update_issue()
    {
        try {
            return $this->redmine_request('issues/' . $this->issue_id, ['format' => $this->format], "PUT", $this->post_data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }
}
