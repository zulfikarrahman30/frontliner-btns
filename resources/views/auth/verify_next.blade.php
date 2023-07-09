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
                        <h1 class="fw-bolder fs-2qx text-gray-800 mb-7">Verify Your Account</h1>
                        <!--end::Logo-->
                        <!--begin::Message-->
                        @php $c = 'nomor'; @endphp
                        @if($choose == 'email')
                            @php $c = 'email'; @endphp
                        @endif
                        <div class="fs-3 fw-bold text-muted mb-10">Link verifikasi telah terkirim ke {{$c}}
                        <a href="#" class="link-primary fw-bolder">{{$cred}}</a>
                        <br />Silahkan melakukan pengecekan di inbox anda.</div>
                        <!--end::Message-->
                        <!--begin::Action-->
                        <h3 class="indicator-label">
                            Tidak menerima pesan?
                        </h3>
                       
                        <h4 class="text-muted" id="waktu_jalan" style="display: none;">
                            Tunggu sekitar <b style="font-weight: bold;color: black;" id="timer"></b> menit lagi kami ya sedang mencoba mengirim ulang link ke {{$c}} {{$cred}} <br> kamu bisa cek berkala email kamu di saat waktu tunggu berjalan
                        </h4>
                        <div class="w-lg-600px p-10  mx-auto">
                            
                            <button type="button" class="btn btn-lg btn-primary w-100 mb-5" style="background-color: #A7A8BB;"
                            onclick="startTimer()" id="kirim_ulang">
                            <span class="svg-icon svg-icon-2">
                                </span> 
                                <span class="indicator-label">
                                     Kirim ulang link verifikasi
                                 </span>
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
        <script type="text/javascript">
        function startTimer() {
            var CSRF_TOKEN = "{{ csrf_token() }}";
                var temp=[];
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        }
                    });
                    var formSend = new FormData();
                    var action = localStorage.getItem('action');
                    formSend.append('choose', action); 
                    formSend.append('email', '{{$cred}}'); 
                    formSend.append('action', 'resend'); 
                        $.ajax({
                              type: "POST",
                              url: "{{url('send_verify')}}", 
                              data: formSend,
                              success: function (data) {
                                if(data.data == 'success'){
                                    alert('success mengirim pesan');
                                    startBeh(data.time);
                                }else{
                                   alert('mohon maaf saat ini sedang ternajdi kendala di provider pengiriman bisa mencoba mnegirim via metode lain');
                                }
                              },
                              cache: false,
                              contentType: false,
                              processData: false,
                              error: function (data) {
                                console.log(data);
                              }
                          });

        }

        function startBeh(timeBeh)
        {
            document.getElementById("waktu_jalan").style.display='';
            $('#kirim_ulang').prop( "disabled", true );
            //if(setTime == ''){
                var waktu = timeBeh;
            //}else{
               // var waktu = setTime;
            //}
            console.log(waktu);
            var t = waktu.split(/[- :]/);
            let dateTimeParts= t; // regular expression split that creates array with: year, month, day, hour, minutes, seconds values
            dateTimeParts[1]--; // monthIndex begins with 0 for January and ends with 11 for December so we need to decrement by one
            const dateObject = new Date(...dateTimeParts); // our Date object
            var oo = dateObject.toString();
            oo = new Date(oo).toString();
            oo = oo.split(' ').slice(1, 5).join(' ');
            const myArray = oo.split(" ");
            var fix = myArray[0]+' '+myArray[1]+', '+myArray[2]+' '+myArray[3];
            //console.log(waktu);
            var countDownDate = new Date(fix).getTime();
            //Update the count down every 1 second
            var x = setInterval(function() {
              // Get today's date and time
              var now = new Date().getTime();
              // Find the distance between now and the count down date
              var distance = countDownDate - now;
              // Time calculations for days, hours, minutes and seconds
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                // Output the result in an element with id="demo"
                document.getElementById("timer").innerHTML = minutes + " menit " + seconds + " detik ";
                // If the count down is over, write some text 
                if (distance < 0) {
                  clearInterval(x);
                  document.getElementById("timer").style.display='none';
                  document.getElementById("waktu_jalan").style.display='none';
                 $('#kirim_ulang').prop( "disabled", false );
                }
              }, 250);
        }

        window.onload = function () {
            var setTime = '{{Session::get('tungguWaktu')}}';
            if(setTime != ''){
                startBeh(setTime);
            }
        }
        </script>
        <!--end::Global Javascript Bundle-->
        <!--end::Javascript-->
    </body>
    <!--end::Body-->
</html>