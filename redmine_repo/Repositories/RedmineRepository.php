<?php

namespace Modules\RedmineIntegration\Repositories;

use Validator;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RedmineRepository
{
    public function redmine_request($endpoint, $params = [], $method = "GET", $post_data = null)
    {
        $redmine_url = config('redmineintegration.redmine_url');
        $redmine_api_key = config('redmineintegration.redmine_api_key');

        $format = config('redmineintegration.redmine_response_format');
        if (isset($params['format'])) {
            $format = $params['format'];
        }
        $endpoint .= '.' . $format;

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

            $query_params[] = 'key=' . $redmine_api_key;
            $query_params = implode('&', $query_params);
            $res = $client->request($method, $redmine_url.'/'.$endpoint. '?' . $query_params, $client_params);

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

    public function get_projects($data = []) {
        try {
            $response = $this->redmine_request('projects', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }

    public function get_issues($data = []) {
        try {
            $response = $this->redmine_request('issues', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }

    public function get_agile_info($data = []) {
        try {
            $response = $this->redmine_request('issues/'.$data['issue_id'].'/agile_data', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }

    public function get_users($data = []) {
        try {
            $response = $this->redmine_request('users', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }

    public function get_time_entries($data = []) {
        try {
            $response = $this->redmine_request('time_entries', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }

    public function get_related_issues($data = []) {
        try {
            $response = $this->redmine_request('issues/'.$data['issue_id'].'/relations', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }

    public function get_statuses($data = []) {
        try {
            $response = $this->redmine_request('issue_statuses', $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }

    public function update_issue($issue_id, $post_data, $format = 'json') {
        try {
            $response = $this->redmine_request('issues/'.$issue_id, ['format' => $format], "PUT", $post_data);
            return $response;
        } catch (\Exception $e) {
            \Log::error($e);
            return [];
        }
    }
}
