<?php

return array(
    /*
     * Request config
     * Use for config request structure
     * Using for mailing, DB install and saving, export
     */
    'request_config' => array(
            'req_fields' => array(
                //For name separation use underline only
                'id' => array('ID','smallint'), //Must be there with same name
                'date_time' => array('Дата создания', 'timestamp'), //Must be there with same name
                'name' => array('Имя', 'text'),
                'phone' => array('Телефон', 'text'),
                'email' => array('Email', 'text'),
                'form_type' => array('Тип заявки', 'text'),
                'salon' => array('Адрес салона', 'text'),
                'brand' => array('Бренд', 'text'),
                'model' => array('Модель', 'text'),
                'car_info' => array('Интересует авто', 'text'),
                'car_year' => array('Год выпуска', 'text'),
                'model_year' => array('Модельный ряд', 'text'),
                'car_color' => array('Цвет', 'text'),
                'credit' => array ('Узнать о кредите', 'text')
            ),
            'db_table' => 'audi_requests_acm'
    ),

    /*
     * Product config
     * Use for config product structure
     * Using for product output, product export and import
     */
    'product_config' => array(
            'prod_fields' => array(
                //For name separation use underline only
                'id' => array('ID','smallint'), //Must be there with same name
                'date_time' => array('Дата создания', 'timestamp'), //Must be there with same name
                'model' => array('Модель', 'text'),
                'grade' => array('Комплектация', 'text'),
                'car_year' => array('Год выпуска', 'text'),
                'model_year' => array('Модельный ряд', 'text'),
                'car_color' => array('Цвет', 'text'),
                //todo make spasial variable for image export
                'img' => array('Ссылка на фото', 'text') //Must be there and must have name 'img' for image
            ),
            'db_table' => 'audi_cars_acm'
    ),

    /*
     * User table config
     * Use for authorize in admin panel
     */
    'users_config' => array(
        'users_fields' => array(
            //For name separation use underline only
            'id' => array('ID','smallint'), //Must be there with same name
            'date_time' => array('Дата создания', 'timestamp'), //Must be there with same name
            'login' => array('Логин', 'text'),
            'password' => array('Пароль', 'text'),
            'access_tbl' => array('Доступная таблица', 'text')
        ),
        'db_table' => 'users'
    ),


    /*
     * Send request to email module control
     * Use "on" or "off"
     */
    'send_on_email' => 'off',

    /*
     * Path to send mail config file
     * Path regard of this file path
     */

    'send_email_config' => 'sm/config/mailing_conf.php',

    /*
    * Use mail template
    * If on will using mail template, if off will using simple mail generation
    */

    'mail_template' => 'off',
    'mail_template_path' => 'sm/mail_templates/simple_template.php',



    /*
     * Work with DataBase control
     * Use "on" or "off"
     */

    'db' => 'off',

    /*
     * Path to config file for working with DataBase
     * Path regard of this file path
     */

    'db_config' => array(
        'url' => 'localhost',
        'name' => 'hosttevz-bget-ru-audi',
        'user' => 'root',
        'password' => ''
    ),


    /*
     * Save request to database module control
     * For working 'db' must be 'on'
     * Use "on" or "off"
     */

    'save_req_to_db' => 'off',

    /*
     * Export path
     * There will be save all export files
     */
    'export_path' => 'sm/tmp/export/',

    /*
     * Requests export module control
     * For working 'db' and 'save_req_to_db' must be 'on'
     * Use "on" or "off"
     */

    'req_export' => 'off',

    /*
     * Request export file name
     */
    'req_export_file_name' => 'audi_requests_('.date('d-m-y').').xls',


    /*
     * Use DB as store for products
     * For working 'db' must be 'on'
     * Use "on" or "off"
     */

    'prod_in_db' => 'off',

    /*
     * Product export module control
     * For working 'db' must be 'on'
     * Use "on" or "off"
     */

    'prod_export' => 'off',

    /*
     * Products export file name
     */
    'prod_export_file_name' => 'audi_cars_('.date('d-m-y').').xls',

    /*
     * Product images export module control
     * For working 'db' must be 'on'
     * Use "on" or "off"
     */
    'prod_img_export' => 'off',

    /*
     * Products img export file name
     */
    'prod_img_export_file_name' => 'audi_cars_img_('.date('d-m-y').').zip',

    /*
     * Products update module control
     * For working 'db' must be 'on'
     * Use "on" or "off"
     */

    'prod_update' => 'off',

    /*
     * Products images update module control
     * For working 'db' must be 'on'
     * Use "on" or "off"
     */

    'prod_img_update' => 'off',

    /*
     * Product update tmp path
     * Use for temporary saving import files
     */

    'import_path' => 'sm/tmp/import/',

    /*
     * Product images path
     * Use for remove old images when updating
     */
    'product_img_path' => 'img/content/Audi',

    /*
     * Admin panel enable state
     * Use "on" or "off"
     */
    'admin_panel' => 'off',

        /*
     * Show counters
     */
    'counters' => 'off',

);