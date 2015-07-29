<?php
/**
 * Request object
 */

class Request {
    /**
     * @var array
     */
    private $request_data = array();
    /**
     * @var array
     */
    private $request_structure = array();

    /**
     * Construct request object
     * @param array $req_data associative with request data
     * @param array $req_structure associative with request structure from config
     */
    public function __construct(Array $req_data, Array $req_structure){
        $this->request_structure = $req_structure;
        //Load only data which in structure only
        foreach($this->request_structure as $key => $val){
            $this->request_data[$key] = isset($req_data[$key]) ? $req_data[$key] : '';
        }
    }

    /**
     * Return data as array or as string
     * @param $data_name String Name of data param for return. Use optional
     * @return Array with all data or string with field
     */
    public function get_data($data_name = ''){
        if($data_name !== ''){
            $res = $this->request_data[$data_name];
        } else {
            $res = $this->request_data;
        }
        return $res;
    }

    /*
     * Return subject for email sending
     */

    /**
     * @return string
     */
    public function get_subject(){
        return "Новая заявка (" . date("d.m.Y H:i") . ")";
    }

    /**
     * Return prepared for send mail html body
     * @param bool $is_template
     * @param string $template_path
     * @return string
     */
    public function get_mail($is_template = false, $template_path = ''){
        if($is_template){
            return $this->buildMailWithTemplate($template_path);
        } else {
            return $this->buildBasicMail();
        }
    }

    /**
     * Building simple mail body base on request params
     */
    protected function buildBasicMail(){
        $message = '<h4>Заявка от ' . date("d.m.Y H:i") . '</h4>';
        foreach($this->request_data as $k => $v){
            if($v !== '')
                $message .= $this->request_structure[$k][0] . ': ' . $v . '<br>';
        }

        return $message;
    }

    /**
     * Build mail body base on template path for which set in config
     */
    protected function buildMailWithTemplate($template_path){
        require_once $template_path;
        return $message;
    }



}