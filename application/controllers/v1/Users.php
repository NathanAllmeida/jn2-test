<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_api_model');
    }


    public function generateToken()
    {
        $this->api->allowedMethods(['GET']);

        $dataUser = $this->api->validateApiKey();

        $checkUser = $this->users_api_model->get($dataUser['user_api_id']);
        if (!empty($checkUser)) {
            $dateExpire = date('Y-m-d H:i:s', strtotime('+2 hours'));
            $token = $this->jwtlib->createToken($dateExpire, $checkUser['user_api_id'], ['email' => $checkUser['email'], 'user_id' => $checkUser['user_api_id']]);
            if (!empty($token)) {
                $this->api->response(200, array('status' => true, 'user' => ['access_token' => $token]));
            } else {
                $this->api->response(500, array('status' => true, 'message' => "Erro ao gerar o token! Cód: S3"));
            }
        } else {
            $this->api->response(401, array('status' => false, 'message' => "Dados incorretos! Cód: S2"));
        }
    }
}
