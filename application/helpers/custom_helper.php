<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* #********************************************#
  #                   codingmaker             #
  #*********************************************#
  #      Author:     codingmaker              #
  #      Email:      info@codingmaker.com     #
  #      Website:    http://codingmaker.com   #
  #                                             #
  #      Version:    1.0.0                      #
  #      Copyright:  (c) 2018 - codingmaker   #
  #                                             #
  #*********************************************# */

function package_info() {
    // Get a reference to the controller object
    $CI = get_instance();
    // Get user package id 
    $package_id = $CI->session->userdata('package_id');
    if (!empty($package_id)) {
        // Load globel model
        $CI->load->model('global_model', 'global_mdl');
        // Call a function of the model
        $package_info = $CI->global_mdl->get_package_info_by_package_id($package_id);
        return $package_info;
    }
}

function count_all_service_info() {
    // Get a reference to the controller object
    $CI = get_instance();
    // Get user package id 
    $user_id = $CI->session->userdata('user_id');
    if (!empty($user_id)) {
        // Load globel model
        $CI->load->model('global_model', 'global_mdl');
        // Call a function of the model
        $cdata = array();
        $cdata['total_listing'] = $CI->global_mdl->count_total_listing_by_user_id($user_id);
        $cdata['total_images'] = $CI->global_mdl->count_total_images_by_user_id($user_id);
        $cdata['total_videos'] = $CI->global_mdl->count_total_videos_by_user_id($user_id);
        $cdata['total_products'] = $CI->global_mdl->count_total_products_by_user_id($user_id);
        $cdata['total_services'] = $CI->global_mdl->count_total_services_by_user_id($user_id);
        $cdata['total_articles'] = $CI->global_mdl->count_total_articles_by_user_id($user_id);
        $cdata['total_keywords'] = $CI->global_mdl->count_total_keywords_by_user_id($user_id);
        $cdata['total_bookmarks'] = $CI->global_mdl->count_total_bookmarks_by_user_id($user_id);
        return $cdata;
    }
}

function cities_info() {
    // Get a reference to the controller object
    $CI = get_instance();
    // Load globel model
    $CI->load->model('global_model', 'global_mdl');
    // Call a function of the model
    $cities_info = $CI->global_mdl->get_all_cities();
    return $cities_info;
}

function categories_info() {
    // Get a reference to the controller object
    $CI = get_instance();
    // Load globel model
    $CI->load->model('global_model', 'global_mdl');
    // Call a function of the model
    $categories_info = $CI->global_mdl->get_all_categories();
    return $categories_info;
}

function settings_info() {
    // Get a reference to the controller object
    $CI = get_instance();
    // Load globel model
    $CI->load->model('global_model', 'global_mdl');
    // Call a function of the model
    $settings_info = $CI->global_mdl->get_settings_info();
    return $settings_info;
}

function GetDrivingDistance($lat1,$long1, $lat2,  $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&key=AIzaSyAG1VQn_Hq8DYrsP6nHO9qnxvdQDHMTjFc";
    //"https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=19.242356,73.13919899999999&destinations=19.2087175,72.9715119&key=AIzaSyAG1VQn_Hq8DYrsP6nHO9qnxvdQDHMTjFc";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    if($response_a['rows'][0]['elements'][0]['status']=="OK")
    {
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
         return $dist;
    }
   else
   {
       return "No distance calculate";
   }
}

function getLatLong($address){
    if(!empty($address)){
    //Formatted address
    $formattedAddr = str_replace(' ','+',$address);
    //Send request and receive json data by address
    $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=AIzaSyAG1VQn_Hq8DYrsP6nHO9qnxvdQDHMTjFc');
    $output = json_decode($geocodeFromAddr);
    //Get latitude and longitute from json data
    $data['latitude'] = $output->results[0]->geometry->location->lat;
    $data['longitude'] = $output->results[0]->geometry->location->lng;
    
    //Return latitude and longitude of the given address
    if(!empty($data)){
        return $data;
    }else{
        return false;
    }
    }else{
        return false;
    }
}// end fucntion


function data_crypt( $string, $action = 'e' ) { 
        
    $secret_key = 'TASKUS#$W@#23652_secret_key';
    $secret_iv = 'TASKUS#$W@#23652_secret_iv';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
   return $output;
}// end function data_crypt

function send_notification($token,$message,$title)
{
   $serverKey='AAAAZHB6oeY:APA91bHuDOmPbmSn9OBIE2EcRYnosDa3uozfdsAtwxr_q3eFBq8LAd0Z8k9DAPnAweFAa8axe50BvniARgkKBV3ygV6lfPimeYib4BsAFJ6znf8NKX2IuuHzHhVah0WqaDaql0OGkgLK';
   $url = "https://fcm.googleapis.com/fcm/send";
 
 
   $notification = array('title' =>$title , 'body' => $message, 'sound' => 'default', 'badge' => '1','click_action'=>'FCM_PLUGIN_ACTIVITY');
   $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
   $json = json_encode($arrayToSend);
   $headers = array();
   $headers[] = 'Content-Type: application/json';
   $headers[] = 'Authorization: key='. $serverKey;
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
   curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
   curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
   curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
   //Send the request
   $response = curl_exec($ch);

   //Close request
   if ($response === FALSE) {
      die('FCM Send Error: ' . curl_error($ch));
   }
   curl_close($ch);
   //return $response;
   return 1;
}// end function send_notification


//function admin_url() {
//    $ci = &get_instance();
//    $administrator_url = base_url('admin');
//    return $administrator_url;
//}
//
//function user_url() {
//    $ci = &get_instance();
//    $user_url = base_url();
//    return $user_url;
//}

