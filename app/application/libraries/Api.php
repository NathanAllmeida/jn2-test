<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * API
 * @author     almeidanathan96@gmail.com
 */
class Api extends CI_Controller {

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->model('users_api_model');
    }

    public function allowedMethods($methods){
        if(array_search($_SERVER['REQUEST_METHOD'],$methods)===false){
            $this->response(405,array('status'=>'false','message'=>'Metodo "'.$_SERVER['REQUEST_METHOD'].'" não permitido'));
        }
    }

	public function response($code,$response){
        http_response_code($code);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($response);
        die;
    }


    public function getBearerToken(){
        $headers = $this->CI->input->get_request_header('Authorization');
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    public function getApiKey(){
        return $this->CI->input->get_request_header("X-API-KEY");
    }

    public function validateApiKey(){
        $apiKey = $this->getApiKey();
        if(empty($apiKey)){
            $this->response(401, array('status' => false, 'message'=>'Api Key necessário'));
        }
        $check = $this->CI->users_api_model->where(['status'=>1,'api_key'=>$apiKey])->get();
        if(!empty($check)){
            return $check;
        }else{
            $this->CI->api->response(401, array('status' => false, 'message'=>'API Key não é valida'));
        }
    }

    public function validateBearerToken(){
        $token = $this->getBearerToken();
        $decodedToken = $this->CI->jwtlib->decodeToken($token);
        return $decodedToken;
    }
}
