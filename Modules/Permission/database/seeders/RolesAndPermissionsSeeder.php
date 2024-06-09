<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create roles
        $roles = [
            'super_admin' => 'مدیر ارشد'
        ];

        foreach ($roles as $name => $label) {
            Role::query()->firstOrCreate(
                ['name' => $name],
                ['label' => $label, 'guard_name' => 'web']
            );
        }

        //create permissions
        $permissions = [
            'view dashboard stats' => 'مشاهده آمارهای داشبورد',
            //users
            // 'view users' => 'مشاهده کاربران',
            // 'create users' => 'ایجاد کاربران',
            // 'edit users' => 'ویرایش کاربران',
            // 'delete users' => 'حذف کاربران',
            // //settings
            // 'view settings' => 'مشاهده تنظیمات',
            // 'create settings' => 'ایجاد تنظیمات',
            // 'edit settings' => 'ویرایش تنظیمات',
            // //faq_groups
            // 'view faq_groups' => 'مشاهده گروه پرسش های متداول',
            // 'create faq_groups' => 'ایجاد گروه پرسش های متداول',
            // 'edit faq_groups' => 'ویرایش گروه پرسش های متداول',
            // 'delete faq_groups' => 'حذف گروه پرسش های متداول',
            // //faqs
            // 'view faqs' => 'مشاهده پرسش های متداول',
            // 'create faqs' => 'ایجاد پرسش های متداول',
            // 'edit faqs' => 'ویرایش پرسش های متداول',
            // 'delete faqs' => 'حذف پرسش های متداول',
            // //teachers
            // 'view teachers' => 'مشاهده مدرس ها',
            // 'create teachers' => 'ایجاد مدرس ها',
            // 'edit teachers' => 'ویرایش مدرس ها',
            // 'delete teachers' => 'حذف مدرس ها',
            // //courses
            // 'view courses' => 'مشاهده دوره ها',
            // 'create courses' => 'ایجاد دوره ها',
            // 'edit courses' => 'ویرایش دوره ها',
            // 'delete courses' => 'حذف دوره ها',
            // //suitable for courses
            // 'view suitable_courses' => 'مشاهده مناسب دوره ها',
            // 'create suitable_courses' => 'ایجاد مناسب دوره ها',
            // 'edit suitable_courses' => 'ویرایش مناسب دوره ها',
            // 'delete suitable_courses' => 'حذف مناسب دوره ها',
            // //headlines
            // 'view headlines' => 'مشاهده سرفصل ها',
            // 'create headlines' => 'ایجاد سرفصل ها',
            // 'edit headlines' => 'ویرایش سرفصل ها',
            // 'delete headlines' => 'حذف سرفصل ها',
            // //episodes
            // 'view episodes' => 'مشاهده اپیزود ها',
            // 'create episodes' => 'ایجاد اپیزود ها',
            // 'edit episodes' => 'ویرایش اپیزود ها',
            // 'delete episodes' => 'حذف اپیزود ها',
            // //podcasts
            // 'view podcasts' => 'مشاهده پادکست ها',
            // 'create podcasts' => 'ایجاد پادکست ها',
            // 'edit podcasts' => 'ویرایش پادکست ها',
            // 'delete podcasts' => 'حذف پادکست ها',
            // //categories
            'view categories' => 'مشاهده دسته بندی ها',
            'create categories' => 'ایجاد دسته بندی ها',
            'edit categories' => 'ویرایش دسته بندی ها',
            'delete categories' => 'حذف دسته بندی ها',
            //products
            'view products' => 'مشاهده محصول ها',
            'create products' => 'ایجاد محصول ها',
            'edit products' => 'ویرایش محصول ها',
            'delete products' => 'حذف محصول ها',
            //settings
            'view settings' => 'مشاهده تنظیمات',
            'create settings' => 'ایجاد تنظیمات',
            'edit settings' => 'ویرایش تنظیمات',
            'delete settings' => 'حذف تنظیمات',
            //specifications
            'view specifications' => 'مشاهده مشخصات',
            'create specifications' => 'ایجاد مشخصات',
            'edit specifications' => 'ویرایش مشخصات',
            'delete specifications' => 'حذف مشخصات',
            //blogs
            'view blogs' => 'مشاهده بلاگ',
            'create blogs' => 'ایجاد بلاگ',
            'edit blogs' => 'ویرایش بلاگ',
            'delete blogs' => 'حذف بلاگ',
            //asks
            'view faq' => 'مشاهده سولات متداول',
            'create faq' => 'ایجاد سولات متداول',
            'edit faq' => 'ویرایش سولات متداول',
            'delete faq' => 'حذف سولات متداول',
            //comments
            'view comment' => 'مشاهده نظرات ',
            'edit comment' => 'ویرایش نظرات ',
            'delete comment' => 'حذف نظرات ',
            //sliders
            'view sliders' => 'مشاهده اسلایدر ها ',
            'create sliders' => 'ایجاد اسلایدر',
            'edit sliders' => 'ویرایش اسلایدر ',
            'delete sliders' => 'حذف اسلایدر ',
            //colors
            'view colors' => 'مشاهده رنگ ها ',
            'create colors' => 'ایجاد رنگ',
            'edit colors' => 'ویرایش رنگ ',
            'delete colors' => 'حذف رنگ ',
            //teams
            'view teams' => 'مشاهده تیم ها ',
            'create teams' => 'ایجاد تیم',
            'edit teams' => 'ویرایش تیم ',
            'delete teams' => 'حذف تیم ',
            //customerRaviews
            'view customerRaviews' => 'مشاهده نظر مشتریان ها ',
            'create customerRaviews' => 'ایجاد نظر مشتریان',
            'edit customerRaviews' => 'ویرایش نظر مشتریان ',
            'delete customerRaviews' => 'حذف نظر مشتریان ',
            // //posts
            // 'view posts' => 'مشاهده مقاله ها',
            // 'create posts' => 'ایجاد مقاله ها',
            // 'edit posts' => 'ویرایش مقاله ها',
            // 'delete posts' => 'حذف مقاله ها',
            // //consultations
            // 'view consultations' => 'مشاهده درخواست مشاهده ها',
            // 'create consultations' => 'ایجاد درخواست مشاهده ها',
            // 'edit consultations' => 'ویرایش درخواست مشاهده ها',
            // 'delete consultations' => 'حذف درخواست مشاهده ها',
            // //comments
            // 'view comments' => 'مشاهده نظر ها',
            // 'create comments' => 'ایجاد نظر ها',
            // 'edit comments' => 'ویرایش نظر ها',
            // 'delete comments' => 'حذف نظر ها',
            // //comments
            // 'view orders' => 'مشاهده خرید ها',
            // 'create orders' => 'ایجاد خرید ها',
            // 'edit orders' => 'ویرایش خرید ها',
            // 'delete orders' => 'حذف خرید ها',
        ];

        foreach ($permissions as $name => $label) {
            Permission::query()->firstOrCreate(
                ['name' => $name],
                ['label' => $label, 'guard_name' => 'web']
            );
        }
    }
}
