<?php

//todo make unit test for all
//todo add clean tmp dir when new export or import make

/**
 * Init
 */
$exit = false;
$errors = array();
$status = '';

/**
 * Config load
 */
$config_file_path = BASEDIR.'sm/core/config/config.php';
require_once BASEDIR.'sm/core/Config.class.php';
$config = new Config();
$config->load_conf($config_file_path);


//$controller = new Engine\Controller();
//$controller->init($config_file_path); //todo add file test

/**
 * Request send
 * Request must be sent as JSON
 */
if(isset($_POST['send'])){
    require_once BASEDIR.'sm/core/controllers/RequestController.class.php';
    //Passed request test and convert to request obj
    if(isset($_POST['request']) || true){ //todo Make real test is request set
        //$req_array = json_decode($_POST['request']);
        //todo Make real JSON Array sending
        $req_data = array();
        foreach($_POST as $key => $val){
            $req_data[$key] = $val;
        }
        $req = new RequestController($config);
        $req->req_process($req_data);
        $status = 'Запрос обработан';
    } else {
        array_push($errors, 'Request not passed');
        $status = 'Ошибка обработки запроса';
    }
    $exit = true;
}

/**
 * Request export
 */
if(isset($_POST['req_export'])){
    if($config->req_export()) {
        require_once BASEDIR.'sm/core/controllers/ExportController.class.php';
        $export = new ExportController($config);
        $req_tbl = $config->req_tbl_name();
        $exp_path = $config->exp_path();
        $exp_name = $config->req_exp_file_name();
        $tbl_structure = $config->req_structure(); //todo remove tbl structure when rework will be
        $export_file_path = $export->export_full_tbl($req_tbl, $tbl_structure, $exp_path, $exp_name);
        echo $export_file_path;
        $status = 'Файл экспорта заявок подготовлен';
    } else {
        $status = 'Экспорт заявок отключен';
        //echo 'Request export is "OFF"';
    }

    $exit = true;
}

/**
 * Products data export
 */
if(isset($_POST['prod_export'])){
    if($config->prod_export()) {
        require_once BASEDIR.'sm/core/controllers/ExportController.class.php';
        $export = new ExportController($config);
        $req_tbl = $config->prod_tbl_name();
        $exp_path = $config->exp_path();
        $exp_name = $config->prod_exp_file_name();
        $tbl_structure = $config->prod_structure(); //todo remove tbl structure when rework will be
        $export_file_path = $export->export_full_tbl($req_tbl, $tbl_structure, $exp_path, $exp_name);
        echo $export_file_path;
        $status = 'Файл экспорта данных подготовлен';
    } else {
        $status = 'Экспорт данных отключен';
        //echo 'Products export is "OFF"';
    }
    $exit = true;
}

/**
 * Products images export
 */
if(isset($_POST['img_export'])){
    if($config->prod_export()){
        require_once BASEDIR.'sm/core/controllers/ProductImgExportController.class.php';
        $export = new ProductImgExportController($config);
        $export->export();
        $status = 'Файл экспорта изображений подготовлен';
    } else {
        $status = 'Экспорт изображений отключен';
        //echo 'Products export is "OFF"';
    }
    $exit = true;
}


/**
 * Product data update
 */
if(isset($_POST['prod_import'])){
    if($config->prod_update()) {
        $upload_dir = BASEDIR.'sm/tmp/import/';
        $file_name = 'cars_list';
        $upload_file_path = $upload_dir . $_FILES[$file_name]['name'];
        move_uploaded_file($_FILES[$file_name]['tmp_name'], $upload_file_path);

        if (file_exists($upload_file_path)) {
            require_once BASEDIR.'sm/core/controllers/ProductUpdateController.class.php';
            $updater = new ProductUpdateController($config);
            $updater->update($upload_file_path);
            $status = 'Данные обновлены';
        } else {
            //echo 'file not exist';
            $status = 'Ошибка обработки файла';
        }
    }else{
        $status = 'Обновление данных октлючено';
        //echo 'Products update is "OFF"';
        $exit = true;
    }
}

/**
 * Product images update
 */
if(isset($_POST['img_update'])){
    if($config->prod_update()) {
        $upload_dir = BASEDIR.'sm/tmp/import/';
        $file_name = 'products_fotos';
        $upload_file_path = $upload_dir . $_FILES[$file_name]['name'];
        move_uploaded_file($_FILES[$file_name]['tmp_name'], $upload_file_path);

        if (file_exists($upload_file_path)) {
            require_once BASEDIR.'sm/core/controllers/ProductImgUpdateController.class.php';
            $updater = new ProductImgUpdateController($config);
            $updater->update($upload_file_path);
            $status = 'Изображения обновлены';
        } else {
            //echo 'file not exist';
            $status = 'Ошибка обработки файла';
        }
    } else {
        $status = 'Обновление данных октлючено';
        //echo 'Products update is "OFF"';
        $exit = true;
    }
}



/**
 * Install tables
 */

if(isset($_GET['install'])){
    include_once 'install.php';
    $exit = true;
}

/**
 * Load admin panel
 */
if((isset($_GET['admin']) || isset($_POST['admin'])) && !$exit){
    //Check login data
    if(isset($_POST['login_form'])){
        require_once BASEDIR.'sm/core/controllers/AuthController.class.php';
        $auth = new AuthController($config);
        $name = $_POST['login'];
        $password = $_POST['password'];
        $res = $auth->log_in($name, $password);
        if(!$res){
            $status = 'Не правильный логин или пароль';
        }
    }

    //Check is logged
    if(isset($_SESSION['login']) && isset($_SESSION['id'])){
        $login = true;
    } else {
        $login = false;
    }

    if(count($errors) > 0){
        $status = $errors[0];
    }
    include BASEDIR.'admin/admin.php';
    $exit = true;
}

/**
*All product in JSON
*/
if(isset($_GET['all'])) {
    require_once BASEDIR.'sm/core/controllers/ViewController.class.php';
    $view = new ViewController($config);
    $products = $view->get_all();
    echo json_encode($products);
    $exit = true;
}

/**
 * Load main page
 */
if(!$exit){
    //Prepare output
    require_once BASEDIR.'sm/core/controllers/ViewController.class.php';
    $view = new ViewController($config);
    $products = $view->get_all();
    include BASEDIR.'main.php';
}

/**
 * Exit if is set
 */
if($exit){
    exit;
}




//print_r($errors);