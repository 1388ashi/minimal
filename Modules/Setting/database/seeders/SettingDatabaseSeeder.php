<?php

namespace Modules\Setting\database\seeders;

use Illuminate\Database\Seeder;
use DB;
use Modules\Setting\Models\Setting;
class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'group' => Setting::GROUP_GENERAL,
                'name' => 'app_name',
                'label' => 'نام سایت',
                'type' => Setting::TYPE_TEXT,
                'value' => 'همیار آکادمی'
            ],
            [
                'group' => Setting::GROUP_GENERAL,
                'name' => 'logo',
                'label' => 'لوگو',
                'type' => Setting::TYPE_IMAGE,
                'value' => ''
            ],
            [
                'group' => Setting::GROUP_SOCIAL,
                'name' => 'telegram',
                'label' => 'تلگرام',
                'type' => Setting::TYPE_TEXT,
                'value' => ''
            ],
            [
                'group' => Setting::GROUP_SOCIAL,
                'name' => 'instagram',
                'label' => 'اینستاگرام',
                'type' => Setting::TYPE_TEXT,
                'value' => ''
            ],
        ];

        //Insert settings
        $count = count($settings);
        for ($i = 0; $i < $count; $i++) {
            $setting = Setting::query()->firstOrCreate(
                [
                    'name' => $settings[$i]['name']
                ],
                [
                    'group' => $settings[$i]['group'],
                    'label' => $settings[$i]['label'],
                    'type' => $settings[$i]['type'],
                    'value' => $settings[$i]['value']
                ]
            );
        }

    }
}
