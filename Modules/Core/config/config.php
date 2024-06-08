<?php
return [
    'name' => 'Core',

    //type = ['number', 'text', 'email', 'select']
    //column_type = ['string', 'int', 'date']
    'filters' => [
        'id' => [
            'column' => 'id',
            'type' => 'number',
            'placeholder' => 'شناسه را اینجا وارد کنید',
            'operator' => '=',
            'column_type' => 'int'
        ],
        'title' => [
            'column' => 'title',
            'type' => 'text',
            'placeholder' => 'عنوان را اینجا وارد کنید',
            'operator' => 'like',
            'column_type' => 'string'
        ],
        'writer' => [
            'column' => 'writer',
            'type' => 'text',
            'placeholder' => 'نویسنده را اینجا وارد کنید',
            'operator' => 'like',
            'column_type' => 'string'
        ],
        'name' => [
            'column' => 'name',
            'type' => 'text',
            'placeholder' => 'نام را اینجا وارد کنید',
            'operator' => 'like',
            'column_type' => 'string'
        ],
        'mobile' => [
            'column' => 'mobile',
            'type' => 'text',
            'placeholder' => 'شماره موبایل را اینجا وارد کنید',
            'operator' => 'like',
            'column_type' => 'string'
        ],
        'email' => [
            'column' => 'email',
            'type' => 'email',
            'placeholder' => 'آدرس ایمیل را اینجا وارد کنید',
            'operator' => 'like',
            'column_type' => 'string'
        ],
        'tracking_code' => [
            'column' => 'tracking_code',
            'type' => 'text',
            'placeholder' => 'کد پیگیری را اینجا وارد کنید',
            'operator' => 'like',
            'column_type' => 'string'
        ],
        'teacher_id' => [
            'column' => 'teacher_id',
            'type' => 'select',
            'placeholder' => 'مدرس را انتخاب کنید',
            'options' => [],
            'operator' => '=',
            'column_type' => 'int',
            'relation' => [
                'name' => 'teachers',
                'type' => 'belongsToMany'
            ]
        ],
        'course_id' => [
            'column' => 'course_id',
            'type' => 'select',
            'placeholder' => 'دوره را انتخاب کنید',
            'options' => [],
            'operator' => '=',
            'column_type' => 'int',
            'relation' => [
                'name' => 'user',
                'type' => 'belongsTo'
            ]
        ],
        'user_id' => [
            'column' => 'user_id',
            'type' => 'select',
            'placeholder' => 'کاربر را انتخاب کنید',
            'options' => [],
            'operator' => '=',
            'column_type' => 'int',
            'relation' => [
                'name' => 'user',
                'type' => 'belongsTo'
            ]
        ],
        'category_id' => [
            'column' => 'category_id',
            'type' => 'select',
            'placeholder' => 'دسته بندی را انتخاب کنید',
            'options' => [],
            'operator' => '=',
            'column_type' => 'int',
            'relation' => [
                'name' => 'category',
                'type' => 'belongsTo'
            ]
        ],
        'product_id' => [
            'column' => 'product_id',
            'type' => 'select',
            'placeholder' => 'محصول را انتخاب کنید',
            'options' => [],
            'operator' => '=',
            'column_type' => 'int',
            'relation' => [
                'name' => 'product',
                'type' => 'belongsTo'
            ]
        ],
        'file_type' => [
            'column' => 'file_type',
            'type' => 'select',
            'placeholder' => 'نوع فایل را انتخاب کنید',
            'options' => [],
            'operator' => '=',
            'column_type' => 'string'
        ],
        'status' => [
            'column' => 'status',
            'type' => 'select',
            'placeholder' => 'وضعیت را انتخاب کنید',
            'options' => [
                'on' => 'فعال',
                'off' => 'غیرفعال',
            ],
            'operator' => '=',
            'column_type' => 'string'
        ],
        'comment' => [
            'column' => 'status',
            'type' => 'select',
            'placeholder' => 'وضعیت را انتخاب کنید',
            'options' => [
                'pending' => 'در حال بررسی',
                'accepted' => 'تایید شده',
                'rejected' => 'رد شده',
            ],
            'operator' => '=',
            'column_type' => 'string'
        ],
        'active' => [
            'column' => 'active',
            'type' => 'select',
            'placeholder' => 'وضعیت فعال بودن را انتخاب کنید',
            'options' => [
                'on' => 'فعال',
                'off' => 'غیرفعال',
            ],
            'operator' => '=',
            'column_type' => 'string'
        ],
        'from_date' => [
            'column' => 'created_at',
            'type' => 'date',
            'placeholder' => 'از تاریخ ثبت',
            'operator' => '>=',
            'column_type' => 'datepicker'
        ],
        'to_date' => [
            'column' => 'created_at',
            'type' => 'date',
            'placeholder' => 'تا تاریخ ثبت',
            'operator' => '<=',
            'column_type' => 'datepicker'
        ]
    ]
];


