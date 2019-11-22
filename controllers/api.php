<?php

namespace controllers;

use lib\basecontroller;
use models\position;
use models\datamodel;

class api extends BaseController {
    public $key = 123456;
    
    public function getPositions() {
        if (isset($_POST['key'])){
            echo json_encode(array('statuscode'=>200, 'message'=>position::getPositions($this->id)));
        }else{
            http_response_code(403);
            echo json_encode(array('statuscode'=>403, 'message'=>'No authorization!'));
        }
    }
    
    public function ins() {
        if (isset($this->urlParams['id']) && isset($this->urlParams['latKal']) && isset($this->urlParams['lngKal']) && isset($this->urlParams['latRaw']) && isset($this->urlParams['lngRaw']) && isset($this->urlParams['tipe']) && isset($this->urlParams['imuRaw']) && isset($this->urlParams['imuKal'])){
            position::insertPosition($this->urlParams['id'], $this->urlParams['latKal'], $this->urlParams['lngKal'], $this->urlParams['latRaw'], $this->urlParams['lngRaw'], $this->urlParams['tipe'], $this->urlParams['imuRaw'], $this->urlParams['imuKal']);
            http_response_code(200);
            echo json_encode(array('statuscode'=>200, 'message'=>'Insert Position sukses!'));
        }else{
            http_response_code(422);
            echo json_encode(array('statuscode'=>422, 'message'=>'Data tidak lengkap!'));
        }
    }
    
    public function lastpos(){
        echo json_encode(position::getLastPosition(1));
    }
    
    public function cek() {
        if (isset($this->id)){
            echo $this->id;
        }
    }
    
}

?>