					<!--begin::Aside menu-->
					<div class="aside-menu flex-column-fluid">
						<!--begin::Aside Menu-->
						<div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
							<!--begin::Menu-->
							<div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion ">
									<a  href="{{url('home')}}">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
													<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
													<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
													<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
												</svg>
											</span>
											<!--end::Svg Icon-->
											</span>
												<span class="menu-title">Dashboard</span>
											</span>
										</a>
								</div>
								

								<div class="menu-item">
									<div class="menu-content pt-8 pb-0">
										<span class="menu-section text-muted text-uppercase fs-8 ls-1">Data</span>
									</div>
								</div>
								@if(Auth::user()->role=='admin')
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<span class="menu-link">
										<span class="menu-icon">
											<!--begin::Svg Icon | path: icons/duotune/abstract/abs042.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M18 21.6C16.6 20.4 9.1 20.3 6.3 21.2C5.7 21.4 5.1 21.2 4.7 20.8L2 18C4.2 15.8 10.8 15.1 15.8 15.8C16.2 18.3 17 20.5 18 21.6ZM18.8 2.8C18.4 2.4 17.8 2.20001 17.2 2.40001C14.4 3.30001 6.9 3.2 5.5 2C6.8 3.3 7.4 5.5 7.7 7.7C9 7.9 10.3 8 11.7 8C15.8 8 19.8 7.2 21.5 5.5L18.8 2.8Z" fill="black" />
													<path opacity="0.3" d="M21.2 17.3C21.4 17.9 21.2 18.5 20.8 18.9L18 21.6C15.8 19.4 15.1 12.8 15.8 7.8C18.3 7.4 20.4 6.70001 21.5 5.60001C20.4 7.00001 20.2 14.5 21.2 17.3ZM8 11.7C8 9 7.7 4.2 5.5 2L2.8 4.8C2.4 5.2 2.2 5.80001 2.4 6.40001C2.7 7.40001 3.00001 9.2 3.10001 11.7C3.10001 15.5 2.40001 17.6 2.10001 18C3.20001 16.9 5.3 16.2 7.8 15.8C8 14.2 8 12.7 8 11.7Z" fill="black" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">User</span>
										<span class="menu-arrow"></span>
									</span>
									<div class="menu-sub menu-sub-accordion menu-active-bg">
										<!-- <div class="menu-item">
											<a class="menu-link" href="{{url('/user/admin_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Administrator</span>
											</a>
										</div> -->
										<div class="menu-item">
											<a class="menu-link" href="{{url('user/manager_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Manager</span>
											</a>
										</div>
										<div class="menu-item">
											<a class="menu-link" href="{{url('user/teller_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Teller</span>
											</a>
										</div>
										<div class="menu-item">
											<a class="menu-link" href="{{url('user/financing_service_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Financing Service</span>
											</a>
										</div>
										<div class="menu-item">
											<a class="menu-link" href="{{url('user/customer_service_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Customer Service</span>
											</a>
										</div>
										<div class="menu-item">
											<a class="menu-link" href="{{url('user/marketing_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Marketing</span>
											</a>
										</div>
										<div class="menu-item">
											<a class="menu-link" href="{{url('user/user_log_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Log Activity</span>
											</a>
										</div>
									</div>
								</div>
								@endif
								@if(Auth::user()->role == 'admin')
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<span class="menu-link">
										<span class="menu-icon">
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M18 21.6C16.6 20.4 9.1 20.3 6.3 21.2C5.7 21.4 5.1 21.2 4.7 20.8L2 18C4.2 15.8 10.8 15.1 15.8 15.8C16.2 18.3 17 20.5 18 21.6ZM18.8 2.8C18.4 2.4 17.8 2.20001 17.2 2.40001C14.4 3.30001 6.9 3.2 5.5 2C6.8 3.3 7.4 5.5 7.7 7.7C9 7.9 10.3 8 11.7 8C15.8 8 19.8 7.2 21.5 5.5L18.8 2.8Z" fill="black" />
													<path opacity="0.3" d="M21.2 17.3C21.4 17.9 21.2 18.5 20.8 18.9L18 21.6C15.8 19.4 15.1 12.8 15.8 7.8C18.3 7.4 20.4 6.70001 21.5 5.60001C20.4 7.00001 20.2 14.5 21.2 17.3ZM8 11.7C8 9 7.7 4.2 5.5 2L2.8 4.8C2.4 5.2 2.2 5.80001 2.4 6.40001C2.7 7.40001 3.00001 9.2 3.10001 11.7C3.10001 15.5 2.40001 17.6 2.10001 18C3.20001 16.9 5.3 16.2 7.8 15.8C8 14.2 8 12.7 8 11.7Z" fill="black" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-title">Nasabah</span>
										<span class="menu-arrow"></span>
									</span>
									<div class="menu-sub menu-sub-accordion menu-active-bg">
										@if(Auth::user()->role=='admin' || Auth::user()->role=='customer_service')
										<div class="menu-item">
											<a class="menu-link" href="{{url('/layanan/customer_service_submission_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Customer Service</span>
											</a>
										</div>
										@endif
										@if(Auth::user()->role=='admin' || Auth::user()->role=='financing_service')
										<div class="menu-sub menu-sub-accordion menu-active-bg">
											<div class="menu-item">
												<a class="menu-link" href="{{url('/layanan/financing_service_submission_index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
													<span class="menu-title">Financing Service</span>
												</a>
											</div>
										</div>
										@endif
										@if(Auth::user()->role=='admin' || Auth::user()->role=='teller')
											<div class="menu-sub menu-sub-accordion menu-active-bg">
												<div class="menu-item">
													<a class="menu-link" href="{{url('/layanan/teller_submission_index')}}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">Teller</span>
													</a>
												</div>
											</div>
										@endif
										@if(Auth::user()->role=='admin' || Auth::user()->role=='manager')
										<div class="menu-item">
											<a class="menu-link" href="{{url('/layanan/assignment_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Assignment</span>
											</a>
										</div>
										@endif
									</div>
									
									</div>
								</div>
								@else
									@if(Auth::user()->role=='customer_service')
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion ">
											<a  href="{{url('layanan/customer_service_submission_index')}}">
											<span class="menu-link">
												<span class="menu-icon">
													<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
															<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
															<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
															<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													</span>
														<span class="menu-title">Submission</span>
													</span>
												</a>
										</div>
									@elseif(Auth::user()->role=='financing_service')
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion ">
											<a  href="{{url('layanan/financing_service_submission_index')}}">
											<span class="menu-link">
												<span class="menu-icon">
													<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
															<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
															<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
															<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													</span>
														<span class="menu-title">Submission</span>
													</span>
												</a>
										</div>
									@elseif(Auth::user()->role=='teller')
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion ">
											<a  href="{{url('layanan/teller_submission_index')}}">
											<span class="menu-link">
												<span class="menu-icon">
													<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
															<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
															<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
															<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon-->
													</span>
														<span class="menu-title">Submission</span>
													</span>
												</a>
										</div>
									@elseif(Auth::user()->role=='manager')
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion ">
											<a  href="{{url('layanan/assignment_index')}}">
											<span class="menu-link">
												<span class="menu-icon">
													<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
													<span class="svg-icon svg-icon-2">
														<i class="fa fa-user-plus"></i>
													</span>
													<!--end::Svg Icon-->
													</span>
														<span class="menu-title">Assignment</span>
													</span>
												</a>
										</div>
										<div class="menu-item">
											<a class="menu-link" href="{{url('/layanan/klasifikasi_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">Klasifikasi Status</span>
											</a>
										</div>
										@elseif(Auth::user()->role=='marketing')
										<div data-kt-menu-trigger="click" class="menu-item menu-accordion ">
											<a  href="{{url('layanan/marketing_assignment_index')}}">
											<span class="menu-link">
												<span class="menu-icon">
													<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
													<i class="fa fa-user-plus"></i>
													<!--end::Svg Icon-->
													</span>
														<span class="menu-title">Marketing 	Assignment</span>
													</span>
												</a>
										</div>
									@endif
								@endif
								<div class="menu-item">
									<div class="menu-content">
										<div class="separator mx-1 my-4"></div>
									</div>
								</div>
							</div>
							<!--end::Menu-->
						</div>
						<!--end::Aside Menu-->
					</div>
					<!--end::Aside menu-->
