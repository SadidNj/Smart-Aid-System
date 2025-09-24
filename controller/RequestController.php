<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/helpers.php';
require_once dirname(__DIR__) . '/model/RequestModel.php';

class RequestController {
    public function handle(): array {
        ensure_csrf();
        if(!isset($_SESSION['my_req_ids'])) $_SESSION['my_req_ids']=[];

        $m = new RequestModel();

        if($_SERVER['REQUEST_METHOD']==='POST'){
            if(!csrf_valid($_POST['csrf']??'')){
                flash('error','Invalid request.');
                header('Location: request.php'); exit;
            }
            $type = trim((string)($_POST['type']??''));
            $name = trim((string)($_POST['name']??''));
            $bg   = trim((string)($_POST['blood_group']??''));
            $details = trim((string)($_POST['details']??''));

            $errors = [];
            if(!in_array($type, ['blood','organ'], true)) $errors[]='Type is required.';
            if($name==='') $errors[]='Name is required.';
            if($type==='blood' && $bg!=='' && !in_array($bg, ['A+','A-','B+','B-','O+','O-','AB+','AB-'], true)){
                $errors[]='Invalid blood group.';
            }
            if($details==='') $errors[]='Details are required.';

            if($errors){
                flash('error', implode(' ', $errors));
                $_SESSION['old']=['type'=>$type,'name'=>$name,'blood_group'=>$bg??'','details'=>$details];
                header('Location: request.php'); exit;
            }

            if($m->insert($type,$name,$bg?:null,$details)) flash('success','Request posted successfully!');
            else flash('error','Error saving your request.');
            header('Location: request.php'); exit;
        }

        $my = $m->my($_SESSION['my_req_ids']);
        $others = $m->others($_SESSION['my_req_ids']);
        $old = $_SESSION['old'] ?? ['type'=>'','name'=>'','blood_group'=>'','details'=>'']; unset($_SESSION['old']);
        return compact('my','others','old');
    }
}
