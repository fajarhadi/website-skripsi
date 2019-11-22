<?php

namespace controllers;

use lib\basecontroller;
use models\position;
use models\routemodel;
use models\datamodel;
use models\alertmodel;

class dashboard extends BaseController {
    protected function index() {
        $this->titlePage = "Dashboard";
        $this->alias = "dashboard";
        $this->controllerName = "dashboard";
        
        $viewModel = "";
        $this->RenderView($viewModel,'public');
    }
    
    protected function biker() {
        $this->titlePage = "Biker";
        $this->alias = "dashboard";
        $this->controllerName = "racer";
        
        $viewModel = "";
        $this->RenderView($viewModel,'public');
    }
    
    protected function route() {
        $this->titlePage = "Route";
        $this->alias = "dashboard";
        $this->controllerName = "route";
        
        $viewModel = "";
        $this->RenderView($viewModel,'public');
    }
    
    protected function alerts() {
        $this->titlePage = "Alert";
        $this->alias = "dashboard";
        $this->controllerName = "alert";
        
        $viewModel = "";
        $this->RenderView($viewModel,'public');
    }
    
    protected function alertdetail() {
        $this->titlePage = "Alert Detail";
        $this->alias = "dashboard";
        $this->controllerName = "alert";
        
        $viewModel = "";
        $this->RenderView($viewModel,'public');
    }
    
    protected function setting() {
        $this->titlePage = "Setting";
        $this->alias = "dashboard";
        $this->controllerName = "setting";
        
        $viewModel = "";
        $this->RenderView($viewModel,'public');
    }
    
    public function getPositions($bikeId){
        return position::getPositions($bikeId);
    }
    
    public function getLastPosition($bikeId){
        return position::getLastPosition($bikeId);
    }
    
    public function clearPosition(){
        return position::clearPosition();
    }
    
    public function getRoute(){
        return routemodel::getRoute();
    }
    
    public function updateRoute($order, $lat, $lng){
        return routemodel::updateRoute($order, $lat, $lng);
    }
    
    public function getNoiseRate(){
        return datamodel::getData('radius')->value;
    }
    
    public function setNoiseRate($value){
        return datamodel::setData('radius', $value);
    }
    
    public function getAlerts(){
        return alertmodel::getAlerts();
    }
    
    public function getAlert($bikeId){
        return alertmodel::getAlert($bikeId);
    }
    
    public function getLastAlert($bikeId){
        return alertmodel::getLastAlert($bikeId);
    }
    
    public function clearAlert(){
        return alertmodel::clearAlert();
    }
}
