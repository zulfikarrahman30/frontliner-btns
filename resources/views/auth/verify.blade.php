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
                        <h1 class="fw-bolder fs-2qx text-gray-800 mb-7">Verify Method</h1>
                        <!--end::Logo-->
                        <!--begin::Message-->
                        <div class="fs-3 fw-bold text-muted mb-10">Link verifikasi akan dikirimkan silakan klik tombol berikut:
                        <!--end::Message-->
                        <!--begin::Action-->
                        <div class="w-lg-600px p-10  mx-auto">
                           <button type="button" 
                           onclick="setMethod('email',this)" 
                           style="border: 1px solid black;" 
                            class="btn btn-lg btn-default w-100 mb-5">
                            <span class="svg-icon svg-icon-2">
                                <img src="https://icons.getbootstrap.com/assets/icons/envelope.svg" 
                                    width="24" height="24" style=" fill:#000000;">
                                </span> 
                                <span class="indicator-label">
                                     Verify with email</span>
                            </button>
                            <button type="button" class="btn btn-lg btn-primary w-100 mb-5"
                            onclick="setMethod('wa',this)" >
                            <span class="svg-icon svg-icon-2">
                                <img src="https://icons.getbootstrap.com/assets/icons/whatsapp.svg" 
                                    width="24" height="24" style=" fill:#000000;">
                                </span> <span class="indicator-label">
                                     Verify with whatsapp</span>
                            </button>
                        </div>

                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Illustration-->
                    <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url({{url('assets/media/images/verify.png')}}"></div>
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
                </div>
            </div>
        </div>
        <script>var hostUrl = "assets/";</script>
        <script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
        <script src="{{url('assets/js/scripts.bundle.js')}}"></script>
        <script type="text/javascript">
            function setMethod(action,me) {
                localStorage.removeItem('action', action);
                localStorage.setItem('action', action);
                me.disabled=true; 
                me.innerText='Sedang memproses pengiriman';
                var CSRF_TOKEN = "{{ csrf_token() }}";
                var temp=[];
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        }
                    });
                    var formSend = new FormData();
                    formSend.append('choose', action); 
                    if(action == 'wa'){
                        formSend.append('email', '{{$data->phone}}');
                    }else{
                        formSend.append('email', '{{$data->email}}');
                    } 
                    formSend.append('action', 'send'); 
                        $.ajax({
                              type: "POST",
                              url: "{{url('send_verify')}}", 
                              data: formSend,
                              success: function (data) {
                                    if(data.data == 'success'){
                                        alert('success mengirim pesan');
                                        location.href='{{url('verify')}}'+'/'+action;
                                    }else{
                                        alert('mohon maaf saat ini sedang ternajdi kendala di provider pengiriman bisa mencoba mnegirim via metode lain');
                                    }
                              },
                              cache: false,
                              contentType: false,
                              processData: false,
                              error: function (data) {
                                alert('Terjadi kesalahan saat pengiriman link verfikasi!');
                              }
                          });
            }
        </script>
    </body>
    <!--end::Body-->
</html>