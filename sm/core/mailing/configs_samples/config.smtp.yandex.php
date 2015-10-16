<?php
/**
 * Config for send mail with using Yandex SMTP in html format
 * Without using Yandex.Domainmail service
 * User: lead-worker
 * Date: 18.03.2015
 * Time: 21:47
 */

return array(
    'from_name' => 'username', //Important to use same username
    'from_email' => 'username@yandex.ru', //Important to use same username
    'to_emails' => array(
        'username@yandex.ru'
    ),
    'use_smtp' => true,
    'smtp_settings' => array(
        'host' => 'smtp.yandex.ru',
        'auth' => true,
        'username' => 'username', //From email 'username@yandex.ru' use only 'username'
        'password' => '',
        'secure' => 'ssl',
        'port' => '465'
    ),
    'in_html' =>true
);