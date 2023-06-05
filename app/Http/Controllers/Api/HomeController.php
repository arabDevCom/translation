<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\Client\HomeService;
use App\Services\Api\Client\ProviderService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private HomeService $homeService;

    /**
     * @param homeService $homeService
     */
    public function __construct(HomeService $homeService)
    {
//        $this->middleware('auth_jwt');
        $this->homeService = $homeService;
    }

    public function index(Request $request){
        return $this->homeService->index($request);
    }

    public function services($category_id){
        return $this->homeService->services($category_id);
    }
    public function categories(){
        return $this->homeService->categories();
    }

    public function search(Request $request){
        return $this->homeService->search($request);
    }


    public function add_rate(Request $request){
        return $this->homeService->add_rate($request);
    }
}
