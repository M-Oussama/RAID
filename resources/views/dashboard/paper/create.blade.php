@extends('layouts.dashboard')

@section('page_meta')
    <title>إنشاء عقد</title>
    <meta name="keywords" content="Rozaric"/>
    <meta name="description" content="Rozaric">
    <meta name="author" content="Rozaric">
@endsection

@section('styles')
    <!-- Page styles -->
@endsection

@section('scripts')
    <!-- Page scripts -->
    <script>
        //Password check
        var password = $('input[name="password"]');
        var password2 = $('input[name="password2"]');

        $("#driver_license_block").hide();

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



    </script>
@endsection

@section('content')
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title"> إنشاء عقد</h3>
            </div>
            <!--begin::Form-->
            <form class="form" method="post" action="dash/contracts" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-sm-12 col-md-4">
                            <label>الموظف : </label>
                            <select class="form-control"  name="employee_id" autocomplete="city" required>
                                @foreach($employees as $employee)
                                    <option value="{{$employee->id}}" {{old('employee') == $employee->id ? 'selected':''}}>{{$employee->name." ".$employee->surname}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-12 col-md-4">
                            <label>نوع عقد العمل : </label>
                            <select class="form-control"  name="paper_type_id" autocomplete="city" required>

                                    <option value=1" >عقد عمل رئيس موقع ورئيس فوج</option>
                                    <option value="2">غقد عمل لعون الأمن</option>

                            </select>
                        </div>

                        <div class="form-group col-sm-12 col-md-4">
                            <label>المنصب* :</label>
                            <input type="text" name="post" value="{{old('name')}}" autocomplete="family-name"
                                   class="form-control form-control-solid" placeholder="أدخل المنصب" required/>
                            <span class="form-text text-muted">الرجاء إدخال المنصب</span>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>الموقع* :</label>
                            <input type="text" name="post_location" value="{{old('surname')}}" autocomplete="given-name"
                                   class="form-control form-control-solid" placeholder="أدخل الموقع"
                                   required/>
                            <span class="form-text text-muted">الرجاء ادخال الموقع</span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label>تاريح الإنخراط الفعلي بالشركة :</label>
                            <input type="date" name="recruitment_date" value="{{old('recruitment_date')}}" autocomplete="bday"
                                   class="form-control form-control-solid" placeholder="أدخل تاريخ الإنخراط الفعلي بالشركة "/>
                            <span class="form-text text-muted">الرجاء إدخال تاريخ الإنخراط الفعلي بالشركة </span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label>تاريح التأمين بالشركة :</label>
                            <input type="date" name="insurance_date" value="{{old('insurance_date')}}" autocomplete="bday"
                                   class="form-control form-control-solid" placeholder="أدخل تاريخ التأمين بالشركة "/>
                            <span class="form-text text-muted">الرجاء إدخال تاريخ التأمين بالشركة </span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label>تاريح بداية العقد :</label>
                            <input type="date" name="start_date" value="{{old('start_date')}}" autocomplete="bday"
                                   class="form-control form-control-solid" placeholder="أدخل تاريخ بداية العقد "/>
                            <span class="form-text text-muted">الرجاء إدخال تاريخ بداية العقد </span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label>تاريح نهاية العقد :</label>
                            <input type="date" name="end_date" value="{{old('end_date')}}" autocomplete="bday"
                                   class="form-control form-control-solid" placeholder="أدخل تاريخ  نهاية العقد "/>
                            <span class="form-text text-muted">الرجاء إدخال تاريخ  نهاية العقد </span>
                        </div>


                </div>



                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mr-2">إضافة</button>
                    <a href="dash/contracts" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
@endsection
