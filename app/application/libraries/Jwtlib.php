<?php
use Firebase\JWT\JWT;

defined('BASEPATH') OR exit('No direct script access allowed');

class Jwtlib extends CI_Controller {

    private $key = "APVS2660@WhyDigital!";

    public function __construct(){
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
    }

    public function createToken($dateExpire,$uid,$data){
        $key = $this->key;
        $payload = [
            'exp' => strtotime($dateExpire),
            'uid' => $uid,
            'data' => $data,
        ];
        $jwt = JWT::encode($payload, $key);
        return $jwt;
    }


	public function decodeToken($jwt){
        if(empty($jwt)){
            $this->CI->api->response(401, array('status' => false, 'message'=>'Token necessário'));
        }

        try {
            $key = $this->key;
            JWT::$leeway = 600;
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            return $decoded;
        } catch (\Throwable $th) {
            $this->CI->api->response(401, array('status' => false, 'message'=>$th->getMessage()));
        }
    }
}
