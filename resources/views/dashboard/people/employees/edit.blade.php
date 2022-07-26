@extends('layouts.dashboard')

@section('page_meta')
    <title> تعديل بيانات موظف</title>
    <meta name="keywords" content="Rozaric"/>
    <meta name="description" content="Rozaric">
    <meta name="author" content="Rozaric">
@endsection

@section('styles')
    <!-- Page styles -->
    <style>
        .hideE{
            display:none
        }
            </style>
@endsection

@section('scripts')
    <!-- Page scripts -->
    <script>
        //Password check
        var password = $('input[name="password"]');
        var password2 = $('input[name="password2"]');

      //  $("#driver_license_block").hide();

        password2.on('keyup', function () {
            if (password.val()) {
                if (password2.val() != password.val()) {
                    password2.removeClass('is-valid');
                    password2.addClass('is-invalid');
                } else {
                    password2.removeClass('is-invalid');
                    password2.addClass('is-valid');
                }
            }
        })

        //Image uploader
        var avatar = new KTImageInput('kt_avatar');

        //Select2
        $('#kt_select2_1').select2();

        $('#document_select').on('change',function () {
            if($(this).val() == "NC"){
                $("#driver_license_block").hide();
                $("#national_card_block").show();
            }else{
                $("#driver_license_block").show();
                $("#national_card_block").hide();
            }

        });

        $('#document_wilaya').on('change',function () {

            KTApp.blockPage({
                overlayColor: '#000000',
                opacity: 0.1,
                size: 'lg',
                state: 'danger',
                message: 'الرجاء الانتظار...'
            });
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            });

            var id = $(this).val();

            $('#document_baladia').find('option').remove();

            $.ajax({
                url:'dash/wilayas/'+id+'/get_baladias',
                type:'GET',
                dataType:'json',
                success:function (response) {
                    var leng = 0;
                    if (response.baladias != null) {
                        leng = response.baladias.length;
                    }

                    if (leng>0) {
                        for (var i = 0; i<leng; i++) {
                            var id = response.baladias[i].id;
                            var name = response.baladias[i].name_ar;
                            var BALADIA = response.baladias[i].BALADIA;

                            var option = "<option value='"+id+"'>"+BALADIA+"-"+name+"</option>";

                            $("#document_baladia").append(option);
                        }
                    }

                    if (leng>0) {
                        for (var i = 0; i<leng; i++) {
                            if(response.dairas[i] != undefined){
                                var id = response.dairas[i].id;
                                var name_ = response.dairas[i].name_ar;
                                var DAIRA = response.dairas[i].DAIRA;

                                var option = "<option value='"+id+"'>"+DAIRA+"-"+name_+"</option>";

                                $("#document_daira").append(option);
                            }

                        }
                    }

                    KTApp.unblockPage();
                }
            })
        });

        $('#birthplace_wilaya').on('change',function () {

            KTApp.blockPage({
                overlayColor: '#000000',
                opacity: 0.1,
                size: 'lg',
                state: 'danger',
                message: 'الرجاء الانتظار...'
            });
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            });

            var id = $(this).val();

            $('#birthplace_daira').find('option').remove();
            $('#birthplace_baladia').find('option').remove();

            $.ajax({
                url:'dash/wilayas/'+id+'/get_baladias_dairas',
                type:'GET',
                dataType:'json',
                success:function (response) {
                    var leng = 0;
                    if (response.baladias != null) {
                        leng = response.baladias.length;
                    }

                    if (leng>0) {
                        for (var i = 0; i<leng; i++) {
                            var id = response.baladias[i].id;
                            var name = response.baladias[i].name_ar;
                            var BALADIA = response.baladias[i].BALADIA;

                            var option = "<option value='"+id+"'>"+BALADIA+"-"+name+"</option>";

                            $("#birthplace_baladia").append(option);
                        }
                    }

                    if (leng>0) {
                        for (var i = 0; i<leng; i++) {
                            if(response.dairas[i] != undefined){
                                var id = response.dairas[i].id;
                                var name_ = response.dairas[i].name_ar;
                                var DAIRA = response.dairas[i].BALADIA;

                                var option = "<option value='"+id+"'>"+DAIRA+"-"+name_+"</option>";

                                $("#birthplace_daira").append(option);
                            }
                        }
                    }

                    KTApp.unblockPage();
                }
            })
        });

        $('#postal_account_msg').hide();
        $('#social_security_msg').hide();
        $('#postal_account').on('input',function () {


            var val = $(this).val();
            console.log(val.length);
            if(val.length <= 20) {
                $('#postal_account_msg').hide();
                $('#postal_account_msg1').show();
            } else{
                $('#postal_account_msg').show();
                $('#postal_account_msg1').hide();
            }


        });
        $('#social_security').on('input',function () {


            var val = $(this).val();
            console.log(val.length);
            if(val.length <= 12) {
                $('#social_security_msg').hide();
                $('#social_security_msg1').show();
            } else{
                $('#social_security_msg').show();
                $('#social_security_msg1').hide();
            }


        });
       /* $('#birthplace_daira').on('change',function () {

            KTApp.blockPage({
                overlayColor: '#000000',
                opacity: 0.1,
                size: 'lg',
                state: 'danger',
                message: 'الرجاء الانتظار...'
            });
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            });

            var id = $(this).val();

            $('#birthplace_baladia').find('option').remove();

            $.ajax({
                url:'dash/dairas/'+id+'/get_baladias_from_dairas',
                type:'GET',
                dataType:'json',
                success:function (response) {
                    var leng = 0;
                    if (response.baladias != null) {
                        leng = response.baladias.length;
                    }

                    if (leng>0) {
                        for (var i = 0; i<leng; i++) {
                            var id = response.baladias[i].id;
                            var name = response.baladias[i].name_ar;
                            var BALADIA = response.baladias[i].BALADIA;

                            var option = "<option value='"+id+"'>"+BALADIA+"-"+name+"</option>";

                            $("#birthplace_baladia").append(option);
                        }
                    }

                    KTApp.unblockPage();
                }
            })
        });

        $('#document_daira').on('change',function () {

            KTApp.blockPage({
                overlayColor: '#000000',
                opacity: 0.1,
                size: 'lg',
                state: 'danger',
                message: 'الرجاء الانتظار...'
            });
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            });

            var id = $(this).val();

            $('#document_baladia').find('option').remove();

            $.ajax({
                url:'dash/dairas/'+id+'/get_baladias_from_dairas',
                type:'GET',
                dataType:'json',
                success:function (response) {
                    var leng = 0;
                    if (response.baladias != null) {
                        leng = response.baladias.length;
                    }

                    if (leng>0) {
                        for (var i = 0; i<leng; i++) {
                            var id = response.baladias[i].id;
                            var name = response.baladias[i].name_ar;
                            var BALADIA = response.baladias[i].BALADIA;

                            var option = "<option value='"+id+"'>"+BALADIA+"-"+name+"</option>";

                            $("#document_baladia").append(option);
                        }
                    }

                    KTApp.unblockPage();
                }
            })
        });*/

    </script>
@endsection

@section('content')
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title"> معلومات الموظف</h3>
            </div>
            <!--begin::Form-->
            <form class="form" method="post" action="dash/security/assistance/{{$employee->id}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="image-input image-input-empty image-input-outline d-contents" id="kt_avatar"
                                 style="margin-left: 36%;background-image: url({{ !empty($employee->getFirstMedia('avatars')) ? $employee->getFirstMedia('avatars')->getUrl() : 'assets/media/users/blank.png' }})">
                                <div class="image-input-wrapper" ></div>

                                <label
                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                        data-action="change" data-toggle="tooltip" title=""
                                        data-original-title="Change avatar">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" autocomplete="photo"/>
                                    <input type="hidden" name="avatar_remove"/>
                                </label>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                      data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                      data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>
                            </div>
                            <span class="form-text text-muted" style="margin-left: 27%;">أنواع الملفات المسموح بها: png، jpg، jpeg.</span>
                        </div>

                        <div class="col-sm-12 col-md-6 row">
                            <div class="form-group col-sm-12 col-md-12">
                                <label>الإسم* :</label>
                                <input type="text" name="name" value="{{old('name',$employee->name)}}" autocomplete="family-name"
                                       class="form-control form-control-solid" placeholder="أدخل اسم الموظف" required/>
                                <span class="form-text text-muted">الرجاء إدخال اسم الموظف</span>
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label>اللقب* :</label>
                                <input type="text" name="surname" value="{{old('surname',$employee->surname)}}" autocomplete="given-name"
                                       class="form-control form-control-solid" placeholder="أدخل لقب الموظف"
                                       required/>
                                <span class="form-text text-muted">الرجاء إدخال لقب الموظف</span>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="form-group col-sm-12 col-md-6">
                            <label>تاريح الميلاد :</label>
                            <input type="date" name="birthdate" value="{{old('birthdate',$employee->birthdate)}}" autocomplete="bday"
                                   class="form-control form-control-solid" placeholder="أدخل تاريخ ميلاد الموظف"/>
                            <span class="form-text text-muted">الرجاء إدخال تاريخ ميلاد الموظف</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label>مكان الميلاد * :</label>
                            <input type="text" name="birthplace" value="{{old('birthplace',$employee->address->address)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل مكان الميلاد"
                                   required/>
                            <span class="form-text text-muted">الرجاء إدخال مكان الميلاد</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-4">
                            <label>الولاية : </label>
                            <select class="form-control" id="birthplace_wilaya" name="wilaya_id" autocomplete="city">
                                @foreach($wilayas as $wilaya)
                                    <option value="{{$wilaya->id}}" {{old('wilaya_id',$employee->address->WILAYA->id) == $wilaya->id ? 'selected':''}}>{{$wilaya->WILAYA."- ".$wilaya->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-12 col-md-4">
                            <label>الدائرة : </label>
                            <select class="form-control" id="birthplace_daira" name="daira_id" autocomplete="city">
                                @foreach($dairas as $daira)
                                    <option value="{{$daira->id}}" {{$employee->address->daira_id == $daira->id ? 'selected':''}}>{{$daira->DAIRA."- ".$daira->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-12 col-md-4">
                            <label>البلدية : </label>
                            <select class="form-control" id="birthplace_baladia" name="baladia_id" autocomplete="city">
                                @foreach($baladias as $baladia)
                                    <option value="{{$baladia->id}}" {{old('baladia_id',$employee->address->baladia_id) == $baladia->id ? 'selected':''}}>{{$baladia->BALADIA."- ".$baladia->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>إسم الأب* :</label>
                            <input type="text" name="father_name" value="{{old('father_name',$employee->father_name)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل إسم الأب"
                                   required/>
                            <span class="form-text text-muted">الرجاء إدخال إسم الأب</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label>إسم ولقب الأم* :</label>
                            <input type="text" name="mother_fullname" value="{{old('mother_fullname',$employee->mother_fullname)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل إسم ولقب الأم"
                                   required/>
                            <span class="form-text text-muted">الرجاء إدخال إسم ولقب الأم</span>
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label>الحالة العائلية* :</label>

                            <select class="form-control" id="family_status" name="family_status" autocomplete="city">

                                <option value="متزوج" {{$employee->family_status == "متزوج" ? 'selected' : ''}}>متزوج</option>
                                <option value="اعزب" {{$employee->family_status == "اعزب" ? 'selected' : ''}}>اعزب</option>
                                <option value="مطلق" {{$employee->family_status == "مطلق" ? 'selected' : ''}}>مطلق</option>
                                <option value="أرمل" {{$employee->family_status == "أرمل" ? 'selected' : ''}}>أرمل</option>


                            </select>
                          {{--  <input type="text" name="family_status" value="{{old('family_status',$employee->family_status)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل الحالة العائلية"
                                   />--}}
                            <span class="form-text text-muted">الرجاء إدخال الحالة العائلية</span>
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label> عدد الأولاد * :</label>
                            <input type="number" name="children_number" value="{{old('children_number',$employee->children_number)}}"
                                   class="form-control form-control-solid" placeholder="ادخل عدد الأولاد"
                                   min="0" />
                            <span class="form-text text-muted">الرجاء ادخال عدد الأولاد </span>
                        </div>

                        <div class="form-group col-sm-12 col-md-4">
                            <label>إسم الزوجة* :</label>
                            <input type="text" name="wife_name" value="{{old('wife_name',$employee->wife_name)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل إسم الزوجة"
                                   />
                            <span class="form-text text-muted">الرجاء إدخال إسم الزوجة</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label> العنوان * :</label>
                            <input type="text" name="address" value="{{old('address',$employee->livingAddress->address)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل العنوان"
                                   required/>
                            <span class="form-text text-muted">الرجاء إدخال العنوان</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label>الولاية : </label>
                            <select class="form-control" id="wilaya_address" name="wilaya_address" autocomplete="city">
                                @foreach($wilayas as $wilaya)
                                    <option value="{{$wilaya->id}}" {{old('wilaya_id',$employee->livingAddress->wilaya_id) == $wilaya->id ? 'selected':''}}>{{$wilaya->WILAYA."- ".$wilaya->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>




                        <div class="form-group col-sm-12 col-md-6">
                            <label> رقم عقد الإزدياد * :</label>
                            <input type="text" name="birthday_document_number" value="{{old('birthday_document_number',$employee->birthday_document_number)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل رقم عقد الإزدياد"
                                   required/>
                            <span class="form-text text-muted">الرجاء إدخال رقم عقد الإزدياد</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label> المستوى الدراسي * :</label>
                            <input type="text" name="education_level" value="{{old('education_level',$employee->education_level)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل المستوى الدراسي"
                                   />
                            <span class="form-text text-muted">الرجاء إدخال المستوى الدراسي</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label>  رقم الحساب البريدي الجاري * :</label>
                            <input type="text" id="postal_account" name="postal_account_number" value="{{old('postal_account_number',$employee->postal_account_number)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل ـ رقم الحساب البريدي الجاري"
                                   pattern=".{0}|.{20,}"   title="20 nombres minimum"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"/>

                            <span id="postal_account_msg1" class="form-text text-muted">الرجاء إدخال رقم الحساب البريدي الجاري</span>
                            <span id="postal_account_msg" class="form-text  text-danger">رقم الحساب البريدي الجاري يجب أن يتكون من 20 رقم تحديدا</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label> رقم الضمان الإجتماعي * :</label>
                            <input type="text" id="social_security" name="social_security_number" value="{{old('social_security_number',$employee->social_security_number)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل رقم الضمان الإجتماعي"
                                   pattern=".{0}|.{12,}"   title="12 nombres minimum"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"/>
                            <span id="social_security_msg1" class="form-text text-muted">الرجاء إدخال رقم الضمان الإجتماعي</span>
                            <span id="social_security_msg" class="form-text  text-danger">رقم الضمان الإجتماعي يجب أن يتكون من 12 رقم تحديدا</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label> الوضعية تجاه الخدمة الوطنية * :</label>

                            <select class="form-control" id="national_service" name="national_service" autocomplete="city">

                                <option value="مؤدي" {{$employee->national_service == "مؤدي" ? "selected":''}}>مؤدي</option>
                                <option value="مؤجل" {{$employee->national_service == "مؤجل" ? "selected":''}}>مؤجل</option>
                                <option value="معفى" {{$employee->national_service == "معفى" ? "selected":''}}>معفى</option>


                            </select>

                           {{-- <input type="text" name="national_service" value="{{old('national_service',$employee->national_service)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل الوضعية تجاه الخدمة الوطنية"
                                   required/>--}}
                            <span class="form-text text-muted">الرجاء إدخال الوضعية تجاه الخدمة الوطنية</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label> الرتبة * :</label>
                            <input type="text" name="national_service_rank" value="{{old('national_service_rank',$employee->national_service_rank)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل الرتبة"
                                   />
                            <span class="form-text text-muted">الرجاء إدخال الرتبة</span>
                        </div>


                        <div class="form-group col-sm-12 col-md-6">
                            <label> رقم الهاتف * :</label>
                            <input type="text" name="phone" value="{{old('phone',$employee->phone)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل رقم الهاتف"
                                   />
                            <span class="form-text text-muted">الرجاء إدخال رقم الهاتف</span>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>فصيلة الدم : </label>
                            <select class="form-control" id="blood_type" name="blood_type" autocomplete="city">

                                <option value="A+" {{old('blood_type',$employee->blood_type) == "A+" ? 'selected':''}}>A+</option>
                                <option value="A-" {{old('blood_type',$employee->blood_type) == "A-" ? 'selected':''}}>A-</option>
                                <option value="B+" {{old('blood_type',$employee->blood_type) == "B+" ? 'selected':''}}>B+</option>
                                <option value="B-" {{old('blood_type',$employee->blood_type) == "B-" ? 'selected':''}}>B-</option>
                                <option value="AB+" {{old('blood_type',$employee->blood_type) == "AB+" ? 'selected':''}}>AB+</option>
                                <option value="AB-" {{old('blood_type',$employee->blood_type) == "AB-" ? 'selected':''}}>AB-</option>
                                <option value="O+" {{old('blood_type',$employee->blood_type) == "O+" ? 'selected':''}}>O+</option>
                                <option value="O-" {{old('blood_type',$employee->blood_type) == "O-" ? 'selected':''}}>O-</option>

                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label>بطاقة التعريف الوطنية/رخصة السياقة</label>
                            <select class="form-control" id="document_select" name="document_type" autocomplete="city">

                                <option value="NC" {{old('national_card',$employee->national_card) == 1 ? 'selected':''}}>بطاقة التعريف الوطنية</option>
                                <option value="DL" {{old('driver_license',$employee->driver_license) == 1 ? 'selected':''}}>رخصة السياقة</option>


                            </select>
                        </div>

                        <div class="form-group col-sm-12 col-md-4 {{old('national_card',$employee->national_card) == 0 ? 'hideE':''}}" id="national_card_block">
                            <label>رقم بطاقة التعريف الوطنية * :</label>
                            <input type="text" name="document_number1" value="{{old('document_number',$employee->document_number)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل رقم بطاقة التعريف الوطنية"
                                   />
                            <span class="form-text text-muted">الرجاء إدخال رقم بطاقة التعريف الوطنية</span>
                        </div>


                        <div class="form-group col-sm-12 col-md-4 {{old('driver_license',$employee->driver_license) == 0 ? 'hideE':''}}" id="driver_license_block">
                            <label> رقم رخصة السياقة * :</label>
                            <input type="text" name="document_number2" value="{{old('document_number',$employee->document_number)}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل رقم رخصة السياقة"
                            />
                            <span class="form-text text-muted">الرجاء إدخال رقم رخصة السياقة</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-4">
                            <label> الصادرة بتاريخ * :</label>
                            <input type="date" name="document_date" value="{{old('document_date',$employee->document_date)}}"
                                   class="form-control form-control-solid" placeholder="أدخل  التاريخ"
                            />
                            <span class="form-text text-muted">الرجاء إدخال التاريخ</span>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-sm-12 col-md-4">
                            <label>الولاية : </label>
                            <select class="form-control" id="document_wilaya" name="document_wilaya" autocomplete="city">
                                @foreach($wilayas as $wilaya)
                                    <option value="{{$wilaya->id}}" {{old('document_wilaya',$employee->documentAddress->wilaya_id) == $wilaya->id ? 'selected':''}}>{{$wilaya->WILAYA."- ".$wilaya->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-12 col-md-4">
                            <label>الدائرة : </label>
                            <select class="form-control" id="document_daira" name="document_daira" autocomplete="city">
                                @foreach($dairas as $daira)
                                    <option value="{{$daira->id}}" {{old('document_daira',$employee->documentAddress->daira_id) == $daira->id ? 'selected':''}}>{{$daira->DAIRA."- ".$daira->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-12 col-md-4">
                            <label>البلدية : </label>
                            <select class="form-control" id="document_baladia" name="document_baladia" autocomplete="city">
                                @foreach($baladias as $baladia)
                                    <option value="{{$baladia->id}}" {{old('document_baladia',$employee->documentAddress->baladia_id) == $baladia->id ? 'selected':''}}>{{$baladia->BALADIA."- ".$baladia->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>




                        <div class="form-group col-sm-12 col-md-6">
                            <label> تاريخ التوظيف * :</label>
                            <input type="date" name="recruitment_date" value="{{old('recruitment_date',$employee->recruitment_date)}}"
                                   class="form-control form-control-solid" placeholder="أدخل  التاريخ"
                            />
                            <span class="form-text text-muted">الرجاء إدخال التاريخ</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label> تاريخ التأمين * :</label>
                            <input type="date" name="insurance_date"
                                   class="form-control form-control-solid" value="{{old('insurance_date',$employee->insurance_date)}}" placeholder="أدخل  التاريخ"
                            />
                            <span class="form-text text-muted">الرجاء إدخال التاريخ</span>
                        </div>
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mr-2">تعديل</button>
                    <a href="dash/security/assistance" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
@endsection
