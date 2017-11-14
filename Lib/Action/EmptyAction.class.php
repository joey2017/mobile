<?php
class EmptyAction extends Action 
{
    public function _empty($var){
       $this->display('empty:error');
    }
   
}