<?php
namespace App\Fa\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class FaException extends Exception
{
	public $msg = "";

	public $rc = "";

	public $disp_msg = "";

	public $data = "";

	public function __construct($msg, $rc = "9999", $disp_msg = "", $data = NULL){
        parent::__construct($msg);

        $this->msg = $msg;
        $this->rc = $rc;
        $this->disp_msg = $disp_msg;
        $this->data = $data;
	}

    public function __toString()
    {
        return "msg=" . $this->message . 
        	", rc=" . $this->rc . 
        	", disp_msg=" . $this->disp_msg . 
        	", data=" . ($this->data ? "T" : "F");
    }
}
