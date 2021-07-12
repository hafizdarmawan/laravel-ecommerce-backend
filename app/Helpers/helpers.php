<?php 

if(!function_exists('moneyFormat')){
   /**
    * Helper uang
    *@param mixed str
    *@returnVoid
    */
    function moneyFormat($str){
       return 'Rp.'.number_format($str,'0','','.');
    }
}

if(!function_exists('dateID')){
   /**
    *Date ID
    *@Param mixed $Tanggal 
    *@return void
    */
    function dateID($tanggal){
       $value  = Carbon\Carbon::parse($tanggal);
       $parse  = $value->local('id');
       return $parse->translatedFormat('l, d F Y');
    }
}