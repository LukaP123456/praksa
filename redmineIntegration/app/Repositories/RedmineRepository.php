<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RedmineRepository
{
    private $integration;
    public $endpoint;
    public $params;
    public $method;
    public $post_data;
    public $data;
    public $issue_id;
    public $format;

    /**
     * @param $endpoint
     * @param array $params
     * @param string $method
     * @param array $post_data
     */
    public function __construct($integration = 'redmine.url', $endpoint = '', $format = 'json', $method = "GET", $params = [], $post_data = [], $data = [], $issue_id = 0)
    {
        $this->integration = $integration;
        $this->endpoint = $endpoint;
        $this->format = $format;
        $this->params = $params;
        $this->method = $method;
        $this->post_data = $post_data;
        $this->data = $data;
        $this->issue_id = $issue_id;
    }

    //todo:U teoriji mozemo samo pozivati redmine_request/gitlab_request bez da koristimo get_projects ili get_users jer unutar redmine_request/gitlab_request mi vec odredjujemo koji endpoint cemo zvati

    public function request()
    {
        try {
            $redmine_url = env('REDMINE_URL');
            $redmine_api_key = env('REDMINE_API_KEY');
            $format = $this->format;

//            if (isset($this->params['format'])) {
//                $format = $this->params['format'];
//            }
//            if ($this->post_data) {
//                $client_params['body'] = json_encode($this->post_data);
//            }

            $client_params = [
                'Content-Type' => 'application/json',
                'timeout' => 30,
                'connect_timeout' => 30,
                'X-Redmine-API-Key' => $redmine_api_key
            ];

            $client = new Client([
                'headers' => $client_params, //This is how you put data into header
            ]);

            $query_params = [];
//            if ($this->params) {
//                foreach ($this->params as $key => $param) {
//                    $query_params[] = $key . '=' . $param;
//                }
//            }
//            $query_params = implode('&', $query_params);

            //Url for all the projects
            //"https://pm.icbtech.rs/redmine/projects.json?0=122.json" Ignorisace ovo posle ? i vratice sve projekete
            $url = $redmine_url . '/' . $this->endpoint . '.' . $format;

            //URL for single project
            $single_url = "";
            if (isset($this->params['single'])) {
                $single_url = $redmine_url . '/' . $this->endpoint . '/' . $this->params['single'] . '.' . $format;
                $url = $single_url;
            }
            //URL for single project and trackers
            if (isset($this->params['trackers'])) {
                $url = $single_url . '?include=trackers';
            }
            //URL for single project and trackers and issue_categories
            if (isset($this->params['trackers']) and isset($this->params['issue_categories'])) {
                $url = $single_url . '?include=trackers,issue_categories';
            }

            if (isset($this->params['offset']) and isset($this->params['limit'])) {
                $url = $redmine_url . '/' . $this->endpoint . '.' . $format . '?offset=' . $this->params['offset'] . '&limit=' . $this->params['limit'];
            }

            $res = $client->request($this->method, $url);
            $response = ($format != 'json') ? $res->getBody() : json_decode($res->getBody(), true);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            Log::error($e);
            throw new \Exception($responseBodyAsString);
        } catch (\Exception|GuzzleException $e) {
            Log::error($e);
            throw new \Exception($e);
        }
        return $response;
    }

//HTTP request()
//    public function request()
//    {
//        $redmine_url = env('REDMINE_URL');
//        $redmine_api_key = env('REDMINE_API_KEY');
//        $format = $this->format;
//
//        if (isset($this->params['format'])) {
//            $format = $this->params['format'];
//        }
//
//        try {
//            $client_params = [
//                'headers' => ['Content-Type' => 'application/json'],
//                'timeout' => 30,
//                'connect_timeout' => 30,
//                'X-Redmine-API-Key' => $redmine_api_key
//            ];
//            if ($this->post_data) {
//                $client_params['body'] = json_encode($this->post_data);
//            }
//            $query_params = [];
//            if ($this->params) {
//                foreach ($this->params as $key => $param) {
//                    $query_params[] = $key . '=' . $param;
//                }
//            }
//
//            //todo:Need info 4 query_params, what they do?
//            $query_params[] = 'key=' . $redmine_api_key;
//            $query_params = implode('&', $query_params);
//
//            $url = $redmine_url . '/' . $this->endpoint . '.' . $format;
//            $res = Http::withHeaders($client_params)->{$this->method}($url);
//
//            $response = ($format != 'json') ? $res : $res->json();
//
//        } catch (RequestException $e) {
//            $response = $e->response->json();
//            $responseBodyAsString = json_encode($response);
//            Log::error($e);
//            throw new \Exception($responseBodyAsString);
//        } catch (\Exception $e) {
//            Log::error($e);
//            throw new \Exception($e);
//        }
//        return $response;
//    }


//
//    public function get_projects()
//    {
//        try {
//            return $this->redmine_request();
//        } catch (\Exception $e) {
//            Log::error($e);
//            return [];
//        }
//    }
//
//    public function get_issues()
//    {
//        try {
//            return $this->request('issues', $this->data);
//        } catch (\Exception $e) {
//            Log::error($e);
//            return [];
//        }
//    }
//
//    public function get_agile_info()
//    {
//        try {
//            //TODO:what is agile_data?
////            return $this->redmine_request('issues/' . $this->data['issue_id'] . '/agile_data', $this->data);
//            return $this->redmine_request();
//        } catch (\Exception $e) {
//            Log::error($e);
//            return [];
//        }
//    }
//
//    //todo:Need admin api key to get users
//    public function get_users()
//    {
//        try {
//            return $this->redmine_request('users', $this->data);
//        } catch (\Exception $e) {
//            Log::error($e);
//            return [];
//        }
//    }
//
//    public function get_time_entries()
//    {
//        try {
//            return $this->redmine_request('time_entries', $this->data);
//        } catch (\Exception $e) {
//            Log::error($e);
//            return [];
//        }
//    }
//
//    public function get_related_issues()
//    {
//        try {
//            return $this->redmine_request('issues/' . $this->data['issue_id'] . '/relations', $this->data);
//        } catch (\Exception $e) {
//            Log::error($e);
//            return [];
//        }
//    }
//
//    public function get_statuses()
//    {
//        try {
//            return $this->redmine_request('issue_statuses', $this->data);
//        } catch (\Exception $e) {
//            Log::error($e);
//            return [];
//        }
//    }
//
//    public function update_issue()
//    {
//        try {
//            return $this->redmine_request('issues/' . $this->issue_id, ['format' => $this->format], "PUT", $this->post_data);
//        } catch (\Exception $e) {
//            Log::error($e);
//            return [];
//        }
//    }
}
