<?php

namespace App\Services;

use App\Models\Favourite;
use App\Models\PostFavourite;
use App\Models\ProjectFavourite;
use Symfony\Component\HttpFoundation\Response;

class FavouriteService
{


    public function make_favourite($request)
    {
        try {
            $inputs = $request->all();
            $user = Auth()->user();
            $inputs['user_id'] = $user->id;
            $is_favourite = Favourite::where(['user_id' => $user->id,'service_id' => $inputs['service_id']]);
            if($is_favourite->count()){
                $is_favourite->first()->delete();
                return helperJson(null, 'Success remove from favorite',  Response::HTTP_OK);
            }else {
                $favourite = Favourite::create($inputs);
                return helperJson($favourite, 'Success add to favorite',  Response::HTTP_OK);
            }
        }catch(Exception $e){
            return helperJson(null, 'Sent Failed ',  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function get_favourites()
    {
        try {
            $user = Auth('api')->user();
            $data = Favourite::with('service')->where(['user_id' => $user->id])->get();
            return helperJson($data, '',  Response::HTTP_OK);
        }catch(Exception $e){
            return helperJson(null, 'Sent Failed ',  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
