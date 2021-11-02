<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Errors extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function error404(){
        $this->api->response(404,['status'=>false,'message'=>"Metódo não encontrado"]);
    }
}
