<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('services.update',$find->id)}}" >
    @csrf
        @method('PUT')
        <input type="hidden" value="{{$find->id}}" name="id">
        <div class="form-group">
            <label for="name" class="form-control-label">تحميل شعار الخدمة</label>
            <input type="file" id="testDrop" class="dropify" name="logo" data-default-file="{{$find->logo}}"/>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label"> {{__('admin.categories')}}</label>
            <select class="form-control" name="category_id" id="category_id">
                @forelse($categories as $category)
                    <option value="{{$category->id}}" {{($category->id == $find->category_id)? 'selected' : ''}}>{{$category->name}}</option>
                @empty
                    <option value=""></option>
                @endforelse
            </select>
        </div>
        <div class="form-group">
            <label for="user_id" class="form-control-label"> {{__('admin.providers')}}</label>
            <select class="form-control" name="user_id" id="user_id">
                @forelse($providers as $provider)
                    <option value="{{$provider->id}}"  {{($provider->id == $find->user_id)? 'selected' : ''}}>{{$provider->name}}</option>
                @empty
                    <option value=""></option>
                @endforelse
            </select>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="name" class="form-control-label"> {{__('admin.name')}}</label>
                <input type="text" value="{{$find->name}}" class="form-control" name="name" id="name">
            </div>

            <div class="form-group">
                <label for="price" class="form-control-label">رقم تواصل 1</label>
                <input type="number"  value="{{$find->phones[0]}}" class="form-control" name="phones[]" id="phones">
            </div>
            <div class="form-group">
                <label for="price" class="form-control-label">رقم تواصل 2</label>
                <input type="number" value="{{$find->phones[1]}}" class="form-control" name="phones[]" id="phones">
            </div>
            <div class="form-group">
                <label for="price" class="form-control-label">تفاصيل الخدمة</label>
                <textarea name="details" class="form-control editor" id="details"> {{$find->details}}</textarea>
            </div>

            <div class="form-group">
                <label for="price" class="form-control-label">تحميل صور الخدمة</label>
                <input type="file"  multiple="" class="form-control dropify" name="images[]" id="images">
            </div>

            @if($find->expired_at !== null)
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="btn_link" class="form-control-label">عدد الايام</label>
                            <input type="number" class="form-control" name="number_of_days" value="{{ $find->number_of_days }}" placeholder="عدد ايام " required>
                        </div>
                    </div>
                </div>
            @endif
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-success" id="updateButton">{{__('admin.update')}}</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
