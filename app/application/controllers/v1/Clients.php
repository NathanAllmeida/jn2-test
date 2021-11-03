<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clients extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Load Clients Model
        $this->load->model("clients_model");
    }

    public function get(int $clientId){
        $this->api->validateApiKey();
        $this->api->validateBearerToken();

        $this->api->allowedMethods(['GET']);

        $client = $this->clients_model->where(['status'=>1])->get($clientId);
        if(!empty($client)){
            $this->api->response(200,['status'=>true,'data'=>$client]);
        }else{
            $this->api->response(404,['status'=>false,'message'=>"Cliente não encontrado"]);
        }
    }

    public function getByEndLicensePlate($endLicensePlate){
        $this->api->allowedMethods(['GET']);
        $this->api->validateApiKey();
        $this->api->validateBearerToken();

        $page = empty($this->input->get('page'))?1:$this->input->get('page');
        $rows = 10;
        $totalRows = $this->clients_model->where(['status'=>1,'license_plate like'=>"%".$endLicensePlate])->count_rows();
        $totalPages = ceil($totalRows/$rows);
        $offset = ($page * $rows) - $rows;

        $clients = $this->clients_model->where(['status'=>1,'license_plate like'=>"%".$endLicensePlate])->limit($rows,$offset)->get_all();
        if(!empty($clients)){
            $this->api->response(200,['status'=>true,'data'=>$clients,'total'=>$totalRows,'totalPages'=>$totalPages,'page'=>$page]);
        }else{
            $this->api->response(404,['status'=>false,'message'=>"Veículo não encontrado"]);
        }
    }

    public function new(){
        $this->api->validateApiKey();
        $this->api->validateBearerToken();

        $data = json_decode(file_get_contents("php://input"), true);
        if(!empty($data)){
            if(!empty($data['name'])&&!empty($data['phone'])&&!empty($data['cpf'])&&!empty($data['license_plate'])){
                $check = $this->clients_model->where(['cpf'=>$data['cpf'],'license_plate'=>$data['license_plate'],'status'=>1])->get();
                if(empty($check)){
                    $data['phone'] = preg_replace("/[^0-9]/", "", $data['phone']);
                    $data['cpf'] = preg_replace("/[^0-9]/", "", $data['cpf']);
                    $dataInsert = [
                        'name'=>$data['name'],
                        'phone'=>$data['phone'],
                        'cpf'=>$data['cpf'],
                        'license_plate'=>$data['license_plate'],
                    ];

                    $clientId = $this->clients_model->insert($dataInsert);
                    if(!empty($clientId)){
                        $dataClient = $this->clients_model->get($clientId);
                        if(!empty($dataClient)){
                            $this->api->response(200,['status'=>true,'message'=>"Sucesso ao inserir novo cliente","data"=>$dataClient]);
                        }else{
                            $this->api->response(500,['status'=>false,'message'=>"Erro ao inserir novo cliente! Cód: SC-1"]);
                        }
                    }else{
                        $this->api->response(500,['status'=>false,'message'=>"Erro ao inserir novo cliente! Cód: SC-2"]);
                    }
                }else{
                    $this->api->response(400,['status'=>false,'message'=>"Já existe um cliente com este mesmo cpf e placa"]);
                }
            }else{
                $this->api->response(400,['status'=>false,'message'=>"Há campos vazios"]);
            }
        }else{
            $this->api->response(400,['status'=>false,'message'=>"Campops vazios"]);
        }
    }

    public function edit($clientId){
        $this->api->validateApiKey();
        $this->api->validateBearerToken();

        $data = json_decode(file_get_contents("php://input"), true);
        if(!empty($clientId)){
            if(!empty($data)){
                if(!empty($data['name'])&&!empty($data['phone'])&&!empty($data['cpf'])&&!empty($data['license_plate'])){
                    $check = $this->clients_model->where(['status'=>1])->get($clientId);
                    if(!empty($check)){
                        $data['phone'] = preg_replace("/[^0-9]/", "", $data['phone']);
                        $data['cpf'] = preg_replace("/[^0-9]/", "", $data['cpf']);
                        $dataUpdate = [
                            'name'=>$data['name'],
                            'phone'=>$data['phone'],
                            'cpf'=>$data['cpf'],
                            'license_plate'=>$data['license_plate'],
                        ];

                        $return = $this->clients_model->update($dataUpdate,$clientId);
                        if(!empty($return)){
                            $dataClient = $this->clients_model->where(['status'=>1])->get($clientId);
                            if(!empty($dataClient)){
                                $this->api->response(200,['status'=>true,'message'=>"Sucesso ao atualizar cliente","data"=>$dataClient]);
                            }else{
                                $this->api->response(500,['status'=>false,'message'=>"Erro ao atualizar cliente! Cód: SC-1"]);
                            }
                        }else{
                            $this->api->response(500,['status'=>false,'message'=>"Erro ao atualizar cliente! Cód: SC-2"]);
                        }
                    }else{
                        $this->api->response(400,['status'=>false,'message'=>"Não existe cliente com este ID"]);
                    }
                }else{
                    $this->api->response(400,['status'=>false,'message'=>"Há campos vazios"]);
                }
            }else{
                $this->api->response(400,['status'=>false,'message'=>"Campos vazios"]);
            }
        }else{
            $this->api->response(400,['status'=>false,'message'=>"Id do cliente é necessário"]);
        }
    }

    public function delete($clientId){
        $this->api->validateApiKey();
        $this->api->validateBearerToken();

        if(!empty($clientId)){
            $check = $this->clients_model->where(['status'=>1])->get($clientId);
            if(!empty($check)){
                $dataUpdate = [
                    'status'=>2
                ];

                $return = $this->clients_model->update($dataUpdate,$clientId);
                if(!empty($return)){
                    $this->api->response(200,['status'=>true,'message'=>"Sucesso ao deletar cliente"]);
                }else{
                    $this->api->response(500,['status'=>false,'message'=>"Erro ao deletar cliente! Cód: SC-2"]);
                }
            }else{
                $this->api->response(400,['status'=>false,'message'=>"Não existe cliente com este ID"]);
            }
        }else{
            $this->api->response(400,['status'=>false,'message'=>"Id do cliente é necessário"]);
        }
    }
}
