<?php

namespace App\Repositories;

class BaseRepository
{
    /**
     * Function which returns an instance of Repository class based on the inputted integration value.
     *
     * @param array $RepoData
     * @return ClockifyRepository|GitlabRepository|RedmineRepository|string
     */
    public function CallRepo(array $RepoData)
    {
        switch ($RepoData['integration']) {
            case "redmine.url":
                return new RedmineRepository(
                    $RepoData['integration'],
                    $RepoData['endpoint'],
                    $RepoData['format'],
                    $RepoData['method'],
                    $RepoData['params'],
                    $RepoData['post_data'],
                    $RepoData['data'],
                    $RepoData['issue_id']);
            case "clockify.url":
                return new ClockifyRepository(
                    $RepoData['endpoint'],
                    $RepoData['params'],
                    $RepoData['method'],
                    $RepoData['post_data'],
                    $RepoData['data'],
                    $RepoData['issue_id']);
            case "gitlab.url":
                return new GitlabRepository(
                    $RepoData['endpoint'],
                    $RepoData['params'],
                    $RepoData['method'],
                    $RepoData['post_data'],
                    $RepoData['data'],
                    $RepoData['gitlab_api_key'],
                    $RepoData['api_key'],
                    $RepoData['project_id']);
            default:
                return "Unknown repository";
        }
    }

//    public function get_projects(array $RepoData)
//    {
//        $this->CallRepo($RepoData)->get_projects();
//    }
//
//    public function get_agile_info(array $RepoData)
//    {
//        $this->CallRepo($RepoData)->get_agile_info();
//    }
//
//    public function get_issues(array $RepoData)
//    {
//        $this->CallRepo($RepoData)->get_issues();
//    }
//
//    public function get_users(array $RepoData)
//    {
//        $this->CallRepo($RepoData)->get_users();
//    }
//
//    public function get_time_entries(array $RepoData)
//    {
//        $this->CallRepo($RepoData)->get_time_entries();
//    }
//
//    public function get_related_issues(array $RepoData)
//    {
//        $this->CallRepo($RepoData)->get_related_issues();
//    }
//
//    public function get_statuses(array $RepoData)
//    {
//        $this->CallRepo($RepoData)->get_statuses();
//    }
//
//    public function update_issue(array $RepoData)
//    {
//        $this->CallRepo($RepoData)->update_issue();
//    }
}
