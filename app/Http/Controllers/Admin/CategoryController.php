<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    use PhotoTrait;
    public function index(request $request)
    {
        if($request->ajax()) {
            $categories = Category::latest()->get();

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
                ->addColumn('category_services', function ($category) {
                    return '
                            <a  href="'.route('category.services',$category->id).'" data-id="' . $category->id . '" class="btn btn-pill btn-info-light ">'. __("admin.services").' <i class="fa fa-edit"></i></a>

                       ';
                })

                ->editColumn('image', function ($category) {
                    $image = ($category->image);
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="'.$image.'">
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/category/index');
        }
    }


    public function create()
    {
        return view('Admin.category.parts.create');
    }


    public function store(Request $request)
    {
        $valiadate = $request->validate([
            'name'     => 'required',
            'image'     => 'required',
        ],[
            'name.required' => 'يرجي ادخال  الاسم ',
            'image.required' => 'يرجي ادخال  الصورة ',
        ]);
        $data = $request->except('_token','image');
        if($request->has('image') && $request->image != null)
            $data['image'] = $this->saveImage($request->image,'assets/uploads/categories','image','100');

        Category::create($data);
        return response()->json(['status' => 200]);
    }



    public function edit($id)
    {
        $find = Category::find($id);
        return view('Admin.category.parts.edit',compact('find'));
    }



    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $data = $request->except('_token','_method','image');


        if($request->has('image') && $request->image != null){
            if (file_exists($category->getAttributes()['image'])) {
                unlink($category->getAttributes()['image']);
            }
            $data['image'] = $this->saveImage($request->image,'assets/uploads/categories');
        }

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
        $category = Category::find($request->id);
        if (file_exists($category->getAttributes()['image'])) {
            unlink($category->getAttributes()['image']);
        }
        $category->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);
    }

    public function delete(request $request)
    {
        $category = User::findOrFail($request->id);
        if (file_exists($category->getAttributes()['image'])) {
            unlink($category->getAttributes()['image']);
        }
        $category->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);
    }
}
