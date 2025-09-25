<?php
require_once __DIR__ . '/../model/GuideModel.php';

class GuideController {
    private $model;

    public function __construct() {
        $this->model = new GuideModel();
    }

    // load main view (list)
    public function listGuides() {
        $guides = $this->model->getAllGuides();
        include __DIR__ . '/../view/firstaid.php';
    }

    // show detail; if ajax=1 return fragment only
    public function showGuide($id, $ajax = 0) {
        $guide = $this->model->getGuideById($id);
        if ($ajax) {
            include __DIR__ . '/../view/guide_detail_fragment.php';
            return;
        }
        include __DIR__ . '/../view/guide_detail.php';
    }

    // search returns JSON
   public function searchGuides($query) {
    $guides = $this->model->searchGuides($query);
    header('Content-Type: application/json');
    echo json_encode($guides);
    exit; // important: stop further HTML output
}


    
}
?>
