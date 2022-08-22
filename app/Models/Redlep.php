<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Url;
use File;
use Response;
use Validator;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Validation;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;
use Input;

class Redlep extends Model
{
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
    public static function timeLeft($passTime){
        //echo $time;
        $time = time()-$passTime;
        $year = floor($time / (365*24*60*60));
        $month = floor($time / (30*24*60*60));
        $week = floor($time / (7*24*60*60));
        $day = floor($time /(24*60*60));
        $hour = floor($time /(60 * 60));
        $minute = floor(($time/60)%60);
        $seconds = $time%60;
        if($year != 0){
            return $year.' year ago';
        }
        elseif($month != 0){
            return $month.' month ago';
        }
        elseif($week != 0){
            return $week.' week ago';
        }
        elseif($day != 0){
            return $day.' day ago';
        }
        elseif($hour != 0){
            return $hour.' hour ago';
        }
        elseif($minute != 0){
            return $minute.' minutes ago';
        }
        else{
            return $seconds.' seconds ago';
        }
        //return $hour.' hour '.$minute.' minutes '.$seconds.' seconds ago';
    }
    public static function stringSubstr($string){
        if(!empty($string)){
            if(strlen($string)>41){
                $string=substr($string, 0, 41)."...";
                return $string;
            }
            else{
                return $string;
            }
        }
        else{
            return NULL;
        }
    }
    public static function stringSubstrLimit($string=NULL,$limit=NULL){
        if(!empty($string) && !empty($limit)){
            if(strlen($string)>$limit){
                $string=substr($string, 0, $limit)."...";
                return $string;
            }
            else{
                return $string;
            }
        }
        else{
            return NULL;
        }
    }
    public static function randomString($length = 50) {
        $str = "";
        $characters = array_merge(range('A','Z'),range('a','z'), range('0','10000'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
    public function secretString($length = 15){
        $str = "";
        $characters = array_merge(range('A','Z'),range('a','z'), range('0','1000'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
    public static function randomRemebberToken($length = 36) {
        $str = "";
        $characters = array_merge(range('A','Z'),range('a','z'), range('0','100000'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    public static function checkInToday($time){
        if(!$time) return false;
        $date = date('Y-m-d', $time);
        $now = date('Y-m-d');
        $tomorrow = date('Y-m-d', time() + strtotime('tomorrow'));
        $day_after_tomorrow = date('Y-m-d', time() + strtotime('tomorrow + 1 day'));
        if ($date == $now){
            return 1;
        }
        elseif($date == $tomorrow){
            return 2;
        }
        elseif($date == $day_after_tomorrow){
            return 3;
        }
        else{
            return 4;
        }
    }

    public function slug_create($value = NULL){
        if(empty($value)){
            return;
        }
        $str = strtolower(trim($value));
        $str1 = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str2 = preg_replace('/-+/', "-", $str1);
        return rtrim($str2, '-');
    }
    function get_extension($file) {
        $extension = end(explode(".", $file));
        return $extension ? $extension : false;
    }
    public function getDiscount($rate=NULL,$amount=NULL){
        $discount = 0;
        if(empty($amount)){
            return $discount;
        }
        $discount = ($rate * $amount)/100;
        return $discount;
    }
    //random image get
    public static function randomProfileImage(){
        $images = array(
            "public/front/img/people/1.png",
            "public/front/img/people/2.png",
            "public/front/img/people/3.png",
            "public/front/img/people/4.png",
            "public/front/img/people/5.png",
            "public/front/img/people/6.png",
            "public/front/img/people/7.png",
            "public/front/img/people/8.png",
            "public/front/img/people/9.png",
            "public/front/img/people/10.png",
            "public/front/img/people/11.png",
            "public/front/img/people/12.png",
            "public/front/img/people/13.png",
            "public/front/img/people/14.png",
            "public/front/img/people/15.png",
            "public/front/img/people/16.png",
            "public/front/img/people/17.png",
            "public/front/img/people/18.png",
            "public/front/img/people/19.png",
            "public/front/img/people/20.png"
        );
        $random = mt_rand(0, count($images) - 1);
        return $images[$random];
    }
    public static function getTags($str=NULL){
        if(empty($str)){
            return false;
        }
        $strArray = explode(",",$str);
        $count = count($strArray);
        if($count > 8){
            $random = array_random($strArray,7);
            return $random;
        }
        return $strArray;
    }
    //get tag for profile
    public static function getTagsProfile($str=NULL){
        if(empty($str)){
            return false;
        }
        $strArray = explode(",",$str);
        return $strArray;
    }
    public static function getTotalViews(){
        $getSiteData = Setting::find(1);
        $getSessionData = Session::get('main_page_id');
        if(empty($getSessionData)){
            $views = $getSiteData->views + 1;
            $updateViews = Setting::where('id',$getSiteData->id)->update(['views'=>$views]);
            Session::put('main_page_id',$getSiteData->id);
        }elseif(!empty($getSessionData) && $getSessionData != $getSiteData->id){
            $views = $getSiteData->views + 1;
            $updateViews = Setting::where('id',$getSiteData->id)->update(['views'=>$views]);
            Session::put('main_page_id',$getSiteData->id);
        }
        $againGetData = Setting::find(1);
        return $againGetData->views;
    }

    public static function getCountries(){
        $arr = array(
            'BD' => 'Bangladesh',
            'CN' => 'China',
            'EE' => 'Estonia',
            'FI' => 'Finland',
            'FR' => 'France',
            'DE' => 'Germany',
            'IN' => 'India',
            'IE' => 'Ireland',
            'JP' => 'Japan',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'MY' => 'Malaysia',
            'NL' => 'Netherlands',
            'NZ' => 'New Zealand',
            'NO' => 'Norway',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'QA' => 'Qatar',
            'SA' => 'Saudi Arabia',
            'RS' => 'Serbia',
            'SG' => 'Singapore',
            'ES' => 'Spain',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'TW' => 'Taiwan',
            'TH' => 'Thailand',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States'
        );
        return $arr;
    }
    public static function industryType(){
        $arr = array(
            'Basic' => 'Basic Industries',
            'Finance' => 'Finance',
            'Capital' => 'Capital Goods',
            'Healthcare' => 'Healthcare',
            'Consumer' => 'Consumer Durables',
            'Miscellaneous' => 'Miscellaneous',
            'Food' => 'Food',
            'Farm' => 'Farm',
            'Hotel' => 'Hotel',
            'Shop' => 'Shop',
            'IT' => 'IT',
            'Freelance' => 'Freelance'
        );
        return $arr;
    }
    public static function job_status(){
        $arr = array(
            'Full' => 'Full Time',
            'Part' => 'Part Time',
            'Contract' => 'Contract Job',
            'Freelance' => 'Freelance'
        );
        return $arr;
    }
    public static function getTotalApplicants($str=NULL){
        if(empty($str)){
            return 0;
        }
        $strArray = explode(",",$str);
        return count($strArray);
    }
    public static function is_job_apply($str=NULL,$user_id){
        if(empty($str) && empty($user_id)){
            return false;
        }
        $strArray = explode(",",$str);
        foreach($strArray as $row){
            if($user_id == $row){
                return true;
            }
        }
        return false;
    }
}
