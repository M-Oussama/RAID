@extends('layouts.dashboard')

@section('page_meta')
    <title>لائحة الأوراق الإدارية</title>
    <meta name="keywords" content="Rozaric"/>
    <meta name="description" content="Rozaric">
    <meta name="author" content="Rozaric">
@endsection

@section('styles')
    <!-- Page styles -->
@endsection

@section('scripts')
    <!-- Page scripts -->
    <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script>
        var table = $('#kt_datatable');

        // begin table
        table.DataTable({
            responsive: true,

            // DOM Layout settings
            dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

            lengthMenu: [5, 10, 25, 50],

            pageLength: 10,

            language: {
                "url": "{{url('/assets/json/ar.json')}}"
            },
            data: {!! $papers !!},

            // Order settings
            order: [[2, 'desc']],

            columns: [
                {
                  data:"id"
                },
                {
                    data: 'paper_type.name'
                },
                {
                    data: 'employee.name'
                },

                {
                    data: null,
                    title: 'اجراءات',
                    orderable: false,
                    width: '175px',
                    className: 'text-center',
                    render: function (data, type, row) {

                        console.log(data);
                            return '\
                               <a href="dash/papers/' + data.paper_type_id + '/' + data.id + '/exportFile"  class="btn btn-sm btn-clean btn-icon" title="استخراج ">\
                                    <i class="far fa-file-pdf">\
                                    </i>\
                                </a>\
                                <a href="#" data-toggle="modal"  data-target="#deleteModal" data-user_id="' + row.id + '" data-user_name="' + row.name + '" class="btn btn-sm btn-clean btn-icon" title="Delete">\
                                    <span class="svg-icon svg-icon-md">\
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                                <rect x="0" y="0" width="24" height="24"/>\
                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>\
                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>\
                                            </g>\
                                        </svg>\
                                    </span>\
                                </a>';

                    },
                },
            ],
        });

        table.on('change', '.group-checkable', function () {
            var set = $(this).closest('table').find('td:first-child .checkable');
            var checked = $(this).is(':checked');

            $(set).each(function () {
                if (checked) {
                    $(this).prop('checked', true);
                    $(this).closest('tr').addClass('active');
                } else {
                    $(this).prop('checked', false);
                    $(this).closest('tr').removeClass('active');
                }
            });
        });

        table.on('change', 'tbody tr .checkbox', function () {
            $(this).parents('tr').toggleClass('active');
            var checkable = $('input[class=checkable]');
            var groupcheck = $('input[class=group-checkable]');
            if (checkable.not(':checked').length > 0) {
                groupcheck.prop('checked', false);
            } else {
                groupcheck.prop('checked', true);
            }
        });

        //delete modal
        $('#paiementModal').on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element


            //populate the textbox
            $(e.currentTarget).find('#exampleModalFormTitle').text('هل تريد حقا استخراج محضر تقاضي المستحقات؟');
            //$(e.currentTarget).find('#deleteForm').attr('action', 'dash/security/assistance/' + user_id);
        });

        //delete multi modal
        $('#deleteMultiModal').on('show.bs.modal', function (e) {
            $(e.currentTarget).find('#deleteMultiSubmit').click(function (eclick) {
                eclick.preventDefault();
                $('#deleteMultiForm').submit();
            });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">لائحة الأوراق الإدارية

                    </h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    
                    <!--end::Dropdown-->

                </div>
            </div>
            <div class="card-body">
                <form id="deleteMultiForm" action="dash/papaers/delete-multi" method="post">
                @csrf
                <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="kt_datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>نوع الأوراق الإدارية</th>
                            <th>العامل</th>
                            <th>اجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </form>
            </div>
        </div>
        <!--end::Card-->

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalFormTitle"
             aria-hidden="true" style="display: none;">
            <div class="modal-dialog" role="document">
                <form id="deleteForm" action="dash/papers/{id}" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalFormTitle">هل أنت متأكد من حذف الوثيقة؟</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                                إغلاق
                            </button>
                            <button type="submit" class="btn btn-danger font-weight-bold">حذف</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>



@endsection
