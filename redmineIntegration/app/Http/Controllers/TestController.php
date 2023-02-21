<?php

namespace App\Http\Controllers;
//TODO:NAMESPACE MORA BIT ISKROZ ISPISAN VELIKIM SLOVIMA
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return new BaseRepository();
    }
}
