<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Player;
use App\MOdels\Category;
use App\MOdels\Park;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

   
}
