<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\GeneralService;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    private GeneralService $generalService;

    /**
     * @param GeneralService $generalService
     */
    public function __construct(GeneralService $generalService)
    {
//        $this->middleware('auth_jwt');
        $this->generalService = $generalService;
    }

    public function cities(){
        return $this->generalService->cities();
    }
    public function translation_types(){
        return $this->generalService->translations();
    }

    public function sliders(){
        return $this->generalService->sliders();
    }
}
