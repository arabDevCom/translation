<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('services.store')}}">
        @csrf
        <div class="form-group">
            <label for="name" class="form-control-label">تحميل شعار الخدمة</label>
            <input type="file" class="dropify" name="logo" data-default-file="{{asset('assets/uploads/avatar.png')}}"
                   accept="image/png,image/webp , image/gif, image/jpeg,image/jpg"/>
            <span class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif, jpeg, jpg,webp</span>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label"> {{__('admin.categories')}}</label>
            <select class="form-control" name="category_id" id="category_id">
                @forelse($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @empty
                    <option value=""></option>
                @endforelse
            </select>
        </div>
        <div class="form-group">
            <label for="user_id" class="form-control-label"> {{__('admin.providers')}}</label>
            <select class="form-control" name="user_id" id="user_id">
                @forelse($providers as $provider)
                    <option value="{{$provider->id}}">{{$provider->name}}</option>
                @empty
                    <option value=""></option>
                @endforelse
            </select>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label"> {{__('admin.name')}}</label>
            <input type="text" class="form-control" name="name" id="name">
        </div>

        <div class="form-group">
            <label for="price" class="form-control-label">رقم تواصل 1</label>
            <input type="number" class="form-control" name="phones[]" id="phones">
        </div>
       <div class="form-group">
            <label for="price" class="form-control-label">رقم تواصل 2</label>
            <input type="number" class="form-control" name="phones[]" id="phones">
        </div>
        <div class="form-group">
            <label for="price" class="form-control-label">تفاصيل الخدمة</label>
            <textarea name="details" class="form-control editor" id="details"></textarea>
        </div>

        <div class="form-group">
            <label for="price" class="form-control-label">تحميل صور الخدمة</label>
            <input type="file" multiple="" class="form-control" name="images[]" id="images">
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="btn_link" class="form-control-label">عدد الايام</label>
                    <input type="number" class="form-control" name="number_of_days" placeholder="عدد ايام ">
                </div>
            </div>
        </div>


        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>
