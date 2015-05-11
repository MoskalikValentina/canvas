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
                'name' =>array('Имя', 'text'),
                'phone' =>array('Телефон', 'text'),
                'article' => array('Артикул', 'text'),
                'title' => array('Название', 'text'),
                'count' => array('Количество', 'text'),
                'color' => array('Цвет', 'text'),
                'form_type' => array('Тип заявки', 'text'),
                'text' => array('Текст отзыва', 'text')
            ),
            'db_table' => '_requests'
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
                'article' => array('Артикул', 'text'),
                'title' => array('Название', 'text'),
                'price' => array('Цена', 'text'),
                'old_price' =>array('Старая цена'),
                'count' => array('Количество', 'text'),
                'color' => array('Цвет', 'text'),
                'img' => array('Путь к изображению', 'text'),
                'category' => array('Категория', 'text')
            ),
            'db_table' => '_products'
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
    'send_on_email' => 'on',

    /*
     * Path to send mail config file
     * Path regard of this file path
     */

    'send_email_config' => 'sm/core/config/mailing_conf.php',

    /*
     * Work with DataBase control
     * Use "on" or "off"
     */

    'db' => 'on',

    /*
     * Path to config file for working with DataBase
     * Path regard of this file path
     */

    'db_config' => array(
        'url' => 'localhost',
        'name' => '',
        'user' => 'root',
        'password' => ''
    ),


    /*
     * Save request to database module control
     * For working 'db' must be 'on'
     * Use "on" or "off"
     */

    'save_req_to_db' => 'on',

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

    'req_export' => 'on',

    /*
     * Request export file name
     */
    'req_export_file_name' => '_requests_('.date('d-m-y').').xls',

    /*
     * Product export module control
     * For working 'db' must be 'on'
     * Use "on" or "off"
     */

    'prod_export' => 'on',

    /*
     * Products export file name
     */
    'prod_export_file_name' => '_products_('.date('d-m-y').').xls',


    /*
     * Products img export file name
     */
    'prod_img_export_file_name' => '_products_img_('.date('d-m-y').').zip',

    /*
     * Products update module control
     * For working 'db' must be 'on'
     * Use "on" or "off"
     */

    'prod_update' => 'on',

    /*
     * Product update tmp path
     * Use for temporary saving import files
     */

    'import_path' => 'sm/tmp/import',

    /*
     * Product images path
     * Use for remove old images when updating
     */
    'product_img_path' => 'img/products'

);