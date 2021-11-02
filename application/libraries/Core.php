<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller
{
    var $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function buildPagination($actualPage, $totalPages, $url, $isParamGet = 0, $nameParamGet = "")
    {

        $params = http_build_query($_GET);

        $html = ' <nav aria-label="Page navigation example">
                        <ul class="pagination mb-0 justify-content-center">';


        for ($i = ($actualPage - 5); $i <= ($actualPage); $i++) {
            if($i>=1&&$i!=$actualPage){
                if ($isParamGet == 0) {
                    $html .=  '<li class="page-item ' . ($actualPage == $i ? 'active' : '') . ' "><a class="page-link" href="' . ($actualPage == $i ? 'javascript:void(0)' : $url . '/' . $i . '?' . $params) . '">' . $i . '</a></li>';
                } else {
                    $params = explode('&', $params);
                    $params[$nameParamGet] = $i;
                    $params = http_build_query($params);

                    $html .=  '<li class="page-item ' . ($actualPage == $i ? 'active' : '') . ' "><a class="page-link" href="' . ($actualPage == $i ? 'javascript:void(0)' : $url . '/?' . $params) . '">' . $i . '</a></li>';
                }
            }
        }

        for ($i = $actualPage; $i <= ($actualPage + 5); $i++) {
            if($i<=$totalPages){
                if ($isParamGet == 0) {
                    $html .=  '<li class="page-item ' . ($actualPage == $i ? 'active' : '') . ' "><a class="page-link" href="' . ($actualPage == $i ? 'javascript:void(0)' : $url . '/' . $i . '?' . $params) . '">' . $i . '</a></li>';
                } else {
                    $params = explode('&', $params);
                    $params[$nameParamGet] = $i;
                    $params = http_build_query($params);

                    $html .=  '<li class="page-item ' . ($actualPage == $i ? 'active' : '') . ' "><a class="page-link" href="' . ($actualPage == $i ? 'javascript:void(0)' : $url . '/?' . $params) . '">' . $i . '</a></li>';
                }
            }
        }


        $html .= " </ul>
        </nav>";
        return $html;
    }

    public function validateLevel($levelRequired, $onlyLevel = false)
    {
        $user = $this->getUser();

        if ($onlyLevel) {
            if ($user['profile'] != $levelRequired) {
                $this->page403();
            }
        } else {
            if ($user['profile'] < $levelRequired) {
                $this->page403();
            }
        }
    }

    public function isLogged()
    {
        return !empty($this->CI->session->userdata('user'));
    }

    public function forceLogin()
    {
        if (empty($this->CI->session->userdata('user'))) {
            redirect('admin/login');
        }
    }

    public function getUser()
    {
        $user = $this->CI->session->userdata('user');
        $user['level'] = 1;
        if(!empty($user['profile']['level'])){
            $user['level'] = $user['profile']['level'];
        }
        return $user;
    }


    public function page403()
    {
        echo $this->CI->load->view('errors/403');
        die;
    }

    public function page404()
    {
        echo $this->CI->load->view('errors/404');
        die;
    }

    public function validateDoc($doc)
    {
        $doc = str_replace(['/','-','.',' ',','],'',$doc);
        if(strlen($doc)>11){
            return $this->validateCnpj($doc);
        }else{
            return $this->validateCPF($doc);
        }
    }

    function validateCPF($cpf) {

		// Extrai somente os números
		$cpf = preg_replace( '/[^0-9]/is', '', $cpf );

		// Verifica se foi informado todos os digitos corretamente
		if (strlen($cpf) != 11) {
			return false;
		}

		// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
		if (preg_match('/(\d)\1{10}/', $cpf)) {
			return false;
		}

		// Faz o calculo para validar o CPF
		for ($t = 9; $t < 11; $t++) {
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf[$c] * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf[$c] != $d) {
				return false;
			}
		}
		return true;

	}

    public function validateCnpj($cnpj)
    {
        if (empty($cnpj)) {
            return false;
        }

        $cnpj = preg_replace("/[^0-9]/", "", $cnpj);
        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);

        if (strlen($cnpj) != 14) {
            return false;
        } else if (
            $cnpj == '00000000000000' ||
            $cnpj == '11111111111111' ||
            $cnpj == '22222222222222' ||
            $cnpj == '33333333333333' ||
            $cnpj == '44444444444444' ||
            $cnpj == '55555555555555' ||
            $cnpj == '66666666666666' ||
            $cnpj == '77777777777777' ||
            $cnpj == '88888888888888' ||
            $cnpj == '99999999999999'
        ) {
            return false;
        } else {

            $j = 5;
            $k = 6;
            $soma1 = "";
            $soma2 = "";

            for ($i = 0; $i < 13; $i++) {
                $j = $j == 1 ? 9 : $j;
                $k = $k == 1 ? 9 : $k;

                $soma2 += ($cnpj[$i] * $k);

                if ($i < 12) {
                    $soma1 += ($cnpj[$i]* $j);
                }

                $k--;
                $j--;
            }

            $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
            $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

            return (($cnpj[12] == $digito1) and ($cnpj[13] == $digito2));
        }
    }

    public function validateZipCode($doc)
    {
    }

    public function getZipCode($zipcode)
    {

        $zipcode = str_replace(['-', '.', ',', ' ', '_'], '', $zipcode);
        $url     = 'https://viacep.com.br/ws/' . $zipcode . '/json/';
        $ch     = curl_init($url);

        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8'
        ));

        $data = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($data, true);
        return $data;
    }

    public function verifyUserApvs($email,$password){
        $data = array(
            'loginUser'=>$email,
            'passUser'=>$password,
            'apiKey'=>"aa3a8b4174c615070459e22260f848df248b407e",
            'empLogin'=>"APVS",
        );

        $url = "https://api.apvs.org.br/v2/associadoi4pro/login/";

        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjMyNTAzNTkwMDAwLCJ1aWQiOiIyMDE5MTIxMjE4NTkwOSIsImVtYWlsIjoiZWR1YXJkb0B3aHlkaWdpdGFsLmNvbS5iciJ9.ylSdTxIFjepMBWvWZmzfjT9QoTJmWQtWi5Xxa/YnGsU=',
        ));
        $response = json_decode(curl_exec($ch), true);

        curl_close($ch);

        if(!empty($response)){
            if($response['statusText']=="error"){
                if(!empty($response['statusMensage'])){
                    // $this->CI->api->response(401, array('status' => false, 'message'=>$response['statusMensage']));
                }else{
                    // $this->CI->api->response(401, array('status' => false, 'message'=>"Dados Incorretos!"));
                }
            }else{
                $response['password'] = $password;
                return $response;
            }
        }else{
            // $this->CI->api->response(500, array('status' => false, 'message'=>"Erro! Dados incorretos!"));
        }
    }
}
