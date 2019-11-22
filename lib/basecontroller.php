<?php

namespace lib;

use models\coretanmodel;
use models\kreasimodel;
use models\bisnismodel;
use models\komentar;
use models\pengguna;
use models\information;

abstract class basecontroller {
    protected $urlParams;
    protected $action;
    protected $id;
    public $controllerName;
    public $functionName;
    public $baseUrl;
    public $titlePage;
    public $alias;
    public $metakey = "faiz,rahiemy,computer,science,game,development,mohammad,zakie";
    public $metadesc = "Coretan Faiz Rahiemy";

    public function __construct($baseUrl, $action, $urlParams, $id) {
        $this->baseUrl = $baseUrl;
        $this->action = $action;
        $this->urlParams = $urlParams;
        $this->id = $id;
        @ob_start();
        if(session_status()!=PHP_SESSION_ACTIVE) session_start();
        //DATE
        date_default_timezone_set("Asia/Jakarta");
    }

    public function ExecuteAction() {
        return $this->{$this->action}();
    }

    protected function RenderView($viewModel, $fullView = true) {
        $classData = explode("\\", get_class($this));
        $className = end($classData);
        
            $content = __DIR__ . "/../views/" . $className . "/" . $this->action . ".php";
            if ($fullView) {
                require __DIR__ . "/../views/layout/layout.php";
            } else {
                require $content;
            }
    }
} 