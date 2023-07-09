<!DOCTYPE html>
<html lang="en">
    <!--begin::Head-->
    <head><base href="{{url('/')}}">
        <title>{{env('APP_NAME')}} &amp; {{env('APP_VENDOR')}}</title>
        <meta charset="utf-8" />
        <meta name="description" content="{{env('APP_DESCRIPTION')}}" />
        <meta name="keywords" content="{{env('APP_NAME')}}, Virtual, Event, Awesome" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{env('APP_NAME')}} &amp; {{env('APP_VENDOR')}}" />
        <meta property="og:url" content="https://virtualexhibition.lihatlagi.id" />
        <meta property="og:site_name" content="{{env('APP_NAME')}} &amp; {{env('APP_VENDOR')}}" />
        <link rel="canonical" href="https://virtualexhibition.lihatlagi.id" />
        <link rel="shortcut icon" href="{{url('assets/media/logos/kulonfav.jpg')}}" />
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!--end::Fonts-->
        <!--begin::Global Stylesheets Bundle(used by all pages)-->
        <link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Global Stylesheets Bundle-->
    </head>
    <!--end::Head-->
    <!--begin::Body-->
    <body id="kt_body" class="auth-bg">
        <!--begin::Main-->
        <!--begin::Root-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Authentication - Signup Verify Email -->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
                    <!--begin::Logo-->
                    <a href="{{url('/')}}" class="">
                        <img alt="Logo" src="{{url('assets/media/logos/kulon.png')}}" class="h-40px mb-5" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Wrapper-->
                    <div class="pt-lg-10">
                        <!--begin::Logo-->
                        <h1 class="fw-bolder fs-2qx text-gray-800 mb-7">Link Verifkasi Tidak Dapan Ditemukan</h1>
                        <!--end::Logo-->
                        <!--begin::Message-->
                        <div class="fs-3 fw-bold text-muted mb-10">Link anda tidak ditemukan atau telah kadaluarsa. Silahkan kembali ke halaman pendaftaran untuk mendapatkan link verifikasi
                        <!--end::Message-->
                        <!--begin::Action-->
                        <div class="w-lg-600px p-10  mx-auto">
                            <button type="button" class="btn btn-lg btn-primary w-100 mb-5"
                            onclick="location.href='{{url('register')}}'" >
                            <span class="svg-icon svg-icon-2">
                                </span> <span class="indicator-label">
                                     Kembali Ke Pendaftaran</span>
                            </button>
                        </div>
                        <!--end::Action-->
                        <!--begin::Action-->
                        <!-- <div class="fs-5">
                            <span class="fw-bold text-gray-700">Did’t receive an email?</span>
                            <a href="../../demo1/dist/authentication/sign-up/basic.html" class="link-primary fw-bolder">Resend</a>
                        </div> -->
                        <!--end::Action-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Illustration-->
                    <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url({{url('assets/media/images/404.png')}}"></div>
                    <!--end::Illustration-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <div class="d-flex flex-center flex-column-auto p-10">
                    <!--begin::Links-->
                    <div class="d-flex align-items-center fw-bold fs-6">
                        <a href="https://keenthemes.com" class="text-muted text-hover-primary px-2">About</a>
                        <a href="mailto:support@keenthemes.com" class="text-muted text-hover-primary px-2">Contact</a>
                        <a href="https://1.envato.market/EA4JP" class="text-muted text-hover-primary px-2">Contact Us</a>
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Authentication - Signup Verify Email-->
        </div>
        <!--end::Root-->
        <!--end::Main-->
        <!--begin::Javascript-->

        <script>var hostUrl = "assets/";</script>
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
        <script src="{{url('assets/js/scripts.bundle.js')}}"></script>
        <!--end::Global Javascript Bundle-->
        <!--end::Javascript-->
        <script type="text/javascript">
        </script>
    </body>
    <!--end::Body-->
</html>