<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use GeneralTrait;

    public function index(Request $request)
    {
        $language = $request->language_id;
        $users = User::select('id','name','phone')
            ->when($language,function ($query) use ($language) {
                $query->where('language_id',$language);
            })
            ->where('role_id',2)->where('phone','like', "%".$request->search_key."%")->get();
        return helperJson($users, '',200);
    }
}
