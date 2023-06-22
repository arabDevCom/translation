


<form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('users.store')}}">
    @csrf
    <div class="form-group">
        <label for="image" class="form-control-label">الصورة</label>
        <input type="file" class="dropify" name="image" accept="image/png, image/gif, image/jpeg,image/jpg"/>
        <span class="form-text text-danger text-center">مسموح بالصيغ الاتية png, gif, jpeg, jpg</span>
    </div>
    <div class="row">

        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_ar" class="form-control-label">اسم المستخدم</label>
                <input type="text" class="form-control" name="user_name">
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">رقم الهاتف</label>
                <input type="text" class="form-control" name="phone">
            </div>
        </div>
       <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">العنوان</label>
                <input type="text" class="form-control" name="address">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">سنوات الخبرة</label>
                <input type="text" class="form-control" name="experience">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">نبذه عني </label>
                <textarea type="text" rows="3" class="form-control" name="about_me">  </textarea>
            </div>
        </div>
          <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">الخبرة السابقة</label>
                <textarea type="text" rows="3" class="form-control" name="previous_experience">  </textarea>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">الايميل</label>
                <input type="text" class="form-control" name="email">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">نوع الترجمة</label>
                <select class="form-control" name="translation_type_id" id="translation_type_id">
                    @forelse($translation_types as $translation_type)
                        <option value="{{$translation_type->id}}">{{$translation_type->name_ar}}</option>
                    @empty
                        <option value=""></option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">المدينة</label>
                <select class="form-control" name="translation_type_id" id="city_id">
                    @forelse($cities as $city)
                        <option value="{{$city->id}}">{{$city->name_ar}}</option>
                    @empty
                        <option value=""></option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">نوع مقدم الخدمة</label>
                <select class="form-control" name="provider_type" id="translation_type_id">

                        <option value="1">مكتب</option>
                        <option value="2">فرد</option>

                </select>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="btn_link" class="form-control-label">الرقم السري</label>
                <input type="password" class="form-control" name="password" placeholder="******">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
    </div>
</form>
<script>
    $('.dropify').dropify()
</script>

