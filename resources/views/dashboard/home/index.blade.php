@extends('layouts.dashboard.header')
@section('content')
    <div class="content d-flex flex-column" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dashboard</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('home') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-dark">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>

        <!--begin::Post-->
        <div class="post d-flex" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Row-->
                @if (Auth::user()->role == 'admin')
                <p align="center" style="font-size: 20px;font-weight: bold;">General Informartion Of User</p>
                    <div class="row gy-5 g-xl-8">
                        <div class="col bg-primary px-6 py-8 rounded-2 me-3 mb-7">
                            <div class="row">
                                <div class="col-6">
                                    <span class="svg-icon svg-icon-3x svg-icon-white d-block mt-5 mb-2">
                                        <i class="fa fa-user fs-1 text-white"></i>
                                    </span>
                                    <a href="{{ url('/user/manager_index') }}" class="text-white fw-bold fs-6">Manager</a>
                                </div>
                                <div class="col-6 d-flex align-items-center">
                                    <h1 class="text-white">{{ $manager }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col bg-info px-6 py-8 rounded-2 me-3 mb-7">
                            <div class="row">
                                <div class="col-6">
                                    <span class="svg-icon svg-icon-3x svg-icon-white d-block mt-5 mb-2">
                                        <i class="fa fa-user fs-1 text-white"></i>
                                    </span>
                                    <a href="/user/teller_index" class="text-white fw-bold fs-6">Teller</a>
                                </div>
                                <div class="col-6 d-flex align-items-center">
                                    <h1 class="text-white">{{ $teller }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col bg-warning px-6 py-8 rounded-2 me-3 mb-7">
                            <div class="row">
                                <div class="col-6">
                                    <span class="svg-icon svg-icon-3x svg-icon-white d-block mt-5 mb-2">
                                        <i class="fa fa-user fs-1 text-white"></i>
                                    </span>
                                    <a href="/user/financing_service_index" class="text-white fw-bold fs-6">Financing
                                        Service</a>
                                </div>
                                <div class="col-6 d-flex align-items-center">
                                    <h1 class="text-white">{{ $financingService }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col bg-danger px-6 py-8 rounded-2 me-3 mb-7">
                            <div class="row">
                                <div class="col-6">
                                    <span class="svg-icon svg-icon-3x svg-icon-white d-block mt-5 mb-2">
                                        <i class="fa fa-user fs-1 text-white"></i>
                                    </span>
                                    <a href="/user/customer_service_index" class="text-white fw-bold fs-6">Customer
                                        Service</a>
                                </div>
                                <div class="col-6 d-flex align-items-center">
                                    <h1 class="text-white">{{ $customerService }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col bg-success px-6 py-8 rounded-2 me-3 mb-7">
                            <div class="row">
                                <div class="col-6">
                                    <span class="svg-icon svg-icon-3x svg-icon-white d-block mt-5 mb-2">
                                        <i class="fa fa-user fs-1 text-white"></i>
                                    </span>
                                    <a href="/user/marketing_index" class="text-white fw-bold fs-6">Marketing</a>
                                </div>
                                <div class="col-6 d-flex align-items-center">
                                    <h1 class="text-white">{{ $marketing }}</h1>
                                </div>
                            </div>
                        </div>

                    </div>
                @endif
                <p align="center" style="font-size: 20px;font-weight: bold;">General Informartion Of Assignment</p>
                <div class="row gy-5 g-xl-8">
                    <div class="col bg-info px-6 py-8 rounded-2 me-3 mb-7">
                        <div class="row">
                            <div class="col-7">
                                <span class="svg-icon svg-icon-3x svg-icon-white d-block mt-5 mb-2">
                                    <i class="fas fa-users fs-1 text-white"></i>
                                </span>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                    <a href="{{ url('/layanan/assignment_index') }}" class="text-white fw-bold "> Assignment</a>
                                @else
                                    @if (Auth::user()->role == 'customer_service')
                                        <a href="{{ url('/layanan/customer_service_submission_index') }}"
                                            class="text-white fw-bold "> Submission</a>
                                    @elseif(Auth::user()->role == 'financing_service')
                                        <a href="{{ url('/layanan/financing_service_submission_index') }}"
                                            class="text-white fw-bold "> Submission</a>
                                    @elseif(Auth::user()->role == 'teller')
                                        <a href="{{ url('/layanan/teller_submission_index') }}"
                                            class="text-white fw-bold "> Submission</a>
                                    @elseif(Auth::user()->role == 'marketing')
                                        <a href="{{ url('/layanan/marketing_assignment_index') }}"
                                            class="text-white fw-bold "> Assignment</a>
                                    @endif
                                @endif
                            </div>
                            <div class="col-5 d-flex align-items-center">
                                <h1 class="text-white">{{ $assignment }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col bg-danger px-6 py-8 rounded-2 me-3 mb-7">
                        <div class="row">
                            <div class="col-7">
                                <span class="svg-icon svg-icon-3x svg-icon-white d-block mt-5 mb-2">
                                    <i class="fa fa-free-code-camp fs-1 text-white"></i>
                                </span>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                    <a href="{{ url('/layanan/assignment_index') }}?type=hot"
                                        class="text-white fw-bold ">HOT</a>
                                @else
                                    @if (Auth::user()->role == 'customer_service')
                                        <a href="{{ url('/layanan/customer_service_submission_index') }}?type=hot"
                                            class="text-white fw-bold ">HOT</a>
                                    @elseif(Auth::user()->role == 'financing_service')
                                        <a href="{{ url('/layanan/financing_service_submission_index') }}?type=hot"
                                            class="text-white fw-bold ">HOT</a>
                                    @elseif(Auth::user()->role == 'teller')
                                        <a href="{{ url('/layanan/teller_submission_index') }}?type=hot"
                                            class="text-white fw-bold ">HOT</a>
                                    @elseif(Auth::user()->role == 'marketing')
                                        <a href="{{ url('/layanan/marketing_assignment_index') }}?type=hot"
                                            class="text-white fw-bold ">HOT</a>
                                    @endif
                                @endif
                            </div>
                            <div class="col-5 d-flex align-items-center">
                                <h1 class="text-white">{{ $hot }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col bg-warning px-6 py-8 rounded-2 me-3 mb-7">
                        <div class="row">
                            <div class="col-7">
                                <span class="svg-icon svg-icon-3x svg-icon-white d-block mt-5 mb-2">
                                    <i class="fa fa-fire fs-1 text-white"></i>
                                </span>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                    <a href="{{ url('/layanan/assignment_index') }}?type=warm"
                                        class="text-white fw-bold ">Warm</a>
                                @else
                                    @if (Auth::user()->role == 'customer_service')
                                        <a href="{{ url('/layanan/customer_service_submission_index') }}?type=warm"
                                            class="text-white fw-bold ">Warm</a>
                                    @elseif(Auth::user()->role == 'financing_service')
                                        <a href="{{ url('/layanan/financing_service_submission_index') }}?type=warm"
                                            class="text-white fw-bold ">Warm</a>
                                    @elseif(Auth::user()->role == 'teller')
                                        <a href="{{ url('/layanan/teller_submission_index') }}?type=warm"
                                            class="text-white fw-bold ">Warm</a>
                                    @elseif(Auth::user()->role == 'marketing')
                                        <a href="{{ url('/layanan/marketing_assignment_index') }}?type=warm"
                                            class="text-white fw-bold ">Warm</a>                               
                                    @endif
                                @endif
                            </div>
                            <div class="col-5 d-flex align-items-center">
                                <h1 class="text-white">{{ $warm }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col bg-info px-6 py-8 rounded-2 me-3 mb-7">
                        <div class="row">
                            <div class="col-7">
                                <span class="svg-icon svg-icon-3x svg-icon-white d-block mt-5 mb-2">
                                    <i class="fa fa-times fs-1 text-white"></i>
                                </span>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                    <a href="{{ url('/layanan/assignment_index') }}?type=cold"
                                        class="text-white fw-bold ">Cold</a>
                                @else
                                    @if (Auth::user()->role == 'customer_service')
                                        <a href="{{ url('/layanan/customer_service_submission_index') }}?type=cold"
                                            class="text-white fw-bold ">Cold</a>
                                    @elseif(Auth::user()->role == 'financing_service')
                                        <a href="{{ url('/layanan/financing_service_submission_index') }}?type=cold"
                                            class="text-white fw-bold ">Cold</a>
                                    @elseif(Auth::user()->role == 'teller')
                                        <a href="{{ url('/layanan/teller_submission_index') }}?type=cold"
                                            class="text-white fw-bold ">Cold</a>
                                    @elseif(Auth::user()->role == 'marketing')
                                        <a href="{{ url('/layanan/marketing_assignment_index') }}?type=cold"
                                            class="text-white fw-bold ">Cold</a>
                                    @endif
                                @endif
                            </div>
                            <div class="col-5 d-flex align-items-center">
                                <h1 class="text-white">{{ $cold }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col bg-primary px-6 py-8 rounded-2 me-3 mb-7">
                        <div class="row">
                            <div class="col-7">
                                <span class="svg-icon svg-icon-3x svg-icon-white d-block mt-5 mb-2">
                                    <i class="fa fa-ban fs-1 text-white"></i>
                                </span>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                    <a href="{{ url('/layanan/assignment_index') }}?type=closed"
                                        class="text-white fw-bold ">Closed</a>
                                @else
                                    @if (Auth::user()->role == 'customer_service')
                                        <a href="{{ url('/layanan/customer_service_submission_index') }}?type=closed"
                                            class="text-white fw-bold ">Closed</a>
                                    @elseif(Auth::user()->role == 'financing_service')
                                        <a href="{{ url('/layanan/financing_service_submission_index') }}?type=closed"
                                            class="text-white fw-bold ">Closed</a>
                                    @elseif(Auth::user()->role == 'teller')
                                        <a href="{{ url('/layanan/teller_submission_index') }}?type=closed"
                                            class="text-white fw-bold ">Closed</a>
                                    @elseif(Auth::user()->role == 'marketing')
                                        <a href="{{ url('/layanan/marketing_assignment_index') }}?type=closed"
                                            class="text-white fw-bold ">Closed</a>
                                    @endif
                                @endif
                            </div>
                            <div class="col-5 d-flex align-items-center">
                                <h1 class="text-white">{{ $closed }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
@endsection
@section('scriptcustom')
    <script src="https://use.fontawesome.com/f2fc9ac3b2.js"></script>
@endsection
