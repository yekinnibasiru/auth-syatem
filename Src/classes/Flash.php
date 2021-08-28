<?php 

defined('BASEPATH') OR exit("No direct script access allowed");
class Flash {

    public $messages=array();

    /**
     * @return Void
     */

    public function __construct(){
        $this->Init();
    }

    /**
     * @param String $key
     * @param String $message
     * @return Void 
     */

    public function setFlash($key,$message){
        if(!array_key_exists($key,$_SESSION['flashbuck'])){
            $_SESSION['flashbuck'][$key]=array();
        }
        $_SESSION['flashbuck'][$key][]=$message;
    }
    
    /**
     * @param String $type
     * @return Array
     */
    public function getFlash($type){
        $retval=array();
        foreach($_SESSION['flashbuck'] as $key => $messages){
            if($key == $type){
                $retval=$messages;
            }
        }
        return $retval;
    }

    /**
     * @param String $type
     * @return Array
     */
    public function getLocal($type){
        $retval=array();
        foreach($this->messages as $key => $messages){
            if($key == $type){
                $retval=$messages;
            }
        }
        return $retval;
    }

    /**
     * @return Void
     */

    private function Init(){
        if(array_key_exists('flashbuck',$_SESSION) && !empty($_SESSION['flashbuck'])){
            $this->messages=$_SESSION['flashbuck'];
            $this->initFlash();
        }
        else{
            $this->initFlash();
        }
    }

    /**
     * @return Void
     */

    private function initFlash(){
        $_SESSION['flashbuck']=array();
    }

}



?>