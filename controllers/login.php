<?php

namespace controllers;

use lib\basecontroller;

class login extends BaseController {
    protected function index() {
        $this->titlePage = "Login";
        $this->alias = "";
        $this->controllerName = "login";
        $this->widget = 0;
        $viewModel = "";
        $this->RenderView($viewModel);
    }
}
