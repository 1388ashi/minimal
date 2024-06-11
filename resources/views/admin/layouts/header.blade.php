<!--app header-->
						<div class="app-header header">
							<div class="container-fluid">
								<div class="d-flex">
									<a class="header-brand" href="index.html">
										<img src="{{asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Dayonelogo">
										<img src="{{asset('assets/images/brand/logo-white.png')}}" class="header-brand-img dark-logo" alt="Dayonelogo">
										<img src="{{asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Dayonelogo">
										<img src="{{asset('assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Dayonelogo">
									</a>
									<div class="app-sidebar__toggle" data-toggle="sidebar">
										<a class="open-toggle" href="#">
											<i class="feather feather-menu"></i>
										</a>
										<a class="close-toggle" href="#">
											<i class="feather feather-x"></i>
										</a>
									</div>
									<div class="mt-0">
										<form class="form-inline">
											<div class="search-element">
												<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
												<button class="btn btn-primary-color" >
													<i class="feather feather-search"></i>
												</button>
											</div>
										</form>
									</div><!-- SEARCH -->
									<div class="d-flex order-lg-2 my-auto mr-auto">
										<a class="nav-link my-auto icon p-0 nav-link-lg d-md-none navsearch" href="#" data-toggle="search">
											<i class="feather feather-search search-icon header-icon"></i>
										</a>
										<div class="dropdown header-fullscreen">
											<a class="nav-link icon full-screen-link">
												<i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
												<i class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
											</a>
										</div>
										<div class="dropdown header-notify">
											<a class="nav-link icon" data-toggle="sidebar-right" data-target=".sidebar-right">
												<i class="feather feather-bell header-icon"></i>
												<span class="bg-dot"></span>
											</a>
										</div>
										<div class="dropdown profile-dropdown">
											<a  class="nav-link pr-1 pl-0 leading-none" data-toggle="dropdown">
												<span>
												</span>
											</a>
											<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow animated">
											
												<a class="dropdown-item d-flex">
													<i class="feather feather-user ml-3 fs-16 my-auto"></i>
													<div class="mt-1">Profile</div>
												</a>
												<a class="dropdown-item d-flex" href="#">
													<i class="feather feather-settings ml-3 fs-16 my-auto"></i>
													<div class="mt-1">Settings</div>
												</a>
												<a class="dropdown-item d-flex" href="#">
													<i class="feather feather-mail ml-3 fs-16 my-auto"></i>
													<div class="mt-1">Messages</div>
												</a>
												<a class="dropdown-item d-flex" href="#" data-toggle="modal" data-target="#changepasswordnmodal">
													<i class="feather feather-edit-2 ml-3 fs-16 my-auto"></i>
													<div class="mt-1">Change Password</div>
												</a>
												{{-- <a class="dropdown-item d-flex" href="{{route('logout')}}">
													<i class="feather feather-power ml-3 fs-16 my-auto"></i>
													<div class="mt-1">Sign Out</div>
												</a> --}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				</div>
						<!--/app header-->
						<div class="app-header header">
							<div class="container-fluid">
								<div class="d-flex">
									<a class="header-brand" href="index.html">
										<img src="{{asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Dayonelogo">
										<img src="{{asset('assets/images/brand/logo-white.png')}}" class="header-brand-img dark-logo" alt="Dayonelogo">
									</a>
									<div class="app-sidebar__toggle" data-toggle="sidebar">
										<a class="open-toggle" href="#">
											<i class="feather feather-menu"></i>
										</a>
										<a class="close-toggle" href="#">
											<i class="feather feather-x"></i>
										</a>
									</div>
									{{-- <div class="mt-0">
										<form class="form-inline">
											<div class="search-element">
												<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
												<button class="btn btn-primary-color" >
													<i class="feather feather-search"></i>
												</button>
											</div>
										</form>
									</div>  --}}
									<div class="d-flex order-lg-2 my-auto mr-auto">
										<div class="dropdown header-fullscreen">
											<a class="nav-link icon full-screen-link">
												<i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
												<i class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
											</a>
										</div>
										<div class="dropdown header-fullscreen">
											<form method="POST" action="{{ route('admin.logout') }}">
												@csrf
												<button style="border: none; display: flex; justify-content: center; align-items: center;" title="خروج" class="nav-link icon full-screen-link">
													<i class="feather feather-power ml-1 fs-16"></i>
												</button>
											</form>
										</div>
										{{-- <button class="mt-1">خروج</button> --}}
						
										<div class="dropdown profile-dropdown">
											<a href="#" class="nav-link pr-1 pl-0 leading-none" data-toggle="dropdown">
												<span>
													<img src="{{asset('images.jfif')}}" alt="img" class="avatar avatar-md bradius">
												</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div> 
						
						{{-- <div class="modal fade"  id="changepasswordnmodal">
							<div class="modal-dialog" role="document">
								<form action="{{route('change-password',[session()->get('user_id')])}}" method="post">
									@csrf
									@method('Put')
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">تغییر رمز عبور</h5>
											<button  class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
										<div class="modal-body">
											@if(request()->is('post/create') && $errors->any()) 
										<x-alert-danger></x-alert-danger>
										<x-alert-success></x-alert-success>
										
										@elseif(request()->is('post/edit') && $errors->any())
										<x-alert-danger></x-alert-danger>
										<x-alert-success></x-alert-success>
										
										@elseif(request()->is('article/create') && $errors->any())
										<x-alert-danger></x-alert-danger>
										<x-alert-success></x-alert-success>
										
										@elseif(request()->is('article/edit') && $errors->any())
										<x-alert-danger></x-alert-danger>
										<x-alert-success></x-alert-success>
										
										@elseif(request()->is('slider/create') && $errors->any())
										<x-alert-danger></x-alert-danger>
										<x-alert-success></x-alert-success>

										@elseif(request()->is('slider/edit') && $errors->any())
										<x-alert-danger></x-alert-danger>
										<x-alert-success></x-alert-success>

										@elseif(request()->is('announcements/create') && $errors->any())
										<x-alert-danger></x-alert-danger>
										<x-alert-success></x-alert-success>
										@elseif(request()->is('announcements/edit') && $errors->any())
										<x-alert-danger></x-alert-danger>
										<x-alert-success></x-alert-success>
										@elseif(request()->is('profile/edit') && $errors->any())
										<x-alert-danger></x-alert-danger>
										<x-alert-success></x-alert-success>
										@else
										<x-alert-danger></x-alert-danger>
										<x-alert-success></x-alert-success>
										@endif
										<div class="form-group">
											<label class="form-label">کلمه عبور قدیمی</label>
											<input type="password" class="form-control" placeholder="current password" name="current_password">
										</div>
										<div class="form-group">
											<label class="form-label">کلمه عبور  جدید</label>
											<input type="password" class="form-control" placeholder="new password" name="new_password">
										</div>
										<div class="form-group">
											<label class="form-label">تایید کلمه عبور </label>
											<input type="password" class="form-control" placeholder="confirm password" name="new_password_confirmation">
										</div>
									</div>
									<div class="modal-footer text-right">
										<a  class="btn btn-outline-primary" data-dismiss="modal">برگشت</a>
										<button  class="btn btn-warning text-right">به روز رسانی</button>
									</div>
								</div>
								</form>
							</div>
						</div> --}}

