<?php

namespace app\Repositories;

class BaseRepository
{
    public function CallRepo($integration, $endpoint, $params, $method, $post_data, $data)
    {
        switch ($integration) {
            case "redmine.url":
                return new RedmineRepository($endpoint, $params, $method, $post_data, $data);
            case "clockify.url":
                return new ClockifyRepository();
            case "gitlab.url":
                return new GitlabRepository();
            default:
                return "Unknown repository";
        }
    }

    public function get_projects($integration)
    {
        $this->CallRepo($integration)->get_projects();
    }

    public function get_agile_info($integration)
    {
        $this->CallRepo($integration)->get_agile_info();
    }

    public function get_issues($integration)
    {
        $this->CallRepo($integration)->get_issues();
    }

    public function get_users($integration)
    {
        $this->CallRepo($integration)->get_users();
    }

    public function get_time_entries($integration)
    {
        $this->CallRepo($integration)->get_time_entries();
    }

    public function get_related_issues($integration)
    {
        $this->CallRepo($integration)->get_related_issues();
    }

    public function get_statuses($integration)
    {
        $this->CallRepo($integration)->get_statuses();
    }

    public function update_issue($integration)
    {
        $this->CallRepo($integration)->update_issue();
    }
}
