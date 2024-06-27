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
            'view customerReviews' => 'مشاهده نظر مشتریان ها ',
            'create customerReviews' => 'ایجاد نظر مشتریان',
            'edit customerReviews' => 'ویرایش نظر مشتریان ',
            'delete customerReviews' => 'حذف نظر مشتریان ',
            //ticket
            'view tickets' => 'مشاهده تیکت ها ',
            //purchaseAdvisor
            'view purchase_advisors' => 'مشاهده مشاوره خرید ها ',
            'edit purchase_advisors' => 'مشاهده مشاوره خرید ها ',
            //jobs
            'view jobs' => 'مشاهده شغل ها ',
            'create jobs' => 'ایجاد شغل',
            'edit jobs' => 'ویرایش شغل ',
            'delete jobs' => 'حذف شغل ',
            //resumes
            'view resumes' => 'مشاهده رزومه ها ',
            'create resumes' => 'ایجاد رزومه',
            'edit resumes' => 'ویرایش رزومه ',
            'delete resumes' => 'حذف رزومه ',
            //brands
            'view brands' => 'مشاهده برند ها ',
            'create brands' => 'ایجاد برند',
            'edit brands' => 'ویرایش برند ',
            'delete brands' => 'حذف برند ',
            //workSample
            'view workSample' => 'مشاهده نمونه کار ها ',
            'create workSample' => 'ایجاد نمونه کار',
            'edit workSample' => 'ویرایش نمونه کار ',
            'delete workSample' => 'حذف نمونه کار ',
        ];

        foreach ($permissions as $name => $label) {
            Permission::query()->firstOrCreate(
                ['name' => $name],
                ['label' => $label, 'guard_name' => 'web']
            );
        }
    }
}
