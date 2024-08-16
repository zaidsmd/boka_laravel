@php use Carbon\Carbon; @endphp
@extends('back_office.admin_layouts.main')
@section('document-title','Tableau de bord')
@push('css')
    <link href="{{ asset('libs/daterangepicker/css/daterangepicker.min.css') }}" rel="stylesheet">
    <style>
        .last-col {
            width: 1%;
            white-space: nowrap;
        }
    </style>
    <style>
        .__dashboard_item {
            transform-origin: 50% 10%;
            position: relative;
        }
        .__dashboard_item.__dashboard_item_hide {
            visibility: hidden;
            position: absolute !important;
        }
        .__dashboard_item.__dashboard_item_hide>div {
            opacity: 50% !important;
        }
        .__dashboard_item.__customize_state ,.__dashboard_sortable_item.__sortable_state {
            overflow: visible !important;
            opacity: 90%;
        }
        .__dashboard_item-eye , .__dashboard_item-sort-cursor {
            position: absolute;
            top: 0;
            right: 0;
            transform:translateY(-50%) translateX(50%);
            width: 25px;
            height: 25px;
            background-color: var(--bs-primary);
            color : white ;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--bs-box-shadow);
            border-radius: 50%;
        }

        .__dashboard_item.__customize_state.__dashboard_item_hide {
            position: static !important;
            visibility: visible !important;
        }
        .__dashboard_item.__customize_state > div ,.__dashboard_sortable_item.__sortable_state > div{
            border: 1px dashed var(--bs-primary) !important;
            overflow: visible !important;
            box-sizing: border-box;
            position: relative;

        }


    </style>
@endpush
@section('section')
    <div class="row ">
        <div class="col-12 mb-4">
            <div class="card-title m-0 p-2 pt-0">
                <div id="__fixed"
                     class="d-flex flex-wrap flex-sm-nowrap  switch-filter justify-content-between align-items-center">
                    <h5 class="m-0 ">
                    </h5>
                    <div class="page-title-right col-xl-3 col-lg-4 col-md-5 col-sm-6 col-12 mt-2 mt-sm-0">
                        <form action="{{route('tableau_de_bord.liste')}}" method="get">
                            <div class="input-group  border-1 border border-light rounded" id="datepicker1">
                                <input type="text" class="form-control datepicker text-primary ps-2 "
                                       id="i_date"
                                       placeholder="mm/dd/yyyy"
                                       name="i_date" readonly>
                                <span class="input-group-text text-primary"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row __dashboard_container">

        <h5 class="m-0 float-end ms-3" style="margin-top: .1rem!important"><i class="mdi mdi-chart-bell-curve-cumulative me-2 text-success"></i>
            مؤشرات الطلبات
            <span class="text-muted opacity-75 font-size-12 text-nowrap text-truncate"></span>
        </h5>
        <hr  class="border mt-3">

        <div class="col-xl-3 col-12 col-md-6 __dashboard_item __dashboard_sortable_item">
            <div class="card overflow-hidden">
                <div class="card-body bg-soft-success text-dark overflow-hidden rounded">
                    <div class="d-flex flex-nowrap align-items-center">
                        <i class="fa fa-spinner text-success fa-3x"></i>
                        <div class="ms-4">
                            <h4 class="text-dark dashboard-text">
                                {{$processing}}
                            </h4>
                            <h6 class="m-0 text-dark">عدد الطلبات قيد المعالجة</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipped Orders -->
        <div class="col-xl-3 col-12 col-md-6 __dashboard_item __dashboard_sortable_item">
            <div class="card overflow-hidden">
                <div class="card-body bg-soft-primary text-light overflow-hidden rounded">
                    <div class="d-flex flex-nowrap align-items-center">
                        <i class="fa fa-truck text-primary fa-3x"></i>
                        <div class="ms-4">
                            <h4 class="text-dark dashboard-text">
                                {{$shipped}}
                            </h4>
                            <h6 class="m-0 text-dark">عدد الطلبات المُرسلة</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-12 col-md-6 __dashboard_item __dashboard_sortable_item">
            <div class="card overflow-hidden">
                <div class="card-body bg-soft-warning text-light overflow-hidden rounded">
                    <div class="d-flex flex-nowrap align-items-center">
                        <i class="fa fa-check-circle text-warning fa-3x"></i>
                        <div class="ms-4">
                            <h4 class="text-dark dashboard-text">
                                {{$delivered}}
                            </h4>
                            <h6 class="m-0 text-dark">عدد الطلبات الموصلة</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Canceled Orders -->
        <div class="col-xl-3 col-12 col-md-6 __dashboard_item __dashboard_sortable_item">
            <div class="card overflow-hidden">
                <div class="card-body bg-soft-danger text-light overflow-hidden rounded">
                    <div class="d-flex flex-nowrap align-items-center">
                        <i class="fa fa-ban text-danger fa-3x"></i>
                        <div class="ms-4">
                            <h4 class="text-dark dashboard-text">
                                {{$canceled}}
                            </h4>
                            <h6 class="m-0 text-dark">عدد الطلبات الملغاة</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Number of Products -->

    <br>
    <br>
    <div class="row __dashboard_container">

        <h5 class="m-0 float-end ms-3" style="margin-top: .1rem!important"><i class="mdi mdi-chart-bell-curve-cumulative me-2 text-success"></i>
            مؤشرات النظام
            <span class="text-muted opacity-75 font-size-12 text-nowrap text-truncate"></span>
        </h5>
        <hr  class="border mt-3">

        <div class="col-xl-3 col-12 col-md-6 __dashboard_item __dashboard_sortable_item">
            <div class="card overflow-hidden">
                <div class="card-body bg-soft-success text-light overflow-hidden rounded">
                    <div class="d-flex flex-nowrap align-items-center">
                        <i class="fa fa-box text-success fa-3x"></i>
                        <div class="ms-4">
                            <h4 class="text-dark dashboard-text">
                                {{$articles}}
                            </h4>
                            <h6 class="m-0 text-dark">عدد المنتجات</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Number of Categories -->
        <div class="col-xl-3 col-12 col-md-6 __dashboard_item __dashboard_sortable_item">
            <div class="card overflow-hidden">
                <div class="card-body bg-soft-primary text-light overflow-hidden rounded">
                    <div class="d-flex flex-nowrap align-items-center">
                        <i class="fa fa-tags text-primary fa-3x"></i>
                        <div class="ms-4">
                            <h4 class="text-dark dashboard-text">
                                {{$categories}}
                            </h4>
                            <h6 class="m-0 text-dark">عدد الفئات</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Number of Tags -->
        <div class="col-xl-3 col-12 col-md-6 __dashboard_item __dashboard_sortable_item">
            <div class="card overflow-hidden">
                <div class="card-body bg-soft-warning text-light overflow-hidden rounded">
                    <div class="d-flex flex-nowrap align-items-center">
                        <i class="fa fa-tag text-warning fa-3x"></i>
                        <div class="ms-4">
                            <h4 class="text-dark dashboard-text">
                                {{$tags}}
                            </h4>
                            <h6 class="m-0 text-dark">عدد الوسوم</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Number of Users -->
        <div class="col-xl-3 col-12 col-md-6 __dashboard_item __dashboard_sortable_item">
            <div class="card overflow-hidden">
                <div class="card-body bg-soft-danger text-light overflow-hidden rounded">
                    <div class="d-flex flex-nowrap align-items-center">
                        <i class="fa fa-users text-danger fa-3x"></i>
                        <div class="ms-4">
                            <h4 class="text-dark dashboard-text">
                                {{$utilisateurs}}
                            </h4>
                            <h6 class="m-0 text-dark">عدد المستخدمين</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

    <script src="{{asset('libs/daterangepicker/js/daterangepicker.js')}}"></script>
    <script src="{{asset('libs/moment/min/moment-with-locales.min.js')}}"></script>


    <script>
        const __datepicker_dates = {
            "اليوم": ['{{ Carbon::today()->format('d/m/Y') }}', '{{ Carbon::today()->format('d/m/Y') }}'],
            'هذا الشهر': ['{{ Carbon::today()->firstOfMonth()->format('d/m/Y') }}', '{{ Carbon::today()->lastOfMonth()->format('d/m/Y') }}'],
            "الربع الأول": ['{{ Carbon::today()->firstOfYear()->format('d/m/Y') }}', '{{ Carbon::today()->addMonths(2)->lastOfMonth()->format('d/m/Y') }}'],
            'الربع الثاني': ['{{ Carbon::today()->addMonths(3)->firstOfMonth()->format('d/m/Y') }}', '{{ Carbon::today()->addMonths(5)->lastOfMonth()->format('d/m/Y') }}'],
            'الربع الثالث': ['{{ Carbon::today()->addMonths(6)->firstOfMonth()->format('d/m/Y') }}', '{{ Carbon::today()->addMonths(8)->lastOfMonth()->format('d/m/Y') }}'],
            'الربع الرابع': ['{{ Carbon::today()->addMonths(9)->firstOfMonth()->format('d/m/Y') }}', '{{ Carbon::today()->addMonths(11)->lastOfMonth()->format('d/m/Y') }}'],
            'آخر 30 يومًا': ['{{ Carbon::today()->subDays(29)->format('d/m/Y') }}', '{{ Carbon::today()->format('d/m/Y') }}'],
            'الشهر الماضي': ['{{ Carbon::today()->subMonths(1)->firstOfMonth()->format('d/m/Y') }}', '{{ Carbon::today()->subMonths(1)->lastOfMonth()->format('d/m/Y') }}'],
            'هذه السنة': ['{{ Carbon::today()->firstOfYear()->format('d/m/Y') }}', '{{ Carbon::today()->lastOfYear()->format('d/m/Y') }}'],
        };

{{--        @dd($date_picker_start->format('d/m/Y'))--}}
        const __datepicker_start_date = '{{ $date_picker_start->format('d/m/Y') }}';
        const __datepicker_end_date = '{{ $date_picker_end->format('d/m/Y') }}';
        const __datepicker_min_date = '{{ Carbon::today()->firstOfYear()->format('d/m/Y') }}';
        const __datepicker_max_date = '{{ Carbon::today()->lastOfYear()->format('d/m/Y') }}';

        $('.datepicker').daterangepicker({
            ranges: __datepicker_dates,
            locale: {
                format: "DD/MM/YYYY",
                separator: " - ",
                applyLabel: "تطبيق",
                cancelLabel: "إلغاء",
                fromLabel: "من",
                toLabel: "إلى",
                customRangeLabel: "نطاق مخصص",
                weekLabel: "أ",
                daysOfWeek: [
                    "أحد",
                    "اثنين",
                    "ثلاثاء",
                    "أربعاء",
                    "خميس",
                    "جمعة",
                    "سبت"
                ],
                monthNames: [
                    "يناير",
                    "فبراير",
                    "مارس",
                    "أبريل",
                    "مايو",
                    "يونيو",
                    "يوليو",
                    "أغسطس",
                    "سبتمبر",
                    "أكتوبر",
                    "نوفمبر",
                    "ديسمبر"
                ],
                firstDay: 6 // Set the first day of the week to Saturday
            },
            startDate: moment(__datepicker_start_date, "DD/MM/YYYY"),
            endDate: moment(__datepicker_end_date, "DD/MM/YYYY"),
            minDate: moment(__datepicker_min_date, "DD/MM/YYYY"),
            maxDate: moment(__datepicker_max_date, "DD/MM/YYYY")
        });

        $('#i_date').change(function () {
            $(this).closest('form').submit();
        });
    </script>

@endpush
