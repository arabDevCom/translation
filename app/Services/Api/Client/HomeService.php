<?php

namespace App\Services\Api\Client;

use App\Http\Resources\Client\ProvidersResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SliderResource;;

use App\Models\Category;
use App\Models\Package;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Service;
use App\Models\Slider;
use App\Models\User;
use App\Traits\DefaultImage;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class HomeService
{
    use DefaultImage,GeneralTrait;
    public function index(){
        $data['categories'] = Category::select('id','name','image')->get();
        $data['last_add_services'] = Service::select('name','category_id','logo')->latest()->take(5)->get();

        return helperJson($data, '');
    }

    public function categories(){
        $data = Category::select('id','name','image')->get();

        return helperJson($data, '');
    }


    public function services($category_id){

        $services = Service::where(['category_id'=>$category_id,'status'=> 1])->whereDate('expired_at', '>', Carbon::now())->with('provider')->get();
        $data = ServiceResource::collection($services);
        return helperJson($data, '');
    }

    public function search($request){
        $search_key = $request->search_key;
//        dd($request->provider_id);
        $services = Service::where(function ($query) use ($search_key) {
                $query->where('name', 'LIKE', '%'.$search_key.'%');
            })->get();
        return helperJson(ProductResource::collection($services), '',200);
    }

    // add rate to Provider
    public function add_rate($request){
        $rules = [
            'service_id' => 'required|exists:services,id',
            'value' => 'required',
            'comment' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return helperJson(null, $validator->errors(), 422);
        }
        $user = Auth::guard('api')->user();
        $inputs = request()->all();
        $inputs['user_id'] = $user->id;
        $rate = Rate::where(['user_id'=>$user->id,'service_id'=>$inputs['service_id']]);
        if($rate->count()){
            $rate = $rate->first();
            $rate->value = $inputs['value'];
            $rate->comment = $inputs['comment'];
            $rate->save();
        }else {
            $rate = Rate::create($inputs);
        }
        return helperJson($rate, 'تم التقيم بنجاح');
    }

}
