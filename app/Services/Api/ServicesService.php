<?php

namespace App\Services\Api;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Traits\DefaultImage;
use App\Traits\GeneralTrait;
use App\Traits\PhotoTrait;
use Illuminate\Support\Facades\Validator;

class ServicesService
{
    use DefaultImage,GeneralTrait,PhotoTrait;

    public function store( $request){

        $rules = [
            'name' => 'required|min:2|max:191',
            'phones' => 'required',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'images' => 'nullable',
            'details' => 'nullable',
            'location' => 'nullable',
            'logo' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return helperJson(null, $validator->errors(), 422);
        }
        $user = auth()->user();
        $inputs = request()->all();
        $inputs['images'] = [];
        $inputs['logo'] = [];
//        $inputs['phones'] = json_encode();
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $inputs['images'][] = $this->saveImage($image,'services','images' );
            }
        }
        if ($request->hasFile('logo')) {
                $inputs['logo'] = $this->saveImage($request->file('logo'),'services','images' );
        }
        $inputs['user_id'] = $user->id;
//        dd($inputs);

        $product = Service::create($inputs);
        return helperJson(new ServiceResource($product), 'تمت الاضافة بنجاح');
    }

}
