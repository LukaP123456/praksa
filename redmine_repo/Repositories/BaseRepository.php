<?php

use Modules\RedmineIntegration\Repositories\ClockifyRepository;
use Modules\RedmineIntegration\Repositories\GitlabRepository;
use Modules\RedmineIntegration\Repositories\RedmineRepository;

class BaseRepository
{

    public function get_projects($endpoint, $data, $workspace_id, $api_key)
    {
        switch ($endpoint) {
            case "redmine.url":
                $redmine_repo = new RedmineRepository();
                $redmine_repo->get_projects($data);
                break;
            case "clockify.url":
                $clockify_repo = new ClockifyRepository();
                $clockify_repo->get_projects($workspace_id, $data);
                break;
            case "gitlab.url":
                $gitlab_repo = new GitlabRepository();
                $gitlab_repo->get_projects($api_key, $data);
                break;
            default:
                $GLOBALS['unknown_repo'] = true;
                break;
        }
    }

    public function get_users($endpoint, $data, $workspace_id, $api_key)
    {
        switch ($endpoint) {
            case "redmine.url":
                $redmine_repo = new RedmineRepository();
                $redmine_repo->get_users($data);
                break;
            case "clockify.url":
                $clockify_repo = new ClockifyRepository();
                $clockify_repo->get_users($workspace_id, $data);
                break;
            case "gitlab.url":
                return "No function get_users for gitlab";
                break;
            default:
                $GLOBALS['unkown'] = true;
                break;
        }
    }
}
