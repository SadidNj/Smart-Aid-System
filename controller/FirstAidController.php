<?php
require_once 'models/FirstAidModel.php';

class FirstAidController {
    public function index() {
        $model = new FirstAidModel();
        $guides = $model->getGuides();
        include 'views/firstaid.php';
    }
}
