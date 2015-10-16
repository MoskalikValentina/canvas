<?php

//todo Make check exists install directory

class RouterCore {

    protected $router;

    public function __construct()
    {
        //Preparing router
        require_once BASEDIR . 'sm/vendor/autoload.php';
        $klein = new \Klein\Klein();
        $this->router = $klein;
    }

    /**
     * Initialize router
     */
    public function init(){

        //Register core routes
        $this->coreRoutesRegister();

        //Register custom routes
        $this->customRoutsRegister();

        //Dispatch
        $this->router->dispatch();
    }

    /**
     * Check subdirectory using and change REQUEST_URI if it is
     */
    public function subDirInit(){
        // For installing in subdir
        $base  = dirname($_SERVER['PHP_SELF']);

        // Update request when we have a subdirectory
        if(ltrim($base, '/')){

            $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($base));
        }
    }

    /**
     * Registering all routs
     */
    protected function customRoutsRegister(){

        $this->router->respond('GET', '/', function() {
            $config = configLoad();
            //If product saving in db on
            if($config->prodInDB()) {
                //Prepare output
                require_once BASEDIR . 'sm/core/controllers/ViewController.class.php';
                $view = new ViewController($config);
                $products = $view->get_all();
            }

            include BASEDIR . 'views/main.php';
        });
    }


    protected function coreRoutesRegister(){
        /**
         * Request send
         * Request must be sent as JSON
         */
        $this->router->respond('POST', '/send', function() {
            require_once BASEDIR.'sm/core/controllers/RequestController.class.php';
            $config = configLoad();
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
        });

        /**
         * Admin routes
         */

        /**
         * Load admin panel
         */
        $this->router->respond(array('GET', 'POST'), '/admin', function($request, $response) {
            $config = configLoad();
            $status = isset($_GET['status']) ? $_GET['status'] : '';
            if($config->admin_panel()){
                $errors = array();
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
                    session_start();
                    $login = false;
                }

                if(count($errors) > 0){
                    $status = $errors[0];
                }
                include BASEDIR . 'sm/admin/admin.php';
            } else {
                $response->redirect('/');
            }
        });


        /**
         * User logout
         */
        $this->router->respond(array('GET', 'POST'), '/log-out', function($request, $response) {
            require_once BASEDIR.'sm/core/controllers/AuthController.class.php';
            AuthController::log_out();
            $response->redirect('/');
        });

        /**
         * Request export
         */
        $this->router->respond('GET', '/req_export', function($request, $response) {
            if(isset($_SESSION['login']) && isset($_SESSION['id'])) {
                $config = configLoad();
                if ($config->req_export()) {
                    require_once BASEDIR . 'sm/core/controllers/ExportController.class.php';
                    require_once BASEDIR . 'sm/core/helpers/FileLoader.class.php';

                    $export = new ExportController($config);
                    $req_tbl = $config->req_tbl_name();
                    $exp_path = $config->exp_path();
                    $exp_name = $config->req_exp_file_name();
                    $tbl_structure = $config->req_structure(); //todo remove tbl structure when rework will be
                    $export_file_path = BASEDIR . $export->export_full_tbl($req_tbl, $tbl_structure, $exp_path, $exp_name);

                    $file_loader = new FileLoader();
                    $file_loader->file_force_download($export_file_path);

                    $status = 'Файл экспорта заявок отправлен';
                } else {
                    $status = 'Экспорт заявок отключен';
                    $response->redirect('/admin');
                }
            } else {
                $response->redirect('/');
            }
        });

        /**
         * Products data export
         */

        $this->router->respond('GET', '/prod_export', function($request, $response) {
            if(isset($_SESSION['login']) && isset($_SESSION['id'])) {
                $config = configLoad();
                if ($config->prod_export()) {
                    require_once BASEDIR . 'sm/core/controllers/ExportController.class.php';
                    require_once BASEDIR . 'sm/core/helpers/FileLoader.class.php';

                    $export = new ExportController($config);
                    $req_tbl = $config->prod_tbl_name();
                    $exp_path = $config->exp_path();
                    $exp_name = $config->prod_exp_file_name();
                    $tbl_structure = $config->prod_structure(); //todo remove tbl structure when rework will be
                    $export_file_path = BASEDIR . $export->export_full_tbl($req_tbl, $tbl_structure, $exp_path, $exp_name);

                    $file_loader = new FileLoader();
                    $file_loader->file_force_download($export_file_path);

                    $status = 'Файл экспорта данных отправлен';
                } else {
                    $status = 'Экспорт данных отключен';
                    $response->redirect('/admin');
                }
            } else {
                $response->redirect('/');
            }
        });


        /**
         * Products images export
         */
        $this->router->respond('GET', '/img_export', function($request, $response) {
            if(isset($_SESSION['login']) && isset($_SESSION['id'])){
                $config = configLoad();
                if($config->prod_export()){
                    require_once BASEDIR.'sm/core/controllers/ProductImgExportController.class.php';
                    require_once BASEDIR.'sm/core/helpers/FileLoader.class.php';

                    $export = new ProductImgExportController($config);
                    $export_file_path = BASEDIR . $export->export();

                    $file_loader = new FileLoader();
                    $file_loader->file_force_download($export_file_path);

                    $status = 'Файл экспорта изображений отправлен';
                } else {
                    $status = 'Экспорт изображений отключен';
                    $response->redirect('/admin');
                }
            } else {
                $response->redirect('/');
            }

        });

        /**
         * Product data update
         */
        $this->router->respond('POST', '/prod_import', function($request, $response) {
            if(isset($_SESSION['login']) && isset($_SESSION['id'])){
                $config = configLoad();
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
                    $response->redirect('/admin?status=Данные обновлены');
                }else{
                    $status = 'Обновление данных октлючено';
                    $response->redirect('/admin');
                }
            } else {
                $response->redirect('/');
            }

        });

        /**
         * Product images update
         */
        $this->router->respond('POST', '/img_update', function($request, $response) {
            if(isset($_SESSION['login']) && isset($_SESSION['id'])){
                $config = configLoad();
                if($config->prod_update()) {
                    $upload_dir = BASEDIR.'sm/tmp/import/';
                    $file_name = 'products_fotos';
                    $upload_file_path = $upload_dir . $_FILES[$file_name]['name'];
                    move_uploaded_file($_FILES[$file_name]['tmp_name'], $upload_file_path);

                    if (file_exists($upload_file_path)) {
                        require_once BASEDIR.'sm/core/controllers/ProductImgUpdateController.class.php';
                        $updater = new ProductImgUpdateController($config);
                        $updater->update($upload_file_path);
                        $response->redirect('/admin?status=Изображения обновлены');
                    } else {
                        //echo 'file not exist';
                        $response->redirect('/admin?status=Ошибка обработки файла');
                    }
                } else {
                    $status = 'Обновление данных октлючено';
                    $response->redirect('/admin');
                }
            } else {
                $response->redirect('/');
            }

        });

        /**
         * Technical routes
         */
        /**
         * Install tables
         */
        $this->router->respond('GET', '/install', function($request, $response) {
            if(file_exists(BASEDIR . 'sm/install.php')){
                include_once BASEDIR .'sm/install.php';
            } else {
                $response->redirect('/');
            }
        });
    }
}