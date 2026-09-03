@extends('layouts.master')

@section('title', 'Jadwal Kerja')

@section('content')

    <div class="work-schedule-page">

        {{-- ========================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ========================================================= --}}

        <div class="page-header-card mb-4">

            <div class="page-header-content">

                <div class="page-header-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>

                <div>
                    <h4 class="page-title">
                        Jadwal Kerja
                    </h4>

                    <p class="page-subtitle">
                        Kelola jadwal kerja user melalui kalender secara mudah dan terorganisir.
                    </p>
                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- TODAY REPORT --}}
        {{-- ========================================================= --}}

        <div class="card schedule-card mb-4">

            <div class="card-header schedule-card-header">

                <div class="section-title-wrapper">

                    <div class="section-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <div>
                        <h5 class="section-title">
                            Today Report
                        </h5>

                        <small class="section-description">
                            Laporan aktivitas hari ini
                        </small>
                    </div>

                </div>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table
                        id="example"
                        class="table table-hover table-bordered align-middle mb-0"
                    >

                        <thead>

                        <tr>

                            <th class="text-center" width="60">
                                No
                            </th>

                            <th>
                                Action
                            </th>

                            <th>
                                Title
                            </th>

                            <th>
                                Category
                            </th>

                            <th
                                width="110"
                                class="text-center"
                            >
                                Link
                            </th>

                        </tr>

                        </thead>


                        <tbody>

                        @foreach($reports as $key => $data)

                            <tr>

                                <td class="text-center">
                                    {{ $key + 1 }}
                                </td>


                                <td>

                                    @if($data->action)

                                        <span class="report-action-badge">
                                            {{ $data->action->name }}
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <span class="report-title">
                                        {{ $data->title }}
                                    </span>

                                </td>


                                <td>

                                    @if($data->category)

                                        <span class="report-category-badge">
                                            {{ $data->category->name }}
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                <td class="text-center">

                                    <a
                                        href="{{ $data->link }}"
                                        target="_blank"
                                        class="btn btn-sm btn-primary report-view-button"
                                    >

                                        <i class="fas fa-external-link-alt mr-1"></i>

                                        View

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- CALENDAR CARD --}}
        {{-- ========================================================= --}}

        <div class="card schedule-card">

            {{-- ===================================================== --}}
            {{-- CARD HEADER --}}
            {{-- ===================================================== --}}

            <div class="card-header schedule-card-header calendar-header">

                <div class="section-title-wrapper">

                    <div class="section-icon calendar-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>

                    <div>

                        <h5 class="section-title">
                            Jadwal Kerja
                        </h5>

                        <small class="section-description">
                            Klik tanggal pada kalender untuk menambah atau mengubah jadwal.
                        </small>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- CALENDAR BODY --}}
            {{-- ===================================================== --}}

            <div class="card-body calendar-body">

                <div class="calendar-layout">

                    {{-- ================================================= --}}
                    {{-- CALENDAR --}}
                    {{-- ================================================= --}}

                    <div class="calendar-main">

                        <div id="workCalendar"></div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- USER LEGEND --}}
                    {{-- ================================================= --}}

                    <div class="calendar-sidebar">

                        <div class="calendar-sidebar-header">

                            <div class="legend-icon">
                                <i class="fas fa-users"></i>
                            </div>

                            <div>

                                <h6 class="legend-title">
                                    Keterangan User
                                </h6>

                                <small class="legend-description">
                                    Warna menunjukkan user yang memiliki jadwal kerja.
                                </small>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- USER LIST --}}
                        {{-- ================================================= --}}

                        <div
                            id="userLegend"
                            class="user-legend-list"
                        >

                            @foreach($users as $user)

                                <div
                                    class="user-legend-item"
                                    data-user-id="{{ $user->id }}"
                                >

                                    {{-- COLOR PICKER --}}

                                    <input
                                        type="color"
                                        class="user-color-picker"
                                        value="{{ $user->schedule_color ?: '#6c757d' }}"
                                        data-user-id="{{ $user->id }}"
                                        data-old-color="{{ $user->schedule_color ?: '#6c757d' }}"
                                        title="Ubah warna {{ $user->name }}"
                                    >


                                    {{-- USER INFO --}}

                                    <div class="user-legend-info">

                            <span class="user-name">
                                {{ $user->name }}
                            </span>

                                        <span class="user-color-code">
                                {{ strtoupper($user->schedule_color ?: '#6c757d') }}
                            </span>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        {{-- ================================================= --}}
                        {{-- HELP --}}
                        {{-- ================================================= --}}

                        <div class="legend-help-box">

                            <i class="fas fa-info-circle"></i>

                            <span>
                    Klik kotak warna untuk mengubah warna user.
                </span>

                        </div>

                    </div>

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
            class="modal-dialog modal-dialog-centered modal-lg"
            role="document"
        >

            <div class="modal-content schedule-modal">

                {{-- ================================================= --}}
                {{-- MODAL HEADER --}}
                {{-- ================================================= --}}

                <div class="modal-header schedule-modal-header">

                    <div class="modal-title-wrapper">

                        <div class="modal-icon">

                            <i class="fas fa-calendar-check"></i>

                        </div>

                        <div>

                            <h5
                                class="modal-title"
                                id="scheduleModalLabel"
                            >
                                Jadwal Kerja
                            </h5>

                            <small>
                                Atur user yang masuk kerja
                            </small>

                        </div>

                    </div>


                    <button
                        type="button"
                        class="close schedule-close"
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

                    <div class="modal-body schedule-modal-body">

                        {{-- ========================================= --}}
                        {{-- DATE --}}
                        {{-- ========================================= --}}

                        <div class="form-group">

                            <label
                                for="scheduleDateDisplay"
                                class="form-label-custom"
                            >

                                <i class="far fa-calendar mr-1"></i>

                                Tanggal

                            </label>


                            <div class="date-input-wrapper">

                                <span class="date-input-icon">
                                    <i class="far fa-calendar-alt"></i>
                                </span>


                                <input
                                    type="text"
                                    id="scheduleDateDisplay"
                                    class="form-control schedule-date-input"
                                    readonly
                                >

                            </div>


                            <input
                                type="hidden"
                                id="scheduleDate"
                                name="date"
                            >

                        </div>


                        {{-- ========================================= --}}
                        {{-- USER --}}
                        {{-- ========================================= --}}

                        <div class="form-group mt-4">

                            <label
                                for="userIds"
                                class="form-label-custom"
                            >

                                <i class="fas fa-users mr-1"></i>

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


                            <div class="form-helper">

                                <i class="fas fa-info-circle mr-1"></i>

                                Pilih satu atau beberapa user yang masuk kerja.

                            </div>

                        </div>


                        {{-- ========================================= --}}
                        {{-- INFO --}}
                        {{-- ========================================= --}}

                        <div
                            id="scheduleInfo"
                            class="schedule-info d-none"
                        >

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FOOTER --}}
                    {{-- ================================================= --}}

                    <div class="modal-footer schedule-modal-footer">

                        <button
                            type="button"
                            class="btn btn-danger schedule-delete-button mr-auto d-none"
                            id="btnDeleteSchedule"
                        >

                            <i class="fas fa-trash-alt mr-1"></i>

                            Hapus Jadwal

                        </button>


                        <button
                            type="button"
                            class="btn btn-light schedule-cancel-button"
                            data-dismiss="modal"
                        >

                            <i class="fas fa-times mr-1"></i>

                            Batal

                        </button>


                        <button
                            type="submit"
                            class="btn btn-primary schedule-save-button"
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
        /* =========================================================
           CALENDAR LAYOUT
        ========================================================= */

        .calendar-body {

            padding: 22px !important;

        }


        .calendar-layout {

            display: grid;

            grid-template-columns:
        minmax(0, 1fr)
        260px;

            gap: 22px;

            align-items: stretch;

        }


        /* =========================================================
           CALENDAR MAIN
        ========================================================= */

        .calendar-main {

            min-width: 0;

            background: #fff;

        }


        /* =========================================================
           CALENDAR
        ========================================================= */

        #workCalendar {

            min-height: 650px;

        }


        .fc {

            font-family: inherit;

        }


        .fc .fc-toolbar {

            margin-bottom: 20px;

        }


        .fc .fc-toolbar-title {

            font-size: 20px;

            font-weight: 700;

            color: #252b3b;

        }


        .fc .fc-button {

            border-radius: 7px !important;

            border: 0 !important;

            box-shadow: none !important;

            font-size: 12px;

            font-weight: 600;

            padding: 7px 12px;

        }


        .fc .fc-button-primary {

            background: #0d6efd;

        }


        .fc .fc-button-primary:hover {

            background: #0b5ed7;

        }


        .fc .fc-button-primary:disabled {

            background: #adb5bd;

            opacity: .8;

        }


        .fc .fc-daygrid-day {

            transition: background .2s ease;

        }


        .fc .fc-daygrid-day:hover {

            background: #f8faff;

        }


        .fc .fc-col-header-cell {

            background: #f8f9fc;

            padding: 9px 0;

        }


        .fc .fc-col-header-cell-cushion {

            color: #697386;

            font-size: 12px;

            font-weight: 700;

            text-decoration: none;

        }


        .fc .fc-daygrid-day-number {

            color: #596275;

            font-size: 12px;

            font-weight: 600;

            padding: 8px;

            text-decoration: none;

        }


        .fc .fc-day-today {

            background: rgba(13, 110, 253, .05) !important;

        }


        .fc .fc-day-today .fc-daygrid-day-number {

            background: #0d6efd;

            color: #fff;

            width: 27px;

            height: 27px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            margin: 4px;

            padding: 0;

        }


        .fc-event {

            cursor: pointer;

            border: 0 !important;

            border-radius: 5px !important;

            padding: 3px 6px !important;

            margin: 2px 4px !important;

            font-size: 11px;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, .08);

        }


        .fc-event-title {

            font-weight: 600;

        }


        /* =========================================================
           CALENDAR SIDEBAR
        ========================================================= */

        .calendar-sidebar {

            border-left: 1px solid #edf0f5;

            padding-left: 20px;

            min-height: 100%;

        }


        /* =========================================================
           SIDEBAR HEADER
        ========================================================= */

        .calendar-sidebar-header {

            display: flex;

            align-items: flex-start;

            gap: 10px;

            padding-bottom: 15px;

            margin-bottom: 15px;

            border-bottom: 1px solid #edf0f5;

        }


        .legend-icon {

            width: 36px;

            height: 36px;

            min-width: 36px;

            border-radius: 9px;

            background: #f1f5f9;

            color: #64748b;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 14px;

        }


        .legend-title {

            margin: 0;

            font-size: 14px;

            font-weight: 700;

            color: #344054;

        }


        .legend-description {

            display: block;

            color: #98a2b3;

            font-size: 10px;

            line-height: 1.5;

            margin-top: 3px;

        }


        /* =========================================================
           USER LIST
        ========================================================= */

        .user-legend-list {

            display: flex;

            flex-direction: column;

            gap: 9px;

        }


        .user-legend-item {

            display: flex;

            align-items: center;

            padding: 9px 10px;

            background: #f8fafc;

            border: 1px solid #edf0f5;

            border-radius: 9px;

            transition: all .2s ease;

        }


        .user-legend-item:hover {

            background: #fff;

            border-color: #d8dee9;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, .05);

        }


        /* =========================================================
           COLOR PICKER
        ========================================================= */

        .user-color-picker {

            width: 34px;

            height: 34px;

            padding: 2px;

            border: 1px solid #d0d5dd;

            border-radius: 7px;

            background: #fff;

            cursor: pointer;

            flex-shrink: 0;

        }


        .user-color-picker::-webkit-color-swatch-wrapper {

            padding: 0;

        }


        .user-color-picker::-webkit-color-swatch {

            border: 0;

            border-radius: 5px;

        }


        .user-color-picker:disabled {

            opacity: .5;

            cursor: wait;

        }


        /* =========================================================
           USER INFO
        ========================================================= */

        .user-legend-info {

            display: flex;

            flex-direction: column;

            margin-left: 10px;

            min-width: 0;

        }


        .user-name {

            color: #344054;

            font-size: 12px;

            font-weight: 600;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

        }


        .user-color-code {

            color: #98a2b3;

            font-size: 9px;

            margin-top: 2px;

            text-transform: uppercase;

        }


        /* =========================================================
           HELP BOX
        ========================================================= */

        .legend-help-box {

            display: flex;

            align-items: flex-start;

            gap: 7px;

            margin-top: 15px;

            padding: 10px;

            background: #f8f9fc;

            border: 1px dashed #dfe3e8;

            border-radius: 7px;

            color: #98a2b3;

            font-size: 10px;

            line-height: 1.5;

        }


        .legend-help-box i {

            margin-top: 1px;

            color: #0d6efd;

        }
        /* =========================================================
           GENERAL
        ========================================================= */

        .work-schedule-page {

            width: 100%;

        }


        .schedule-card {

            border: 0 !important;

            border-radius: 15px !important;

            overflow: hidden;

            box-shadow:
                0 4px 20px rgba(0, 0, 0, .06);

            background: #fff;

        }


        /* =========================================================
           PAGE HEADER
        ========================================================= */

        .page-header-card {

            border-radius: 15px;

            padding: 22px 25px;

            background: linear-gradient(
                135deg,
                #ffffff 0%,
                #f8faff 100%
            );

            border: 1px solid #edf0f5;

            box-shadow:
                0 4px 18px rgba(0, 0, 0, .04);

        }


        .page-header-content {

            display: flex;

            align-items: center;

            gap: 15px;

        }


        .page-header-icon {

            width: 50px;

            height: 50px;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: rgba(13, 110, 253, .10);

            color: #0d6efd;

            font-size: 21px;

        }


        .page-title {

            margin: 0;

            font-size: 22px;

            font-weight: 700;

            color: #252b3b;

        }


        .page-subtitle {

            margin: 4px 0 0;

            color: #8a92a6;

            font-size: 13px;

        }


        /* =========================================================
           CARD HEADER
        ========================================================= */

        .schedule-card-header {

            background: #fff;

            border-bottom: 1px solid #edf0f5 !important;

            padding: 18px 22px;

        }


        .section-title-wrapper {

            display: flex;

            align-items: center;

            gap: 12px;

        }


        .section-icon {

            width: 40px;

            height: 40px;

            border-radius: 10px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: rgba(13, 110, 253, .10);

            color: #0d6efd;

        }


        .calendar-icon {

            background: rgba(25, 135, 84, .10);

            color: #198754;

        }


        .section-title {

            margin: 0;

            font-size: 16px;

            font-weight: 700;

            color: #252b3b;

        }


        .section-description {

            display: block;

            margin-top: 2px;

            color: #969daf;

            font-size: 12px;

        }


        /* =========================================================
           TABLE
        ========================================================= */

        #example {

            margin-bottom: 0 !important;

        }


        #example thead th {

            background: #f8f9fc;

            color: #596275;

            font-size: 12px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .3px;

            border-color: #edf0f5;

            padding: 13px 12px;

            vertical-align: middle;

        }


        #example tbody td {

            padding: 12px;

            font-size: 13px;

            color: #596275;

            border-color: #edf0f5;

            vertical-align: middle;

        }


        #example tbody tr {

            transition: .2s ease;

        }


        #example tbody tr:hover {

            background: #f8faff;

        }


        .report-title {

            font-weight: 600;

            color: #343a40;

        }


        .report-action-badge {

            display: inline-block;

            padding: 5px 9px;

            border-radius: 6px;

            background: #eef4ff;

            color: #0d6efd;

            font-size: 11px;

            font-weight: 600;

        }


        .report-category-badge {

            display: inline-block;

            padding: 5px 9px;

            border-radius: 6px;

            background: #f2f4f7;

            color: #667085;

            font-size: 11px;

            font-weight: 600;

        }


        .report-view-button {

            min-width: 75px;

            border-radius: 6px;

            font-size: 12px;

        }


        /* =========================================================
           CALENDAR
        ========================================================= */

        .calendar-body {

            padding: 22px !important;

        }


        .calendar-wrapper {

            width: 100%;

            background: #fff;

        }


        #workCalendar {

            min-height: 650px;

        }


        .fc {

            font-family: inherit;

        }


        .fc .fc-toolbar {

            margin-bottom: 20px;

        }


        .fc .fc-toolbar-title {

            font-size: 20px;

            font-weight: 700;

            color: #252b3b;

        }


        .fc .fc-button {

            border-radius: 7px !important;

            border: 0 !important;

            box-shadow: none !important;

            font-size: 12px;

            font-weight: 600;

            padding: 7px 12px;

        }


        .fc .fc-button-primary {

            background: #0d6efd;

        }


        .fc .fc-button-primary:hover {

            background: #0b5ed7;

        }


        .fc .fc-button-primary:disabled {

            background: #adb5bd;

            opacity: .8;

        }


        .fc .fc-daygrid-day {

            transition: background .2s ease;

        }


        .fc .fc-daygrid-day:hover {

            background: #f8faff;

        }


        .fc .fc-col-header-cell {

            background: #f8f9fc;

            padding: 9px 0;

        }


        .fc .fc-col-header-cell-cushion {

            color: #697386;

            font-size: 12px;

            font-weight: 700;

            text-decoration: none;

        }


        .fc .fc-daygrid-day-number {

            color: #596275;

            font-size: 12px;

            font-weight: 600;

            padding: 8px;

            text-decoration: none;

        }


        .fc .fc-day-today {

            background: rgba(13, 110, 253, .05) !important;

        }


        .fc .fc-day-today .fc-daygrid-day-number {

            background: #0d6efd;

            color: #fff;

            width: 27px;

            height: 27px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            margin: 4px;

            padding: 0;

        }


        .fc-event {

            cursor: pointer;

            border: 0 !important;

            border-radius: 5px !important;

            padding: 3px 6px !important;

            margin: 2px 4px !important;

            font-size: 11px;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, .08);

        }


        .fc-event-title {

            font-weight: 600;

        }


        /* =========================================================
           USER LEGEND
        ========================================================= */

        .user-legend-section {

            padding-top: 20px;

            border-top: 1px solid #edf0f5;

        }


        .legend-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 15px;

        }


        .legend-title-wrapper {

            display: flex;

            align-items: center;

            gap: 10px;

        }


        .legend-icon {

            width: 34px;

            height: 34px;

            border-radius: 8px;

            background: #f1f5f9;

            color: #64748b;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 13px;

        }


        .legend-title {

            margin: 0;

            font-size: 14px;

            font-weight: 700;

            color: #344054;

        }


        .legend-description {

            color: #98a2b3;

            font-size: 11px;

        }


        .legend-help {

            font-size: 11px;

            color: #98a2b3;

            white-space: nowrap;

        }


        .user-legend-list {

            display: flex;

            flex-wrap: wrap;

            gap: 10px;

        }


        .user-legend-item {

            display: flex;

            align-items: center;

            min-width: 170px;

            padding: 8px 11px;

            background: #f8fafc;

            border: 1px solid #edf0f5;

            border-radius: 9px;

            transition: all .2s ease;

        }


        .user-legend-item:hover {

            background: #fff;

            border-color: #d8dee9;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, .05);

        }


        .user-color-picker {

            width: 31px;

            height: 31px;

            padding: 2px;

            border: 1px solid #d0d5dd;

            border-radius: 7px;

            background: #fff;

            cursor: pointer;

            flex-shrink: 0;

        }


        .user-color-picker::-webkit-color-swatch-wrapper {

            padding: 0;

        }


        .user-color-picker::-webkit-color-swatch {

            border: 0;

            border-radius: 5px;

        }


        .user-legend-info {

            display: flex;

            flex-direction: column;

            margin-left: 9px;

            min-width: 0;

        }


        .user-name {

            color: #344054;

            font-size: 12px;

            font-weight: 600;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

            max-width: 120px;

        }


        .user-color-code {

            color: #98a2b3;

            font-size: 9px;

            margin-top: 1px;

            text-transform: uppercase;

        }


        /* =========================================================
           MODAL
        ========================================================= */

        .schedule-modal {

            border: 0;

            border-radius: 14px;

            overflow: hidden;

            box-shadow:
                0 15px 50px rgba(0, 0, 0, .15);

        }


        .schedule-modal-header {

            background: #f8faff;

            border-bottom: 1px solid #edf0f5;

            padding: 17px 20px;

        }


        .modal-title-wrapper {

            display: flex;

            align-items: center;

            gap: 11px;

        }


        .modal-icon {

            width: 40px;

            height: 40px;

            border-radius: 10px;

            background: rgba(13, 110, 253, .10);

            color: #0d6efd;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .schedule-modal-header .modal-title {

            font-size: 16px;

            font-weight: 700;

            color: #252b3b;

        }


        .schedule-modal-header small {

            display: block;

            color: #98a2b3;

            font-size: 11px;

            margin-top: 2px;

        }


        .schedule-close {

            font-size: 23px;

            color: #667085;

            opacity: .7;

            outline: none !important;

        }


        .schedule-close:hover {

            opacity: 1;

        }


        .schedule-modal-body {

            padding: 23px;

        }


        .form-label-custom {

            display: block;

            margin-bottom: 8px;

            color: #344054;

            font-size: 12px;

            font-weight: 700;

        }


        .date-input-wrapper {

            position: relative;

        }


        .date-input-icon {

            position: absolute;

            left: 12px;

            top: 50%;

            transform: translateY(-50%);

            color: #98a2b3;

            z-index: 2;

        }


        .schedule-date-input {

            height: 40px;

            padding-left: 37px;

            background: #f8fafc !important;

            border-color: #e4e7ec;

            color: #344054;

            font-size: 13px;

            font-weight: 600;

        }


        .schedule-date-input:focus {

            box-shadow: none;

            border-color: #98a2b3;

        }


        /* =========================================================
           SELECT2
        ========================================================= */

        .select2-container {

            width: 100% !important;

        }


        .select2-container--default
        .select2-selection--multiple {

            min-height: 42px;

            border: 1px solid #d0d5dd;

            border-radius: 7px;

            padding: 3px 5px;

            transition: border .2s ease;

        }


        .select2-container--default
        .select2-selection--multiple:focus {

            border-color: #86b7fe;

        }


        .select2-container--default
        .select2-selection--multiple
        .select2-selection__choice {

            margin-top: 4px;

            background: #eef4ff;

            border: 1px solid #d8e5ff;

            color: #0d6efd;

            border-radius: 5px;

            font-size: 11px;

            font-weight: 600;

            padding: 3px 7px;

        }


        .select2-container--default
        .select2-selection--multiple
        .select2-selection__choice__remove {

            color: #0d6efd;

            margin-right: 4px;

            border-right: 0;

        }


        .select2-dropdown {

            border-color: #d0d5dd;

            border-radius: 7px;

            overflow: hidden;

            box-shadow:
                0 8px 20px rgba(0, 0, 0, .08);

        }


        .select2-results__option {

            font-size: 12px;

            padding: 8px 10px;

        }


        .select2-results__option--highlighted {

            background: #0d6efd !important;

        }


        .form-helper {

            margin-top: 7px;

            color: #98a2b3;

            font-size: 10px;

        }


        /* =========================================================
           INFO
        ========================================================= */

        .schedule-info {

            margin-top: 18px;

            padding: 11px 13px;

            background: #eff6ff;

            border: 1px solid #dbeafe;

            border-radius: 7px;

            color: #1d4ed8;

            font-size: 11px;

        }


        /* =========================================================
           MODAL FOOTER
        ========================================================= */

        .schedule-modal-footer {

            background: #fafbfc;

            border-top: 1px solid #edf0f5;

            padding: 13px 20px;

        }


        .schedule-modal-footer .btn {

            border-radius: 7px;

            font-size: 12px;

            font-weight: 600;

            padding: 8px 14px;

        }


        .schedule-cancel-button {

            border: 1px solid #d0d5dd;

            color: #667085;

            background: #fff;

        }


        .schedule-save-button {

            min-width: 125px;

        }


        .schedule-delete-button {

            min-width: 120px;

        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 768px) {

            .page-header-card {

                padding: 17px;

            }


            .page-title {

                font-size: 18px;

            }


            .page-subtitle {

                font-size: 11px;

            }


            .calendar-body {

                padding: 12px !important;

            }


            .fc .fc-toolbar {

                display: flex;

                flex-wrap: wrap;

                gap: 8px;

            }


            .fc .fc-toolbar-title {

                font-size: 16px;

            }


            .fc .fc-toolbar-chunk {

                display: flex;

                align-items: center;

            }


            .legend-header {

                align-items: flex-start;

                flex-direction: column;

            }


            .legend-help {

                white-space: normal;

            }


            .user-legend-item {

                min-width: 150px;

                flex: 1;

            }


            #workCalendar {

                min-height: 500px;

            }

        }


        @media (max-width: 576px) {

            .schedule-card-header {

                padding: 15px;

            }


            .section-description {

                display: none;

            }


            .calendar-body {

                padding: 8px !important;

            }


            .user-legend-list {

                display: grid;

                grid-template-columns: repeat(
                    2,
                    minmax(0, 1fr)
                );

                gap: 7px;

            }


            .user-legend-item {

                min-width: 0;

            }


            .user-name {

                max-width: 85px;

            }


            .fc .fc-toolbar-title {

                font-size: 14px;

            }


            .fc .fc-button {

                padding: 5px 8px;

                font-size: 10px;

            }


            .schedule-modal-body {

                padding: 17px;

            }


            .schedule-modal-footer {

                flex-wrap: wrap;

            }

        }

    </style>

@endpush


{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

@push('js')

    {{-- ============================================================= --}}
    {{-- SWEETALERT2 --}}
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
            | DEPENDENCY CHECK
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


                        $('#userIds')
                            .val(userIds)
                            .trigger('change')
                            .prop('disabled', false);


                        /*
                        |--------------------------------------------------------------------------
                        | EXISTING SCHEDULE
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
                                    '<i class="fas fa-check-circle mr-1"></i>' +
                                    '<strong>' +
                                    userIds.length +
                                    '</strong> user sudah dijadwalkan pada tanggal ini.'
                                );

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | NEW SCHEDULE
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
                        'Terjadi Kesalahan',

                    html:
                    message

                });

            }


            /*
            |--------------------------------------------------------------------------
            | FULLCALENDAR
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
                                        'Gagal',

                                    text:
                                        'Gagal mengambil data jadwal.'

                                });

                            }

                        },


                        dateClick:
                            function (info)
                            {

                                openScheduleModal(
                                    info.dateStr
                                );

                            },


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
            | SAVE / UPDATE
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


                    const url =
                        isEdit
                            ? "{{ route('work-schedules.update') }}"
                            : "{{ route('work-schedules.store') }}";


                    const data = {

                        date:
                        date,

                        user_ids:
                        userIds

                    };


                    if (isEdit) {

                        data._method =
                            'PUT';

                    }


                    $('#btnSaveSchedule')
                        .prop(
                            'disabled',
                            true
                        );


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
                                    .prop(
                                        'disabled',
                                        false
                                    );

                            }

                    });

                }
            );


            /*
            |--------------------------------------------------------------------------
            | DELETE BY DATE
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
                            '<i class="fas fa-trash mr-1"></i> Ya, Hapus',

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
            | UPDATE USER COLOR
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


                    Swal.fire({

                        title:
                            'Ubah Warna User?',

                        html:
                            'Warna jadwal akan diubah menjadi<br>' +
                            '<strong>' +
                            newColor.toUpperCase() +
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

                                        input.attr(
                                            'data-old-color',
                                            newColor
                                        );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | UPDATE HEX COLOR TEXT
                                        |--------------------------------------------------------------------------
                                        */

                                        input
                                            .closest(
                                                '.user-legend-item'
                                            )
                                            .find(
                                                '.user-color-code'
                                            )
                                            .text(
                                                newColor.toUpperCase()
                                            );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | REFRESH EVENT
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
            | MODAL CLOSED
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
