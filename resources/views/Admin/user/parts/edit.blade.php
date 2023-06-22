<form id="updateForm" method="POST" enctype="multipart/form-data" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="image" class="form-control-label">الصورة</label>
        <input type="file" class="dropify" name="image" data-default-file="{{ $user->image }}"
            accept="image/png, image/gif, image/jpeg,image/jpg" />
        <span class="form-text text-danger text-center">مسموح بالصيغ الاتية png, gif, jpeg, jpg</span>
    </div>
    <div class="row">

        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_ar" class="form-control-label">اسم المستخدم</label>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">رقم الهاتف</label>
                <input type="text" class="form-control" value="{{ $user->phone }}"  name="phone">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">العنوان</label>
                <input type="text" class="form-control" value="{{ $user->address }}" name="address">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">سنوات الخبرة</label>
                <input type="text" class="form-control" value="{{ $user->experience }}" name="experience">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">نبذه عني </label>
                <textarea type="text" rows="3" class="form-control" name="about_me">  {{ $user->about_me }} </textarea>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">الخبرة السابقة</label>
                <textarea type="text" rows="3" class="form-control" name="previous_experience"> {{ $user->previous_experience }} </textarea>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">الايميل</label>
                <input type="text" class="form-control" value="{{ $user->name }}" name="email">
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
                        <option value="{{$city->id}}" >{{$city->name_ar}}</option>
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
        <div class="col-6">
            <div class="form-group">
                <label for="btn_title_en" class="form-control-label">الايميل</label>
                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="btn_link" class="form-control-label">الرقم السري</label>
                <input type="password" class="form-control" name="password" placeholder="******">
            </div>
        </div>

        @if ($user->role_id == 1)
            <div class="col-12">
                <div class="form-group row">
                    {{--  <input type="hidden" name="is_best" value="0" />  --}}
                    <input type="checkbox" class="form-control col-2" {{ ($user->is_best)? 'checked': '' }} id="isBest" name="is_best" value="1" placeholder="******">
                    <label for="btn_link" class="form-control-label col-10">وضع كمفضل</label>
                </div>
            </div>
        @endif
    </div>
    <div class="row py-5">
        <div class="col-12" {{ ($user->is_best)? '': 'hidden' }}  id="rate">
            <label for="">التقييم</label>
            <input type="number" class="form-control" name="rate" value="{{ $user->rate }}" />
        </div>
    </div>
    <div class="row">
        <div class="col-6" {{ ($user->is_best)? '': 'hidden' }} id="desc_ar">
            <label for="">الوصف بالعربي</label>
            <textarea class="form-control" name="description_ar" rows="8">{{ $user->description_ar }}</textarea>
        </div>
        <div class="col-6" {{ ($user->is_best)? '': 'hidden' }} id="desc_en">
            <label for="">الوصف بالانجليزي</label>
            <textarea class="form-control" name="description_en" rows="8">{{ $user->description_en }}</textarea>
        </div>
    </div>
    @if(!empty($user->advantages_ar))
    <div class="row" {{ ($user->is_best)? '': 'hidden' }} id="adv">
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">مزايا</label>
                <div class="row">

                    <div class="col-6 itemItems">
                        @foreach($user->advantages_ar as $item)
                        <label for="">Ar</label>
                        <input type="text" name="advantages_ar[]" class="form-control InputItem InputItemExtra"
                            value="{{$item}}">
                        @endforeach
                    </div>


                    <div class="col-6 itemItems2">
                        @foreach($user->advantages_en as $item)
                        <label for="">En</label>
                        <input type="text" name="advantages_en[]"  class="form-control InputItem InputItemExtra"
                            value="{{$item}}">
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
    @else
        <div class="row" {{ ($user->is_best)? '': 'hidden' }} id="adv">
            <div class="col-4">
                <div class="form-group">
                    <label class="control-label">مزايا</label>
                    <div class="row">

                        <div class="col-6 itemItems">
                            <label for="">Ar</label>
                            <input type="text" name="advantages_ar[]" class="form-control InputItem InputItemExtra"
                                   value="">
                        </div>


                        <div class="col-6 itemItems2">
                            <label for="">En</label>
                            <input type="text" name="advantages_en[]" class="form-control InputItem InputItemExtra"
                                   value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif
    <div class="col-4" {{ ($user->is_best)? '': 'hidden' }} id="btn">
        <button type="button" class="btn btn-primary MoreItem">اضافة سطر</button>
        <button type="button" class="btn btn-danger delItem">حذف سطر</button>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        <button type="submit" class="btn btn-success" id="updateButton">تعديل</button>
    </div>
</form>
<script>
    $('.dropify').dropify()

    $(document).ready(function() {
        $('#isBest').on('change', function() {
            var isChecked = $(this).prop('checked');
            var $textarea = $('#desc_ar');
            var $textarea2 = $('#desc_en');
            var $rate = $('#rate');
            var $adv = $('#adv');
            var $btn = $('#btn');
            if (isChecked) {
                $textarea.removeAttr('hidden');
                $textarea2.removeAttr('hidden');
                $rate.removeAttr('hidden');
                $adv.removeAttr('hidden');
                $btn.removeAttr('hidden');
                // Use AJAX here to send updated attribute value to server if needed
            } else {
                $textarea.attr('hidden', '');
                $textarea2.attr('hidden', '');
                $rate.attr('hidden', '');
                $adv.attr('hidden', '');
                $btn.attr('hidden', '');
                // Use AJAX here to send updated attribute value to server if needed
            }
        });
    });

    $(document).on('click', '.delItem', function() {
        var Item = $('.InputItemExtra').last();
        if (Item.val() == '') {
            Item.fadeOut();
            Item.remove();
            $('.Issue').removeClass('badge-danger').addClass('badge-success');
            $('.Issue').html('The element deleted');
            setTimeout(function() {
                $('.Issue').html('');
            }, 3000)
        } else {
            $('.Issue').html('The element must be empty');
            setTimeout(function() {
                $('.Issue').html('');
            }, 3000)

        }
    })

    $(document).on('click', '.MoreItem', function() {
        var Item = $('.InputItemExtra').last();
        if (Item.val() !== '') {
            $('.itemItems').append(
                '<label for="">Ar</label><input type="text" name="advantages_ar[]" class="form-control InputItem InputItemExtra" value="">'
            )
            $('.itemItems2').append(
                '<label for="">En</label><input type="text" name="advantages_en[]" class="form-control InputItem InputItemExtra" value="">'
            )
        }
    })
</script>
