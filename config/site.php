<?php
class Site{
    static public function get($data){
        global $DB;
        $setting = $DB->query_one('site',['domain'=>$_SERVER['SERVER_NAME'],'status'=>'ON']);
        if(isset($setting['domain'])):
           return $setting[$data];
        else:
           return null;
        endif;
    }
}