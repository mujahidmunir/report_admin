@extends('layouts.master')

@section('title', 'Jadwal Kerja')

@section('content')
    <div class="card border-0 border-start border-bottom border-5 radius-15 border-secondary">
        <div class="card-header ">
            <h3 class="mt-3 mb-3">Today Report</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Action</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th width="10%" class="text-center">Link</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $key => $data)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$data->action ? $data->action->name : null}}</td>
                            <td>{{$data->title}}</td>
                            <td>{{$data->category->name}}</td>
                            <td><a href="{{$data->link}}" target="_blank" class="btn btn-sm btn-primary d-grid">view</a> </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="card shadow-sm border-0">

            <div class="card-header d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Jadwal Kerja
                    </h5>

                    <small class="text-muted">
                        Klik tanggal untuk menambah atau mengubah jadwal.
                    </small>
                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- CALENDAR --}}
            {{-- ========================================================= --}}

            <div class="card-body">

                <div id="workCalendar"></div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- LEGEND USER --}}
        {{-- ========================================================= --}}

        <div class="card shadow-sm border-0 mt-3">

            <div class="card-header">

                <strong>
                    <i class="fas fa-users mr-2"></i>
                    Keterangan Warna User
                </strong>

                <small class="text-muted ml-2">
                    Klik kotak warna untuk mengubah warna user.
                </small>

            </div>


            <div class="card-body">

                <div
                    id="userLegend"
                    class="d-flex flex-wrap"
                    style="gap: 12px;"
                >

                    @foreach($users as $user)

                        <div
                            class="user-color-item d-flex align-items-center"
                            data-user-id="{{ $user->id }}"
                        >

                            {{-- ================================================= --}}
                            {{-- COLOR PICKER --}}
                            {{-- ================================================= --}}

                            <input
                                type="color"
                                class="user-color-picker"
                                value="{{ $user->schedule_color ?: '#6c757d' }}"
                                data-user-id="{{ $user->id }}"
                                data-old-color="{{ $user->schedule_color ?: '#6c757d' }}"
                                title="Ubah warna {{ $user->name }}"
                            >


                            {{-- ================================================= --}}
                            {{-- USER NAME --}}
                            {{-- ================================================= --}}

                            <span class="ml-2 font-weight-500">
                            {{ $user->name }}
                        </span>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- MODAL JADWAL --}}
    {{-- ============================================================= --}}

    <div
        class="modal fade"
        id="scheduleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="scheduleModalLabel"
        aria-hidden="true"
    >

        <div
            class="modal-dialog modal-dialog-centered"
            role="document"
        >

            <div class="modal-content">

                {{-- ================================================= --}}
                {{-- MODAL HEADER --}}
                {{-- ================================================= --}}

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="scheduleModalLabel"
                    >

                        <i class="fas fa-calendar-check mr-2"></i>

                        Jadwal Kerja

                    </h5>


                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >

                    <span aria-hidden="true">
                        &times;
                    </span>

                    </button>

                </div>


                {{-- ================================================= --}}
                {{-- FORM --}}
                {{-- ================================================= --}}

                <form
                    id="scheduleForm"
                    autocomplete="off"
                >

                    <div class="modal-body">

                        {{-- ================================================= --}}
                        {{-- TANGGAL --}}
                        {{-- ================================================= --}}

                        <div class="form-group">

                            <label for="scheduleDateDisplay">

                                Tanggal

                            </label>


                            <input
                                type="text"
                                id="scheduleDateDisplay"
                                class="form-control"
                                readonly
                            >


                            <input
                                type="hidden"
                                id="scheduleDate"
                                name="date"
                            >

                        </div>


                        {{-- ================================================= --}}
                        {{-- USER --}}
                        {{-- ================================================= --}}

                        <div class="form-group">

                            <label for="userIds">

                                User yang masuk kerja

                                <span class="text-danger">
                                *
                            </span>

                            </label>


                            <select
                                id="userIds"
                                name="user_ids[]"
                                class="form-control select2"
                                multiple
                                style="width: 100%;"
                            >

                                @foreach($users as $user)

                                    <option
                                        value="{{ $user->id }}"
                                    >
                                        {{ $user->name }}
                                    </option>

                                @endforeach

                            </select>


                            <small class="text-muted">

                                Anda dapat memilih beberapa user.

                            </small>

                        </div>


                        {{-- ================================================= --}}
                        {{-- INFO JADWAL --}}
                        {{-- ================================================= --}}

                        <div
                            id="scheduleInfo"
                            class="alert alert-info d-none"
                        >
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FOOTER --}}
                    {{-- ================================================= --}}

                    <div class="modal-footer">

                        {{-- DELETE --}}

                        <button
                            type="button"
                            class="btn btn-danger mr-auto d-none"
                            id="btnDeleteSchedule"
                        >

                            <i class="fas fa-trash mr-1"></i>

                            Hapus Jadwal

                        </button>


                        {{-- CANCEL --}}

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >

                            <i class="fas fa-times mr-1"></i>

                            Batal

                        </button>


                        {{-- SAVE --}}

                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="btnSaveSchedule"
                        >

                            <i class="fas fa-save mr-1"></i>

                            <span id="btnSaveText">
                            Simpan Jadwal
                        </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection


{{-- ============================================================= --}}
{{-- CSS --}}
{{-- ============================================================= --}}

@push('head')

    {{-- FullCalendar --}}
    <link
        href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.css"
        rel="stylesheet"
    >


    {{-- Select2 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
        rel="stylesheet"
    />


    <style>

        /*
        |--------------------------------------------------------------------------
        | CALENDAR
        |--------------------------------------------------------------------------
        */

        #workCalendar {

            min-height: 650px;

        }


        .fc-event {

            cursor: pointer;

            border-radius: 5px;

            padding: 2px 5px;

        }


        .fc-event-title {

            font-weight: 600;

        }


        .fc-daygrid-day {

            cursor: pointer;

        }


        /*
        |--------------------------------------------------------------------------
        | SELECT2
        |--------------------------------------------------------------------------
        */

        .select2-container {

            width: 100% !important;

        }


        .select2-container--default
        .select2-selection--multiple {

            min-height: 38px;

            border: 1px solid #ced4da;

            border-radius: .25rem;

            padding-bottom: 3px;

        }


        .select2-container--default
        .select2-selection--multiple
        .select2-selection__choice {

            margin-top: 5px;

        }


        /*
        |--------------------------------------------------------------------------
        | USER COLOR
        |--------------------------------------------------------------------------
        */

        .user-color-item {

            display: flex;

            align-items: center;

            padding: 7px 10px;

            border: 1px solid #e5e5e5;

            border-radius: 6px;

            background: #ffffff;

            transition: all .2s ease;

        }


        .user-color-item:hover {

            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);

        }


        .user-color-picker {

            width: 38px;

            height: 32px;

            padding: 2px;

            border: 1px solid #ced4da;

            border-radius: 5px;

            cursor: pointer;

            background: #ffffff;

        }


        .user-color-picker:disabled {

            cursor: wait;

            opacity: .5;

        }


        .font-weight-500 {

            font-weight: 500;

        }


        /*
        |--------------------------------------------------------------------------
        | MODAL
        |--------------------------------------------------------------------------
        */

        #scheduleModal .modal-header {

            background: #f8f9fa;

        }


        #scheduleModal .modal-title {

            font-weight: 600;

        }


        #scheduleInfo {

            margin-bottom: 0;

        }


        /*
        |--------------------------------------------------------------------------
        | FULLCALENDAR HEADER
        |--------------------------------------------------------------------------
        */

        .fc .fc-toolbar-title {

            font-size: 1.25rem;

            font-weight: 600;

        }


        .fc .fc-button {

            border-radius: 4px;

        }


    </style>

@endpush


{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

@push('js')

    {{-- ============================================================= --}}
    {{-- SWEETALERT2 --}}
    {{-- HARUS DIMUAT SEBELUM KODE YANG MENGGUNAKAN Swal --}}
    {{-- ============================================================= --}}

    <script
        src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    </script>


    {{-- ============================================================= --}}
    {{-- FULLCALENDAR --}}
    {{-- ============================================================= --}}

    <script
        src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js">
    </script>


    {{-- ============================================================= --}}
    {{-- SELECT2 --}}
    {{-- ============================================================= --}}

    <script
        src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
    </script>


    <script>

        $(document).ready(function () {

            /*
            |--------------------------------------------------------------------------
            | VARIABLES
            |--------------------------------------------------------------------------
            */

            let calendar = null;

            let currentDate = null;

            let isEdit = false;


            /*
            |--------------------------------------------------------------------------
            | CEK DEPENDENCY
            |--------------------------------------------------------------------------
            */

            if (typeof Swal === 'undefined') {

                console.error(
                    'SweetAlert2 belum berhasil dimuat.'
                );

                return;

            }


            if (typeof FullCalendar === 'undefined') {

                console.error(
                    'FullCalendar belum berhasil dimuat.'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | CSRF
            |--------------------------------------------------------------------------
            */

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN':
                        $('meta[name="csrf-token"]').attr('content')

                }

            });


            /*
            |--------------------------------------------------------------------------
            | SELECT2
            |--------------------------------------------------------------------------
            */

            $('#userIds').select2({

                dropdownParent:
                    $('#scheduleModal'),

                placeholder:
                    'Pilih user yang masuk kerja',

                allowClear:
                    true,

                closeOnSelect:
                    false

            });


            /*
            |--------------------------------------------------------------------------
            | FORMAT TANGGAL
            |--------------------------------------------------------------------------
            */

            function formatTanggal(dateString)
            {

                if (!dateString) {
                    return '';
                }


                const date =
                    new Date(
                        dateString + 'T00:00:00'
                    );


                return date.toLocaleDateString(
                    'id-ID',
                    {
                        weekday: 'long',
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | RESET MODAL
            |--------------------------------------------------------------------------
            */

            function resetModal()
            {

                $('#scheduleForm')[0].reset();


                $('#scheduleDate')
                    .val('');


                $('#scheduleDateDisplay')
                    .val('');


                $('#userIds')
                    .val([])
                    .trigger('change')
                    .prop('disabled', false);


                $('#scheduleInfo')
                    .addClass('d-none')
                    .html('');


                $('#btnDeleteSchedule')
                    .addClass('d-none')
                    .prop('disabled', false);


                $('#btnSaveSchedule')
                    .prop('disabled', false);


                $('#btnSaveText')
                    .text('Simpan Jadwal');


                isEdit = false;

            }


            /*
            |--------------------------------------------------------------------------
            | OPEN MODAL
            |--------------------------------------------------------------------------
            */

            function openScheduleModal(date)
            {

                resetModal();


                currentDate = date;


                $('#scheduleDate')
                    .val(date);


                $('#scheduleDateDisplay')
                    .val(
                        formatTanggal(date)
                    );


                $('#scheduleModal')
                    .modal('show');


                loadSchedule(date);

            }


            /*
            |--------------------------------------------------------------------------
            | LOAD SCHEDULE
            |--------------------------------------------------------------------------
            */

            function loadSchedule(date)
            {

                $.ajax({

                    url:
                        "{{ route('work-schedules.by-date') }}",

                    type:
                        "GET",

                    data: {

                        date:
                        date

                    },


                    beforeSend: function ()
                    {

                        $('#userIds')
                            .prop('disabled', true);


                        $('#btnSaveSchedule')
                            .prop('disabled', true);

                    },


                    success: function (response)
                    {

                        const users =
                            response.users || [];


                        const userIds =
                            users.map(function (user) {

                                return String(
                                    user.user_id
                                );

                            });


                        /*
                        |--------------------------------------------------------------------------
                        | SET SELECT2
                        |--------------------------------------------------------------------------
                        */

                        $('#userIds')
                            .val(userIds)
                            .trigger('change')
                            .prop('disabled', false);


                        /*
                        |--------------------------------------------------------------------------
                        | SUDAH ADA JADWAL
                        |--------------------------------------------------------------------------
                        */

                        if (userIds.length > 0) {

                            isEdit = true;


                            $('#btnDeleteSchedule')
                                .removeClass('d-none');


                            $('#btnSaveText')
                                .text('Update Jadwal');


                            $('#scheduleInfo')
                                .removeClass('d-none')
                                .html(
                                    '<strong>' +
                                    userIds.length +
                                    '</strong> user sudah dijadwalkan pada tanggal ini.'
                                );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | BELUM ADA JADWAL
                        |--------------------------------------------------------------------------
                        */

                        else {

                            isEdit = false;


                            $('#btnDeleteSchedule')
                                .addClass('d-none');


                            $('#btnSaveText')
                                .text('Simpan Jadwal');

                        }

                    },


                    error: function (xhr)
                    {

                        $('#userIds')
                            .prop('disabled', false);


                        showAjaxError(
                            xhr,
                            'Gagal mengambil jadwal.'
                        );

                    },


                    complete: function ()
                    {

                        $('#btnSaveSchedule')
                            .prop('disabled', false);

                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | AJAX ERROR
            |--------------------------------------------------------------------------
            */

            function showAjaxError(
                xhr,
                defaultMessage
            )
            {

                let message =
                    defaultMessage;


                if (xhr.responseJSON) {

                    if (xhr.responseJSON.message) {

                        message =
                            xhr.responseJSON.message;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | VALIDATION ERROR
                    |--------------------------------------------------------------------------
                    */

                    if (xhr.responseJSON.errors) {

                        let html = '';


                        Object.keys(
                            xhr.responseJSON.errors
                        ).forEach(function (key) {

                            xhr.responseJSON
                                .errors[key]
                                .forEach(function (error) {

                                    html +=
                                        '<div>' +
                                        error +
                                        '</div>';

                                });

                        });


                        if (html) {

                            message =
                                html;

                        }

                    }

                }


                Swal.fire({

                    icon:
                        'error',

                    title:
                        'Error',

                    html:
                    message

                });

            }


            /*
            |--------------------------------------------------------------------------
            | INIT FULLCALENDAR
            |--------------------------------------------------------------------------
            */

            const calendarElement =
                document.getElementById(
                    'workCalendar'
                );


            if (!calendarElement) {

                console.error(
                    '#workCalendar tidak ditemukan.'
                );

                return;

            }


            calendar =
                new FullCalendar.Calendar(
                    calendarElement,
                    {

                        locale:
                            'id',


                        initialView:
                            'dayGridMonth',


                        height:
                            'auto',


                        firstDay:
                            1,


                        /*
                        |--------------------------------------------------------------------------
                        | HEADER
                        |--------------------------------------------------------------------------
                        */

                        headerToolbar: {

                            left:
                                'prev,next today',

                            center:
                                'title',

                            right:
                                'dayGridMonth,listMonth'

                        },


                        buttonText: {

                            today:
                                'Hari Ini',

                            month:
                                'Bulan',

                            list:
                                'Daftar'

                        },


                        /*
                        |--------------------------------------------------------------------------
                        | EVENT
                        |--------------------------------------------------------------------------
                        */

                        events: {

                            url:
                                "{{ route('work-schedules.events') }}",

                            method:
                                'GET',


                            failure: function ()
                            {

                                Swal.fire({

                                    icon:
                                        'error',

                                    title:
                                        'Error',

                                    text:
                                        'Gagal mengambil data jadwal.'

                                });

                            }

                        },


                        /*
                        |--------------------------------------------------------------------------
                        | KLIK TANGGAL
                        |--------------------------------------------------------------------------
                        */

                        dateClick:
                            function (info)
                            {

                                openScheduleModal(
                                    info.dateStr
                                );

                            },


                        /*
                        |--------------------------------------------------------------------------
                        | KLIK EVENT
                        |--------------------------------------------------------------------------
                        */

                        eventClick:
                            function (info)
                            {

                                const date =
                                    info.event
                                        .extendedProps
                                        .date;


                                openScheduleModal(
                                    date
                                );

                            },


                        /*
                        |--------------------------------------------------------------------------
                        | EVENT CONTENT
                        |--------------------------------------------------------------------------
                        */

                        eventContent:
                            function (arg)
                            {

                                const name =
                                    arg.event
                                        .extendedProps
                                        .user_name
                                    ||
                                    arg.event.title;


                                const wrapper =
                                    document.createElement(
                                        'div'
                                    );


                                wrapper.style.fontWeight =
                                    '600';


                                const icon =
                                    document.createElement(
                                        'i'
                                    );


                                icon.className =
                                    'fas fa-user mr-1';


                                const text =
                                    document.createTextNode(
                                        name
                                    );


                                wrapper.appendChild(
                                    icon
                                );


                                wrapper.appendChild(
                                    text
                                );


                                return {

                                    domNodes:
                                        [wrapper]

                                };

                            }

                    }
                );


            calendar.render();


            /*
            |--------------------------------------------------------------------------
            | SAVE / UPDATE JADWAL
            |--------------------------------------------------------------------------
            */

            $('#scheduleForm').on(
                'submit',
                function (e)
                {

                    e.preventDefault();


                    const date =
                        $('#scheduleDate')
                            .val();


                    const userIds =
                        $('#userIds')
                            .val();


                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI TANGGAL
                    |--------------------------------------------------------------------------
                    */

                    if (!date) {

                        Swal.fire({

                            icon:
                                'warning',

                            title:
                                'Perhatian',

                            text:
                                'Tanggal belum dipilih.'

                        });

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI USER
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !userIds ||
                        userIds.length === 0
                    ) {

                        Swal.fire({

                            icon:
                                'warning',

                            title:
                                'Perhatian',

                            text:
                                'Silakan pilih minimal satu user.'

                        });

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | URL
                    |--------------------------------------------------------------------------
                    */

                    const url =
                        isEdit
                            ? "{{ route('work-schedules.update') }}"
                            : "{{ route('work-schedules.store') }}";


                    /*
                    |--------------------------------------------------------------------------
                    | DATA
                    |--------------------------------------------------------------------------
                    */

                    const data = {

                        date:
                        date,

                        user_ids:
                        userIds

                    };


                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE
                    |--------------------------------------------------------------------------
                    |
                    | POST + _method=PUT
                    |
                    */

                    if (isEdit) {

                        data._method =
                            'PUT';

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | DISABLE BUTTON
                    |--------------------------------------------------------------------------
                    */

                    $('#btnSaveSchedule')
                        .prop('disabled', true);


                    $.ajax({

                        url:
                        url,

                        type:
                            'POST',

                        data:
                        data,


                        success:
                            function (response)
                            {

                                $('#scheduleModal')
                                    .modal('hide');


                                /*
                                |--------------------------------------------------------------------------
                                | REFRESH CALENDAR
                                |--------------------------------------------------------------------------
                                */

                                calendar
                                    .refetchEvents();


                                Swal.fire({

                                    icon:
                                        'success',

                                    title:
                                        'Berhasil',

                                    text:
                                    response.message,

                                    timer:
                                        1500,

                                    showConfirmButton:
                                        false

                                });

                            },


                        error:
                            function (xhr)
                            {

                                showAjaxError(
                                    xhr,
                                    'Terjadi kesalahan saat menyimpan jadwal.'
                                );

                            },


                        complete:
                            function ()
                            {

                                $('#btnSaveSchedule')
                                    .prop('disabled', false);

                            }

                    });

                }
            );


            /*
            |--------------------------------------------------------------------------
            | DELETE SEMUA JADWAL BERDASARKAN TANGGAL
            |--------------------------------------------------------------------------
            */

            $('#btnDeleteSchedule').on(
                'click',
                function ()
                {

                    if (!currentDate) {

                        return;

                    }


                    Swal.fire({

                        title:
                            'Hapus Jadwal?',

                        html:
                            'Semua jadwal user pada tanggal<br>' +
                            '<strong>' +
                            formatTanggal(
                                currentDate
                            ) +
                            '</strong><br>' +
                            'akan dihapus.',

                        icon:
                            'warning',

                        showCancelButton:
                            true,

                        confirmButtonText:
                            'Ya, Hapus',

                        cancelButtonText:
                            'Batal',

                        reverseButtons:
                            true

                    }).then(
                        function (result)
                        {

                            if (
                                !result.isConfirmed
                            ) {

                                return;

                            }


                            $('#btnDeleteSchedule')
                                .prop(
                                    'disabled',
                                    true
                                );


                            $.ajax({

                                url:
                                    "{{ route('work-schedules.destroy-by-date') }}",

                                /*
                                |--------------------------------------------------------------------------
                                | POST + _method=DELETE
                                |--------------------------------------------------------------------------
                                */

                                type:
                                    'POST',

                                data: {

                                    date:
                                    currentDate,

                                    _method:
                                        'DELETE'

                                },


                                success:
                                    function (response)
                                    {

                                        $('#scheduleModal')
                                            .modal('hide');


                                        calendar
                                            .refetchEvents();


                                        Swal.fire({

                                            icon:
                                                'success',

                                            title:
                                                'Berhasil',

                                            text:
                                            response.message,

                                            timer:
                                                1500,

                                            showConfirmButton:
                                                false

                                        });

                                    },


                                error:
                                    function (xhr)
                                    {

                                        showAjaxError(
                                            xhr,
                                            'Gagal menghapus jadwal.'
                                        );

                                    },


                                complete:
                                    function ()
                                    {

                                        $('#btnDeleteSchedule')
                                            .prop(
                                                'disabled',
                                                false
                                            );

                                    }

                            });

                        }
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | UPDATE WARNA USER
            |--------------------------------------------------------------------------
            */

            $('.user-color-picker').on(
                'change',
                function ()
                {

                    const input =
                        $(this);


                    const userId =
                        input.data(
                            'user-id'
                        );


                    const newColor =
                        input.val();


                    const oldColor =
                        input.attr(
                            'data-old-color'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | KONFIRMASI
                    |--------------------------------------------------------------------------
                    */

                    Swal.fire({

                        title:
                            'Ubah Warna User?',

                        html:
                            'Warna jadwal user akan diubah menjadi<br>' +
                            '<strong>' +
                            newColor +
                            '</strong>',

                        icon:
                            'question',

                        showCancelButton:
                            true,

                        confirmButtonText:
                            'Ya, Simpan',

                        cancelButtonText:
                            'Batal',

                        reverseButtons:
                            true

                    }).then(
                        function (result)
                        {

                            /*
                            |--------------------------------------------------------------------------
                            | BATAL
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !result.isConfirmed
                            ) {

                                input.val(
                                    oldColor
                                );

                                return;

                            }


                            input.prop(
                                'disabled',
                                true
                            );


                            $.ajax({

                                url:
                                    "{{ route('work-schedules.user-color') }}",

                                type:
                                    'POST',

                                data: {

                                    user_id:
                                    userId,

                                    schedule_color:
                                    newColor

                                },


                                success:
                                    function (response)
                                    {

                                        /*
                                        |--------------------------------------------------------------------------
                                        | SIMPAN COLOR BARU
                                        |--------------------------------------------------------------------------
                                        */

                                        input.attr(
                                            'data-old-color',
                                            newColor
                                        );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | REFRESH CALENDAR
                                        |--------------------------------------------------------------------------
                                        */

                                        calendar
                                            .refetchEvents();


                                        Swal.fire({

                                            icon:
                                                'success',

                                            title:
                                                'Berhasil',

                                            text:
                                            response.message,

                                            timer:
                                                1200,

                                            showConfirmButton:
                                                false

                                        });

                                    },


                                error:
                                    function (xhr)
                                    {

                                        /*
                                        |--------------------------------------------------------------------------
                                        | KEMBALIKAN COLOR
                                        |--------------------------------------------------------------------------
                                        */

                                        input.val(
                                            oldColor
                                        );


                                        showAjaxError(
                                            xhr,
                                            'Gagal mengubah warna user.'
                                        );

                                    },


                                complete:
                                    function ()
                                    {

                                        input.prop(
                                            'disabled',
                                            false
                                        );

                                    }

                            });

                        }
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | MODAL CLOSE
            |--------------------------------------------------------------------------
            */

            $('#scheduleModal').on(
                'hidden.bs.modal',
                function ()
                {

                    resetModal();

                    currentDate = null;

                }
            );

        });

    </script>

@endpush
