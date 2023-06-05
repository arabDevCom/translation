<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavouriteRequest;
use App\Services\FavouriteService;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    private $favourite;

    /**
     * @param FavouriteService $favourite
     */
    public function __construct(FavouriteService $favourite)
    {
        $this->middleware('auth_jwt');

        $this->favourite = $favourite;
    }

    // Make Post Favourite
    public function post_favourite(FavouriteRequest $request)
    {
        return $this->favourite->make_favourite($request);
    }



    public function get_favourites()
    {
        return $this->favourite->get_favourites();
    }
}
