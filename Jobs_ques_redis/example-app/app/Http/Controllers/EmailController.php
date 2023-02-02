<?php

namespace App\Http\Controllers;

use App\Jobs\CustomerJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class EmailController extends Controller
{
    public function index()
    {
        Redis::set('user:1:first_name:', 'Mike');
        Redis::set('user:2:first_name:', 'John');
        Redis::set('user:3:first_name:', 'Kate');
    }

    public function sendEmail()
    {
        dispatch(new CustomerJob());

        dd("Email has been delivered");
    }
}
