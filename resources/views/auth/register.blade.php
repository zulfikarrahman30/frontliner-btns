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
        <meta property="og:url" content="{{url('/')}}" />
        <meta property="og:site_name" content="{{env('APP_NAME')}} &amp; {{env('APP_VENDOR')}}" />
        <link rel="canonical" href="{{url('/')}}" />
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
    @php $event = new App\Models\Event();
          $provinsi = $event->getProvinsi();
    @endphp
    <!--begin::Body-->
    <body id="kt_body" class="bg-body">
        <!--begin::Main-->
        <!--begin::Root-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Authentication - Sign-up -->
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">
                 <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative">
                       <div class="d-flex flex-center flex-column flex-column-fluid">
                        <!--begin::Wrapper-->
                                <div class="w-lg-600px p-10 p-lg-15 mx-auto">
                                    <!--begin::Form-->
                                    <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form">
                                        <!--begin::Heading-->
                                        <div class="mb-10 text-center">
                                            <!--begin::Title-->
                                            <h1 class="mb-3" 
                                            style="
                                                /*font-family: Ubuntu;*/
                                                font-size: normal;
                                                font-weight: 700;
                                                font-size: 50px;
                                                color: #122BA9;">
                                                Mendaftar
                                            </h1>
                                            <!--end::Title-->
                                            <!--begin::Link-->
                                            <div class="text-gray-400 fw-bold fs-4">Sudah punya akun?
                                            <a href="{{url('login')}}" class="link-primary fw-bolder">Login
                                            </a></div>
                                            <!--end::Link-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="row fv-row mb-7">
                                            <!--begin::Col-->
                                            <div class="col-xl-12">
                                                <label class="form-label fw-bolder text-dark fs-6">Nama Lengkap</label>
                                                <input class="form-control form-control-lg form-control-solid" type="text" placeholder="Antoine Salatan" name="first_name" autocomplete="off" />
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <div class="row fv-row mb-7">
                                            <div class="col-xl-12">
                                                <label class="form-label fw-bolder text-dark fs-6">Asal</label>
                                                <select aria-label="Come From" data-control="select2" 
                                                data-placeholder="Come From" class="form-select mb-2" name="from" onchange="liatform(this.value)">
                                                    <option value="0" selected disabled>Asal?</option>
                                                    <option value="domestic">Dalam Negeri</option>
                                                    <option value="foreign">Luar Negeri</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row fv-row mb-7" id="foreign" style="display: none;">
                                            <!--begin::Col-->
                                            <div class="col-xl-12">
                                                <label class="form-label fw-bolder text-dark fs-6">Alamat Lengkap</label>
                                                <textarea name="full_address" id="" class="form-control form-control-solid" cols="30" rows="5" placeholder="Av. de Concha Espina, 1, 28036 Madrid, Spanyol"></textarea>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <div class="row fv-row mb-7" id="domestic" style="display: none;">
                                            <!--begin::Col-->
                                            <div class="col-xl-6">
                                                <label class="form-label fw-bolder text-dark fs-6">Provinsi</label>
                                                <select aria-label="Provincy" data-control="select2" 
                                                data-placeholder="Provincy" class="form-select mb-2" name="provinsi_id"
                                                id="Provincy" onchange="getRegion(this.value)">
                                                    <option value="0">Provincy</option>
                                                    @foreach($provinsi as $p)
                                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                                    @endforeach
                                                </select>
                                                <input class="form-control form-control-lg form-control-solid" type="hidden" placeholder="085608xxxx" name="asal_value" id="asal_value" autocomplete="off" 
                                            />
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-xl-6">
                                                <label class="form-label fw-bolder text-dark fs-6">Kabupaten</label>
                                                <select aria-label="Regency" data-control="select2"
                                                 data-placeholder="Regency" class="form-select mb-2" name="regency_id" 
                                                 id="Regency">
                                                    <option value="0">Regency</option>s
                                                </select>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <label class="form-label fw-bolder text-dark fs-6">Email</label>
                                            <input class="form-control form-control-lg form-control-solid" type="email" placeholder="abcde@gmail.com" name="email" id="email" autocomplete="off" />
                                        </div>
                                        <!--end::Input group-->
                                         <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <label class="form-label fw-bolder text-dark fs-6">Nomor WhatsApp</label>
                                            <input class="form-control form-control-lg form-control-solid" type="text" placeholder="085608xxxx" name="nomor_wa" autocomplete="off" 
                                            onkeypress="return hanyaAngka(event)"/>
                                             
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row" data-kt-password-meter="true">
                                            <!--begin::Wrapper-->
                                            <div class="mb-1">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bolder text-dark fs-6">Kata Sandi</label>
                                                <!--end::Label-->
                                                <!--begin::Input wrapper-->
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off" />
                                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                        <i class="bi bi-eye-slash fs-2"></i>
                                                        <i class="bi bi-eye fs-2 d-none"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Input group=-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark fs-6">Ulangi Password</label>
                                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm-password" autocomplete="off" />
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-10">
                                            <label class="form-check form-check-custom form-check-solid form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="toc" value="1" />
                                                <span class="form-check-label fw-bold text-gray-700 fs-6">Saya menyetuji
                                                <a href="#" class="ms-1 link-primary">Persyaratan</a>.</span>
                                            </label>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="text-center">
                                            <button type="button" id="kt_sign_up_submit" class="btn btn-lg btn-primary" style="background-color:#122BA9;">
                                                <span class="indicator-label">Daftar</span>
                                                <span class="indicator-progress">Mohon tunggu...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                        <!--end::Wrapper-->
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-lg-row-fluid" 
                         style="background-image: url({{url('assets/media/images/daftar_1.png')}}); 
                                background-repeat: no-repeat, repeat;
                                background-size: cover;">
                        <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                            <a href="{{url('/')}}" class="py-9 mb-5" style="padding-left: 3px;">
                                <img alt="Logo" src="{{url('assets/media/images/vcs.png')}}" class="h-60px" />
                            </a>
                        </div>
                    </div>
                   
                </div>
            </div>
        <!--end::Root-->
        <!--end::Main-->
        <!--begin::Javascript-->
        <script type="text/javascript">
              function hanyaAngka(evt) {
                var charCode = (evt.which) ? evt.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57))
             
                return false;
                return true;
            }
            // function domestikorluar(value)
            // {

            // }
            function liatform(value){
                if(value == 'domestic'){
                    $('#domestic').show();
                    $('#foreign').hide();
                    $('#asal_value').val('domestic');
                }
                if(value == 'foreign'){
                    $('#domestic').hide();
                    $('#foreign').show();
                    $('#asal_value').val('foreign');
                }

                if(value == '0'){
                    $('#domestic').hide();
                    $('#foreign').hide();
                    $('#asal_value').val('');
                }
            }

            function getRegion(){
                $.ajaxSetup({
                  headers:{
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                      }
                  });
                  var temp = [];
                  var form = new FormData();
                  var Provincy = $('#Provincy').val();
                  form.append('province_id',Provincy); 
                    $.ajax({
                      type: "POST",
                      url: "{{url('get/regency')}}", 
                      data: form,
                      success: function(data) {
                        $.each(data, function (key, value) {
                          temp.push({
                               v: value,
                               k: key
                             });
                          });
                          var x = document.getElementById("Regency");
                          $('#Regency').empty();
                          var opt_head = document.createElement('option');
                          opt_head.text = '-- Choose Regency --';
                          opt_head.value = '0';
                          opt_head.disabled = true;
                          opt_head.selected = true;
                          x.appendChild(opt_head);
                          for (var i = 0; i < temp.length; i++) {
                            var opt = document.createElement('option');
                            opt.value = temp[i].v.id;
                            opt.text = temp[i].v.name;
                            x.appendChild(opt);
                          }
                      },
                      cache: false,
                      contentType: false,
                      processData: false,
                      error: function(error) {
                          console.log(error);
                      }
                    });
            }
            var email = 'dd';
            var urlRegister = "{{url('register_user')}}";
            var urlLogin = "{{url('login')}}";
            var urlVerify = "{{url('verify')}}";
            var CSRF_TOKEN = "{{ csrf_token() }}";
            var temp=[];
        </script>
        <script>var hostUrl = "assets/";</script>
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
        <script src="{{url('assets/js/scripts.bundle.js')}}"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Page Custom Javascript(used by this page)-->
        <!-- <script src="{{url('assets/js/custom/authentication/sign-up/general.js')}}"></script> -->
        <script type="text/javascript">
            "use strict";

// Class definition
var KTSignupGeneral = function() {
    // Elements
    var form;
    var submitButton;
    var validator;
    var passwordMeter;

    // Handle form
    var handleForm  = function(e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'first_name': {
                        validators: {
                            notEmpty: {
                                message: 'Nama lengkap tidak boleh kosong!'
                            }
                        }
                    },
                    'asal_value': {
                        validators: {
                            notEmpty: {
                                message: 'Asal harus di pilih !'
                            }
                        }
                    },
                    'nomor_wa': {
                        validators: {
                            notEmpty: {
                                message: 'Nomor whatsapp is tidak boleh kosong!'
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'Email tidak boleh kosong!'
                            },
                            emailAddress: {
                                message: 'Email tidak valid'

                            }
                        }
                    },
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'Password is tidak boleh kosong!'
                            },
                        }
                    },
                    'confirm-password': {
                        validators: {
                            notEmpty: {
                                message: 'Konfirmasi password tidak boleh kosong!'
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'Password konfirmasi tidak sama dengan password'
                            }
                        }
                    },
                    'toc': {
                        validators: {
                            notEmpty: {
                                message: 'Kamu harus menchecklist persyaratan!'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: false
                        }  
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Handle form submit
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.revalidateField('password');

            validator.validate().then(function(status) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click 
                    submitButton.disabled = true;

                    // Simulate ajax request

                    setTimeout(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        }
                    });
                    var formLogin = $('#kt_sign_up_form').serialize();
                    var emailSubmit = $('#email').val();
                        $.ajax({
                              type: "POST",
                              url: urlRegister, 
                              data: formLogin,
                              success: function (data) {
                                  var temp = [];
                                  $.each(data, function (key, value) {
                                      temp.push({
                                          v: value,
                                          k: key
                                      });
                                  });
                                  //console.log(temp[0].v);
                                  console.log(emailSubmit);
                                  if(temp[0].v == 'email_exist'){
                                    submitButton.removeAttribute('data-kt-indicator');
                                    submitButton.disabled = false;
                                    Swal.fire({
                                        text: "Mohon maaf email kamu sudah terdaftar silahkan pergi ke halamn login atau gunakan email lain untuk mendaftar!",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, siap!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        if (result.isConfirmed) {                             
                                            window.setTimeout(function(){location.href=urlLogin},100);
                                        }
                                    });
                                  }

                                  if(temp[0].v == 'error'){
                                    submitButton.removeAttribute('data-kt-indicator');
                                    submitButton.disabled = false;
                                    Swal.fire({
                                        text: "Mohon maaf sedang terjadi kesalah ulangi beberapa saat lagi atau hubungi admin jika masih mengalami kendala!",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, siap!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                  }

                                  if(temp[0].v == 'success'){
                                    submitButton.removeAttribute('data-kt-indicator');
                                    submitButton.disabled = false;
                                    Swal.fire({
                                        text: "Kamu telah berhasil mendaftar lanjutkan ke langkah verifikasi ya.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Pergi ke halaman verifikasi",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        if (result.isConfirmed) {                             
                                            window.setTimeout(function(){location.href=urlVerify},300);
                                        }
                                    });
                                  }
                              },
                              error: function (data) {
                              }
                          });
                    }, 1500);                           
                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Mohon maaf , ada kelengkapan yang belum anda isi , silahkan di cek kembali",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, Siap!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });

        // Handle password input
        form.querySelector('input[name="password"]').addEventListener('input', function() {
            if (this.value.length > 0) {
                validator.updateFieldStatus('password', 'NotValidated');
            }
        });
    }

    // Password input validation
    var validatePassword = function() {
        return  (passwordMeter.getScore() === 100);
    }

    // Public functions
    return {
        // Initialization
        init: function() {
            // Elements
            form = document.querySelector('#kt_sign_up_form');
            submitButton = document.querySelector('#kt_sign_up_submit');
            passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

            handleForm ();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTSignupGeneral.init();
});

        </script>
        <!--end::Page Custom Javascript-->
        <!--end::Javascript-->
    </body>
    <!--end::Body-->
</html>