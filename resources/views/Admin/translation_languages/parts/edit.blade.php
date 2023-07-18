<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('translation_languages.update',$find->id)}}" >
    @csrf
        @method('PUT')
        <input type="hidden" value="{{$find->id}}" name="id">


        <div class="form-group">
            <label for="name" class="form-control-label"> {{__('admin.name_ar')}}</label>
            <input type="text" class="form-control" name="name[ar]" id="name" value="{{$find->name['ar']}}">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label"> {{__('admin.name_en')}}</label>
            <input type="text" class="form-control" name="name[en]" id="[en]" value="{{$find->name['en']}}">
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-success" id="updateButton">{{__('admin.update')}}</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
