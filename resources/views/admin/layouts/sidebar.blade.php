	<div class="app-sidebar__user">
		<div class="dropdown user-pro-body text-center">
			<div class="user-pic">
				<img src="{{asset('02.png')}}" style="width: 60%;height: 40%;" alt="user-img" class="border-0 avatar-xxl">
			</div>
		</div>
	</div>
		<div class="app-sidebar3 mt-0">
			<ul class="side-menu">
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin.dashboard')}}">
						<i class="fa fa-dashboard sidemenu_icon"></i>
						<span class="side-menu__label">داشبورد</span></i>
					</a>
				</li>
				@role('super_admin')
				<li class="slide">
					<a class="side-menu__item" style="cursor: pointer" data-toggle="slide" >
						<i class="feather feather-edit sidemenu_icon"></i>
						<span  class="side-menu__label">اطلاعات پایه</span><i class="angle fa fa-angle-left"></i>
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
					<a class="side-menu__item" style="cursor: pointer" data-toggle="slide" >
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
					@can('view products')
					<ul class="slide-menu">
						<li><a href="{{route('admin.suggestions.index')}}"  class="slide-item" >محصول پیشنهادی</a></li>
					</ul>
					@endcan
					@can('view comments')
					<ul class="slide-menu">
						<li><a href="{{route('admin.comments.index')}}"  class="slide-item" >مدیریت نظرات</a></li>
					</ul>
					@endcan
				</li>
				<li class="slide">
					<a class="side-menu__item" style="cursor: pointer" data-toggle="slide" >
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
				<li class="slide">
					<a class="side-menu__item" style="cursor: pointer" data-toggle="slide" >
						<i class="fa fa-briefcase sidemenu_icon"></i>
						<span class="side-menu__label">مدیریت فرصت شغلی</span><i class="angle fa fa-angle-left"></i>
					</a>
					@can('view jobs')
					<ul class="slide-menu">
						<li><a href="{{route('admin.jobs.index')}}" class="slide-item">مدیریت شغل ها</a></li>
					</ul>
					@endcan
					@can('view jobs')
					<ul class="slide-menu">
						<li><a href="{{route('admin.resumes.index')}}" class="slide-item">مدیریت رزومه ها</a></li>
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
				@can('view faq')
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin.customer-reviews.index')}}">
						<i class="fa fa-comments sidemenu_icon"></i>
						<span class="side-menu__label">نظر مشتریان </span>
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
				@can('view brands')
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin.brands.index')}}">
						<i class="fa fa-th-large sidemenu_icon"></i>
						<span class="side-menu__label">برند ها</span>
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

				@can('view purchase_advisors')
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin.purchase-advisors.index')}}">
						<i class="fa fa-shopping-basket sidemenu_icon"></i>
						<span class="side-menu__label">مشاوره خرید</span>
					</a>
				</li>
				@endcan
				@can('view tickets')
				<li class="slide">
					<a class="side-menu__item" data-toggle="slide" href="{{route('admin.tickets.index')}}">
						<i class="fa fa-ticket sidemenu_icon"></i>
						<span class="side-menu__label">مدیریت پیام ها</span>
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