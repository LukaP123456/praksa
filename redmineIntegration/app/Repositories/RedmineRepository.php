<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
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
     * @param array $post_data
     */
    public function __construct($endpoint, array $params, string $method, array $post_data, array $data, int $issue_id, string $format = 'json')
    {
        $this->endpoint = $endpoint;
        $this->params = $params;
        $this->method = $method;
        $this->post_data = $post_data;
        $this->data = $data;
        $this->issue_id = $issue_id;
        $this->format = $format;
    }

    //todo:U teoriji mozemo samo pozivati redmine_request/gitlab_request bez da koristimo get_projects ili get_users jer unutar redmine_request/gitlab_request mi vec odredjujemo koji endpoint cemo zvati
    public function request()
    {
        $redmine_url = env('REDMINE_URL');
        $redmine_api_key = env('REDMINE_API_KEY');
        $format = $this->format;

        if (isset($this->params['format'])) {
            $format = $this->params['format'];
        }

        $client = new Client();
        try {
            $client_params = [
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 30,
                'connect_timeout' => 30,
                'X-Redmine-API-Key' => $redmine_api_key
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
            $res = $client->request($this->method, $redmine_url . '/' . $this->endpoint . '.' . $format . '?' . $query_params, $client_params);
            $response = json_decode($res->getBody(), true);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            Log::error($e);
            throw new \Exception($responseBodyAsString);
        } catch (\Exception $e) {
            Log::error($e);
            throw new \Exception($e);
            //todo:Tu treba da bude 2 catcha?
        } catch (GuzzleException $e) {
            Log::error($e);
            throw new \Exception($e);
        }
        return $response;
    }

    //todo:get_projects,get_issues maybe aren't needed because redmine_request() takes in as a parameter issue,projects,users... so it gets the necessary data.
    public function get_projects()
    {
        try {
            return $this->redmine_request();
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_issues()
    {
        try {
            return $this->request('issues', $this->data);
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    public function get_agile_info()
    {
        try {
            //TODO:what is agile_data?
//            return $this->redmine_request('issues/' . $this->data['issue_id'] . '/agile_data', $this->data);
            return $this->redmine_request();
        } catch (\Exception $e) {
            Log::error($e);
            return [];
        }
    }

    //todo:Need admin api key to get users
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
