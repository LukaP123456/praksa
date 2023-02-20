<?php

namespace redmine_integration\Repositories;

use redmine_integration\Repositories\ClockifyRepository;
use redmine_integration\Repositories\GitlabRepository;
use redmine_integration\Repositories\RedmineRepository;

class BaseRepository
{
    public function CallRepo($integ)
    {
        switch ($integ) {
            case "redmine.url":
                return new RedmineRepository();
//                "return new RedmineRepository()";
            case "clockify.url":
                return new ClockifyRepository();
            case "gitlab.url":
                return new GitlabRepository();
            default:
                return "Unknown repository";
        }
    }

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
