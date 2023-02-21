<?php

namespace App\Http\Controllers;

use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class RepoController extends Controller
{
    public function test()
    {
        $baseRepo = new BaseRepository();
        $repoData = [
            'integration' => 'redmine.url',
            'endpoint' => 'redmine.url',
            'params' => ['some params'],
            'method' => 'GET',
            'post_data' => [1, 2, 3, 4],
            'data' => ['data' => [1, 2, 3, 4]],
            'issue_id' => 1,
            'format' => 'json',
        ];

//        $repoData = [
//            'integration' => 'clockify.url',
//            'endpoint' => 'clockify.url',
//            'params' => ['some params'],
//            'method' => 'GET',
//            'post_data' => [1, 2, 3, 4],
//            'data' => ['data' => [1, 2, 3, 4]],
//            'issue_id' => 1,
//            'format' => 'json',
//        ];
        dd($baseRepo->CallRepo($repoData)->get_projects());
    }
}
