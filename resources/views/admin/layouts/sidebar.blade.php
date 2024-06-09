	
		<div class="app-sidebar1">
			<div class="app-sidebar__user">
				<div class="dropdown user-pro-body text-center">
					<div class="user-pic">
						<img src="{{asset('images.jfif')}}" alt="user-img" class="avatar-xxl rounded-circle mb-1">
					</div>
					<div class="user-info">
						<h5 class="text-white mb-2">مدیریت وبسایت مینیمال</h5>
						<span class="text-muted app-sidebar__user-name text-sm"></span>
					</div>
				</div>
			</div>
			<ul class="side-menu">
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin.dashboard')}}">
						<i class="fa fa-dashboard sidemenu_icon"></i>
						<span class="side-menu__label">داشبورد</span></i>
					</a>
				</li>
				@role('super_admin')
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" >
						<i class="feather feather-edit sidemenu_icon"></i>
						<span class="side-menu__label">اطلاعات پایه</span><i class="angle fa fa-angle-left"></i>
					</a>
					<ul class="slide-menu">
						<li><a href="{{route('admin.roles')}}" class="slide-item">مدیریت نقش ها و مجوز ها</a></li>
					</ul>
					<ul class="slide-menu">
						<li><a href="{{route('admin.admins.index')}}" class="slide-item">مدیریت ادمین ها</a></li>
					</ul>
				</li>
				@endrole
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" >
						<i class="fa fa-shopping-bag sidemenu_icon"></i>
						<span class="side-menu__label">مدیریت محصولات</span><i class="angle fa fa-angle-left"></i>
					</a>
					@can('view categories')
					<ul class="slide-menu">
						<li><a  class="slide-item" href="{{route('admin.categories.index')}}">مدیریت دسته بندی ها</a></li>
					</ul>
					@endcan
					@can('view specificaions')
					<ul class="slide-menu">
						<li><a href="{{route('admin.specifications.index')}}"  class="slide-item" >مشخصه محصولات</a></li>
					</ul>
					@endcan
					@can('view colors')
					<ul class="slide-menu">
						<li><a href="{{route('admin.colors.index')}}"  class="slide-item" >رنگ های محصولات</a></li>
					</ul>
					@endcan
					@can('view products')
					<ul class="slide-menu">
						<li><a  class="slide-item" href="{{route('admin.products.index')}}">مدیریت محصولات</a></li>
					</ul>
					@endcan
					@can('view comments')
					<ul class="slide-menu">
						<li><a href="{{route('admin.comments.index')}}"  class="slide-item" >مدیریت نظرات</a></li>
					</ul>
					@endcan
				</li>
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" >
						<i class="fa fa-newspaper-o sidemenu_icon"></i>
						<span class="side-menu__label">وبلاگ</span><i class="angle fa fa-angle-left"></i>
					</a>
					@can('view categories')
					<ul class="slide-menu">
						<li><a href="{{route('admin.blog-categories.index')}}" class="slide-item">دسته بندی ها</a></li>
					</ul>
					@endcan
					@can('view blogs')
					<ul class="slide-menu">
						<li><a href="{{route('admin.articles.index')}}" class="slide-item">مدیریت مقالات</a></li>
					</ul>
					@endcan
					@can('view blogs')
					<ul class="slide-menu">
						<li><a href="{{route('admin.news.index')}}" class="slide-item">مدیریت خبر ها</a></li>
					</ul>
					@endcan
				</li>
				@can('view faq')
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin.sliders.index')}}">
						<i class="fa fa-sliders sidemenu_icon"></i>
						<span class="side-menu__label">اسلایدر ها</span>
					</a>
				</li>
				@endcan
				@can('view teams')
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin.teams.index')}}">
						<i class="fa fa-users sidemenu_icon"></i>
						<span class="side-menu__label">تیم ما</span>
					</a>
				</li>
				@endcan
				@can('view faq')
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin.asks.index')}}">
						<i class="fa fa-question sidemenu_icon"></i>
						<span class="side-menu__label">سوالات متداول</span>
					</a>
				</li>
				@endcan
				@can('view settings')
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin.settings.index')}}">
						<i class=" las la-cog sidemenu_icon"></i>
						<span class="side-menu__label">تنظیمات</span>
					</a>
				</li>
				@endcan
				{{-- <li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin-index')}}">
						<i class="feather feather-home sidemenu_icon"></i>
						<span class="side-menu__label">داشبورد</span></i>
					</a>
				</li>

				<li class="slide">
					<a class="side-menu__item" data-toggle="slide"  href="{{route('menus')}}">
						<i class="fa fa-get-pocket sidemenu_icon"></i>
						<span class="side-menu__label">منو ساز</span></i>
					</a>
				</li>

				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" >
						<i class="fa fa-th sidemenu_icon"></i>
						<span class="side-menu__label">دسته بندی</span><i class="angle fa fa-angle-left"></i>
					</a>
					<ul class="slide-menu">
						<li><a href="{{route('categories.index')}}" class="slide-item">دسته بندی ها</a></li>
					</ul>
				</li>

				<li class="slide">
					<a class="side-menu__item" data-toggle="slide">
						<i class="fa fa-newspaper-o sidemenu_icon"></i>
						<span class="side-menu__label">اخبار</span><i class="angle fa fa-angle-left"></i>
					</a>
					<ul class="slide-menu">
						<li><a href="{{route('posts.create')}}" class="slide-item">اخبار جدید</a></li>
						<li><a href="{{route('posts.index')}}" class="slide-item">اخبار ها</a></li>
					</ul>
				</li>

				<li class="slide">
					<a class="side-menu__item" data-toggle="slide">
						<i class="fa fa-bullhorn sidemenu_icon"></i>
						<span class="side-menu__label">اطلاعیه</span><i class="angle fa fa-angle-left"></i>
					</a>
					<ul class="slide-menu">
						<li><a href="{{ route('announcements.create') }}" class="slide-item">اطلاعیه جدید</a></li>
						<li><a href="{{ route('announcements.index') }}" class="slide-item">اطلاعیه ها</a></li>
					</ul>
				</li>

				<li class="slide">
					<a class="side-menu__item" data-toggle="slide"  >
						<i class="fa fa-book sidemenu_icon"></i>
						<span class="side-menu__label">آموزش</span><i class="angle fa fa-angle-left"></i>
					</a>
					<ul class="slide-menu">
						<li><a href="{{ route('articles.create')}}" class="slide-item">آموزش جدید</a></li>
						<li><a href="{{ route('articles.index')}}" class="slide-item">آموزش ها</a></li>
					</ul>
				</li>

				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" >
						<i class="fa fa-sliders sidemenu_icon"></i>
						<span class="side-menu__label">اسلایدر</span><i class="angle fa fa-angle-left"></i>
					</a>
					<ul class="slide-menu">
						<li><a href="{{ route('sliders.create')}}" class="slide-item">اسلایدر جدید</a></li>
						<li><a href="{{ route('sliders.index')}}" class="slide-item">اسلایدر ها</a></li>
					</ul>
				</li>

				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" >
						<i class="fa fa-link sidemenu_icon"></i>
						<span class="side-menu__label">لينک</span><i class="angle fa fa-angle-left"></i>
					</a>
					<ul class="slide-menu">
						<li><a href="{{ route('links.create')}}" class="slide-item">لينک جدید</a></li>
						<li><a href="{{ route('links.index')}}" class="slide-item">لينک ها</a></li>
					</ul>
				</li>
			
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" >
						<i class="sidemenu_icon">#</i>
						<span class="side-menu__label">برچسب</span><i class="angle fa fa-angle-left"></i>
					</a>
					<ul class="slide-menu">
						<li><a href="{{ route('tags.index')}}" class="slide-item">برچسب ها</a></li>
					</ul>
				</li>

				<li class="slide">
					<a class="side-menu__item" data-toggle="slide"  href="{{ route('edit-setting')}}">
						<i class=" las la-cog sidemenu_icon"></i>
						<span class="side-menu__label">تنظیمات</span></i>
					</a>
				</li> --}}
			</ul>
		</div>