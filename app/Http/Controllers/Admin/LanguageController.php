<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TranslationLanguage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LanguageController extends Controller
{
    public function index(request $request)
    {
        if($request->ajax()) {
            $languages = TranslationLanguage::latest()->get();

            return Datatables::of($languages)
                ->addColumn('action', function ($language) {
                    return '
                            <button type="button" data-id="' . $language->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $language->id . '" data-title="' . $language->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->addColumn('name', function ($language) {
                    return $language->name['ar'];
                })


                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/translation_languages/index');
        }
    }


    public function create()
    {
        return view('Admin.translation_languages.parts.create');
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

        TranslationLanguage::create($data);
        return response()->json(['status' => 200]);
    }



    public function edit($id)
    {
        $find = TranslationLanguage::find($id);
        return view('Admin.translation_languages.parts.edit',compact('find'));
    }



    public function update(Request $request, $id)
    {
        $language = TranslationLanguage::find($id);
        $data = $request->except('_token','_method','id');


        $language->update($data);
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
        $language = TranslationLanguage::find($request->id);

        $language->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);
    }

}
