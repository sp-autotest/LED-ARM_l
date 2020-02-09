<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'menu' => [[
        'icon' => 'fa fa-exclamation-circle',
        'title' => 'Рабочий стол',
        'url' => '/admin',
        'caret' => false,
        
    ],[
        'icon' => 'fa fa-plus-square',
        'title' => 'Поиск услуг',
        'url' => '/crane',
        'caret' => false,
        
    ],[
        'icon' => 'fa fa-cart-plus',
        'title' => 'Заказы',
        'url' => '/orders',
        'caret' => false,

    ],[
        'icon' => 'fa fa-fighter-jet',
        'title' => 'Блоки мест',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => [[
            'url' => '/schedules',
            'title' => 'Расписания'
        ],[
            'url' => '/blocks',
            'title' => 'Блоки'
        ]]
    ],[
        'icon' => 'fa fa-chart-bar',
        'title' => 'Отчеты',
        'url' => '#',
        'caret' => false,

    ],[
        'icon' => 'fa fa-comments',
        'title' => 'Сообщения',
        'url' => '/admin/messages',
        'caret' => false,
        
    ],[
        'icon' => 'fa fa-cogs',
        'title' => 'Управление',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => [[
            'title' => 'Компании',
            'url' => '/admin/companies',
        ],[
            'url' => '/financies',
            'title' => 'Финансы'
        ],[
            'url' => 'javascript:;',
            'title' => 'Права',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => '/admin/permissions',
                    'title' => 'Группы'
                ],
                [
                    'url' => '/admin/users',
                    'title' => 'Сотрудники'
                ],
            ]
        ],[
            'url' => '/feesplaces',
            'title' => 'Сборы'
        ],[
            'url' => '#',
            'title' => 'Рассылки'
        ],[
            'url' => '#',
            'title' => 'Справочники'
        ]
       
        ,[
            'url' => '/get_provider',
            'title' => 'Провайдеры'
        ]

        ,[
            'url' => '/get_airlene',
            'title' => 'Авиалинии'
        ],

        [
            'url' => '/blocksorders',
            'title' => 'Блоки:Заказы'
        ],



        [
            'url' => '/get_country',
            'title' => 'Страны'
        ],


        [
            'url' => '/get_city',
            'title' => 'Города'
        ],
        

        [
            'url' => '/get_farefamily',
            'title' => 'Тип ВС'
        ]

        ,[
            'url' => '/get_currency',
            'title' => 'Справочник валют'
        ]

        ,[
            'url' => '/get_passenger',
            'title' => 'Пассажиры'
        ]
        ,[
            'url' => '/get_type_fee',
            'title' => 'Тип сборов'
        ]


           ,[
            'url' => '/get_mailing',
            'title' => 'Рассылки'
        ]



        ,[
            'url' => '/admin/settings/advertising',
            'title' => 'Маршрут-квитанция'
        ],[
            'url' => '#',
            'title' => 'История'
        ]
        ]
    ]/*[
        'icon' => 'fa fa-th-large',
        'title' => 'Группы/доступы',
        'url' => '/admin/permissions',
        'caret' => false,

    ],[
        'icon' => 'fa fa-th-large',
        'title' => 'Пользователи',
        'url' => '/admin/users',
        'caret' => false,
        
    ],*//*[
        'icon' => 'fa fa-image',
        'title' => 'Gallery',
        'url' => 'javascript:;',
        'caret' => true,
        'sub_menu' => [[
            'url' => '/gallery/v1',
            'title' => 'Gallery v1'
        ],[
            'url' => '/gallery/v2',
            'title' => 'Gallery v2'
        ]]
    ]*/
    /*[
            'icon' => 'fa fa-th-large',
            'title' => 'CRANE',
            'url' => '/crane',
            'caret' => false,
    ]*/]
];
