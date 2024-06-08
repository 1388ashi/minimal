@extends('admin.layouts.master')
@section('content')
<div class="page-header d-xl-flex d-block mr-3">
	<div class="page-leftheader">
		<h4 class="page-title">داشبورد<span class="font-weight-normal text-muted ml-2"></span></h4>
	</div>
</div>
						<!--End Page header-->
						<!--Row-->
						{{-- <div class="row" style="justify-content: center">
							<div class="col-xl-9 col-md-12 col-lg-12">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col-8">
														<div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">تعداد خبر ها</span>
															<h3 class="mb-0 mt-1 mb-2">{{$postsCount}}</h3>
																<span class="text-success fs-12 mt-2 ml-1"><i class="feather feather-arrow-up-right ml-1 bg-success-transparent p-1 brround"></i></span>
															</span>
														</div>
													</div>
													<div class="col-4">
														<div class="icon1 bg-secondary-transparent brround my-auto  float-left"> <i class="fa fa-newspaper-o"></i> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col-8">
														<div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">تعداد مقالات</span>
															<h3 class="mb-0 mt-1 mb-2">{{$articlesCount}}</h3>
																<span class="text-success fs-12 mt-2 ml-1"><i class="feather feather-arrow-up-right ml-1 bg-success-transparent p-1 brround"></i></span>
															</span>
														</div>
													</div>
													<div class="col-4">
														<div class="icon1 bg-success-transparent my-auto  float-left"> <i class="fa fa-book"></i> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col-8">
														<div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">تعداد اسلایدر ها</span>
															<h3 class="mb-0 mt-1 mb-2">{{$slidersCount}}</h3>
																<span class="text-info fs-12 mt-2 ml-1"><i class="feather feather-arrow-up-right ml-1 bg-success-transparent p-1 brround"></i></span>
															</span>
														</div>
													</div>
													<div class="col-4">
														<div class="icon1 bg-primary-transparent my-auto  float-left"> <i class="fa fa-sliders"></i> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col-8">
														<div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">تعداد دسته بندی ها</span>
															<h3 class="mb-0 mt-1 mb-2">{{$categoryCount}}</h3>
																<span class="text-success fs-12 mt-2 ml-1"><i class="feather feather-arrow-up-right ml-1 bg-success-transparent p-1 brround"></i></span>
															</span>
														</div>
													</div>
													<div class="col-4">
														<div class="icon1 bg-warning-transparent my-auto  float-left"> <i class="fa fa-th"></i> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col-8">
														<div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">تعداد اطلاعیه ها</span>
															<h3 class="mb-0 mt-1 mb-2">{{$announcementsCount}}</h3>
																<span class="text-success fs-12 mt-2 ml-1"><i class="feather feather-arrow-up-right ml-1 bg-success-transparent p-1 brround"></i></span>
															</span>
														</div>
													</div>
													<div class="col-4">
														<div class="icon1 bg-danger-transparent my-auto  float-left"> <i class="fa fa-bullhorn"></i> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col-8">
														<div class="mt-0 text-right"> <span class="fs-16 font-weight-semibold"  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">تعداد پیوند ها</span>
															<h3 class="mb-0 mt-1 mb-2">{{$linksCount}}</h3>
																<span class="text-success fs-12 mt-2 ml-1"><i class="feather feather-arrow-up-right ml-1 bg-success-transparent p-1 brround"></i></span>
															</span>
														</div>
													</div>
													<div class="col-4">
														<div class="icon1 bg-primary-transparent my-auto  float-left"> <i class="fa fa-link"></i> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div> --}}
@endsection
