<?php
/**
 * Created by PhpStorm.
 * User: sloan58
 * Date: 4/11/14
 * Time: 2:38 PM
 */

class WbgError {

    public $upi;
    public $device;
    public $cluster;
    public $pass_fail;
    public $mySql;
    public $process;

    public function __construct($upi,$device,$cluster,$pass_fail,$mySql,$process)
    {
        $this->upi = $upi;
        $this->device = $device;
        $this->cluster = $cluster;
        $this->pass_fail = $pass_fail;
        $this->mySql = $mySql;
        $this->process = $process;

    }

    /*
     * Used to log failures for adding Jabber or removing CIPC
     */
    public function logFail($message,$code)
    {
        $this->mySql->query("INSERT INTO " . $this->process . "_results (upi,device,cluster,code,message,status,last_updated) VALUES ('$this->upi','$this->device','$this->cluster','$code','$message','FAIL',NOW()) ON DUPLICATE KEY UPDATE device = '$this->device', cluster = '$this->cluster', code = '$code', message = '$message', status = 'FAIL', last_updated = NOW()");

        $this->pass_fail->logInfo("FAIL: UPI $this->upi - MESSAGE: $message - CODE: $code");

        echo json_encode(array('success' => FALSE,'message' => $message, 'code' => $code));
        exit;
    }

    /*
     * Used to log failures for device description updates
     * and device pool queries
     */
    public function logFailDesc($code)
    {
        $this->mySql->query("INSERT INTO " . $this->process . "_results (device,cluster,code,status,last_updated) VALUES ('$this->device','$this->cluster','$code','FAIL',NOW()) ON DUPLICATE KEY UPDATE device = '$this->device', cluster = '$this->cluster', code = '$code', status = 'FAIL', last_updated = NOW()");

        echo json_encode(array('success' => FALSE,'message' => 'FAILURE', 'code' => $code));
        exit;
    }
}