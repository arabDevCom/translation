<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TranslationType;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TranslationTypeController extends Controller
{
    use PhotoTrait;
    public function index(request $request)
    {
        if($request->ajax()) {
            $categories = TranslationType::latest()->get();

            return Datatables::of($categories)
                ->addColumn('action', function ($category) {
                    return '
                            <button type="button" data-id="' . $category->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $category->id . '" data-title="' . $category->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->addColumn('name', function ($category) {
                    return $category->name['ar'];
                })


                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/translation_types/index');
        }
    }


    public function create()
    {
        return view('Admin.translation_types.parts.create');
    }

    public function store(Request $request)
    {
        $valiadate = $request->validate([
            'name.ar'     => 'required',
            'name.en'     => 'required',
        ],[
            'name.ar.required' => 'يرجي ادخال  الاسم بالعربيه',
            'name.en.required' => 'يرجي ادخال  الاسم بالانجليزية',
        ]);
        $data = $request->except('_token');

        TranslationType::create($data);
        return response()->json(['status' => 200]);
    }



    public function edit($id)
    {
        $find = TranslationType::find($id);
        return view('Admin.translation_types.parts.edit',compact('find'));
    }



    public function update(Request $request, $id)
    {
        $category = TranslationType::find($id);
        $data = $request->except('_token','_method','id');


        $category->update($data);
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = TranslationType::find($request->id);

        $category->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);
    }

}
