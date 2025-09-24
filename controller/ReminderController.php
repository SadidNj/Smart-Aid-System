<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config/helpers.php';
require_once dirname(__DIR__) . '/model/ReminderModel.php';

class ReminderController {
    public function handle(): array {
        ensure_csrf();
        $m = new ReminderModel();
        $success=''; $error='';

        if(isset($_POST['delete_all'])){
            if($m->deleteAll()) $success="All reminders deleted!";
            else $error="Failed to delete reminders.";
        } elseif($_SERVER['REQUEST_METHOD']==='POST'){
            $medicine = trim($_POST['medicine']??'');
            $time = trim($_POST['time']??'');
            $notes = trim($_POST['notes']??'');
            if($medicine && $time){
                if($m->insert($medicine,$time,$notes)) $success="Reminder set successfully!";
                else $error="Failed to set reminder.";
            } else {
                $error="Please fill all required fields.";
            }
        }

        $reminders = $m->all();
        return compact('success','error','reminders');
    }
}
