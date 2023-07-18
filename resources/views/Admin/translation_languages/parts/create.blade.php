<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('translation_languages.store')}}" >
    @csrf
        <div class="form-group">
            <label for="name" class="form-control-label"> {{__('admin.name_ar')}}</label>
            <input type="text" class="form-control" name="name[ar]" id="name_ar" value="">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label"> {{__('admin.name_en')}}</label>
            <input type="text" class="form-control" name="name[en]" id="name_en" value="">
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
