<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use App\Traits\PhotoTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{
    use PhotoTrait;
    public function index(request $request)
    {
        if($request->ajax()) {
            $service = Service::latest()->get();
            return Datatables::of($service)
                ->addColumn('action', function ($service) {
                    return '
                            <button type="button" data-id="' . $service->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $service->id . '" data-title="' . $service->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>

                       ';
                })


                ->editColumn('logo', function ($service) {
                    $image = $service->logo;
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="'.$image.'">
                    ';
                })
                ->addColumn('category', function ($service) {
                    return $service->category->name;
                })
                ->addColumn('day', function ($service) {
//                    if ($service->expired_at !== null) {
                        $days = Carbon::now()->diffInDays($service->expired_at);
                        if ($days > 0) {
                            return 'متبقي ' . $days . ' من أيام';
                        } else {
                            return 'منتهي';
                        }
//                    } else {
//                        return 'بانر اساسي';
//                    }
                })
                ->addColumn('show', function ($service) {
                    if ($service->status == 0)
                        $span = '<span style="cursor: pointer" data-id="' . $service->id . '" class="badge badge-danger statusSpan">مخفي</span';
                    else
                        $span = '<span style="cursor: pointer" data-id="' . $service->id . '"  class="badge badge-success statusSpan">معروض</span';

                    return $span;
                })
                ->addColumn('status', function ($service) {
//                    if ($service->expired_at !== null) {
                        if (Carbon::now() < $service->expired_at) {

                            return '<span class="btn btn-sm btn-success">مفعل</span>';
                        } else {
                            return '<span class="btn btn-sm btn-danger">غير مفعل</span>';
                        }

                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/services/index');
        }
    }

    public function serviceActivation(Request $request)
    {
        $slider = Service::find($request->id);
        ($slider->status == '0') ? $slider->status = '1' : $slider->status = '0';
        $slider->save();
        return response()->json(
            [
                'success' => true,
                'message' => 'تم تغيير حالة المستخدم بنجاح'
            ]);
    }

    public function categoryServices(Request $request,$category_id)
    {

        if($request->ajax()) {
            $services = Service::where('category_id',$category_id)->get();

            return Datatables::of($services)
                ->addColumn('action', function ($service) {
                    return '
                            <button type="button" data-id="' . $service->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $service->id . '" data-title="' . $service->name_ar . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })

                ->editColumn('name', function ($service) {
                    return $service->name_ar;
                })

                ->editColumn('logo', function ($product) {
                    $image = ($product->logo);
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="'.$image.'">
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/services/category_products');
        }
    }

    public function create()
    {
        $data['categories'] = Category::latest()->get();
        $data['providers'] = User::where('role_id',1)->get();
        return view('Admin.services.parts.create',$data);
    }


    public function store(Request $request)
    {
        $valiadate = $request->validate([
            'name'     => 'required',
            'logo'     => 'required',
            'details'     => 'required',
            'phones'     => 'required',
        ],[
            'name.required' => 'يرجي ادخال  الاسم ',
            'logo.required' => 'يرجي ادخال شعار الخدمه',
            'details.required' => 'يرجي ادخال التفاصيل',
            'phones.required' => 'يرجي ادخال ارقام التواصل'
        ]);
        $data = $request->except('_token','image');

        $data['expired_at'] = Carbon::now()->addDays($request->number_of_days);

//        $data['started_at'] = Carbon::now();

        if($request->has('logo') && $request->logo != null)
            $data['logo'] = $this->saveImage($request->image,'assets/uploads/services','image','100');
        $data['images'] = [];
        if($request->has('images') && $request->images != null)
            foreach($request->images as $image){
                $data['images'][] = $this->saveImage($image, 'assets/uploads/services', 'image', '100');
            }

        Service::create($data);
        return response()->json(['status' => 200]);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $data['find'] = Service::find($id);
        $data['categories'] = Category::latest()->get();
        $data['providers'] = User::where('role_id',1)->get();
        return view('Admin.services.parts.edit',$data);
    }



    public function update(Request $request, $id)
    {
        $valiadate = $request->validate([
            'name'     => 'required',
            'logo'     => 'required',
            'details'     => 'required',
            'phones'     => 'required',
        ],[
            'name.required' => 'يرجي ادخال  الاسم ',
            'logo.required' => 'يرجي ادخال شعار الخدمه',
            'details.required' => 'يرجي ادخال التفاصيل',
            'phones.required' => 'يرجي ادخال ارقام التواصل'
        ]);


        $product = Service::find($id);
        $data = $request->except('_token','_method','image');

        if ($product->expired_at !== null) {
            $data['expired_at'] = Carbon::parse($product->started_at)->addDays($request->number_of_days);
        }

        if($request->has('logo') && $request->logo != null){
            if (file_exists($product->logo)) {
                unlink($product->logo);
            }
            $data['logo'] = $this->saveImage($request->logo,'assets/uploads/services');
        }

        $data['images'] = [];
        if($request->has('images') && $request->images != null)
            foreach($request->images as $image){
                $data['images'][] = $this->saveImage($image, 'assets/uploads/services', 'image', '100');
            }
        $product->update($data);
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request,$id)
    {
        $product = Product::findOrFail($request->id);
        if (file_exists($product->getAttributes()['image'])) {
            unlink($product->getAttributes()['image']);
        }
        $product->delete();
        return response(['message'=>'تم الحذف بنجاح','status'=>200],200);
    }


}
