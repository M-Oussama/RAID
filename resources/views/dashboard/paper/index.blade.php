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
                    data: 'title'
                },


                {
                    data: null,
                    title: 'اجراءات',
                    orderable: false,
                    width: '175px',
                    className: 'text-center',
                    render: function (data, type, row) {
                        return '\
                        \<a href="dash/papers/' + row.id + '/create" class="btn btn-sm btn-clean btn-icon" title="استخراج ">\
                            <i class="far fa-file-pdf">\
                            </i>\
                        </a>\
                        ';
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
        $('#deleteModal').on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element
            var user_id = $(e.relatedTarget).data('user_id');
            var user_name = $(e.relatedTarget).data('user_name');

            //populate the textbox
            $(e.currentTarget).find('#exampleModalFormTitle').text('هل حقا تريد حذف الموظف' + user_name + ' ?');
            $(e.currentTarget).find('#deleteForm').attr('action', 'dash/security/assistance/' + user_id);
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
                            <th>الأوراق الإدارية</th>
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

    </div>
@endsection
