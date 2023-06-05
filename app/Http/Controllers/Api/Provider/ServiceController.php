<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
use App\Services\Api\ServicesService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    private ServicesService $servicesService;

    /**
     * @param productService $servicesService
     */
    public function __construct(ServicesService $servicesService)
    {
        $this->middleware('auth_jwt');
        $this->servicesService = $servicesService;
    }

    public function store(request $request){

        return $this->servicesService->store($request);
    }

}
