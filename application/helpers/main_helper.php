<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * GET ASSETS URL
 * @param: $exculdeSlash(boolean),  default: false
 * @return URL(string)
 * created by Mahesh on 15th june 2016
*/

function getDefaultPerPageRecords()
{
    return 10;
}
function getDefaultPerPageRecords_ops()
{
    return 300;
}

function assets_url($excludeSlash=false) {
	$assetsUrl = SITE_URL1.'application/assets';
	if(!$excludeSlash)
	$assetsUrl .= '/';
	return $assetsUrl;
}

function decimal_format($val,$decimal_count)
{
    return number_format($val,$decimal_count,'.','');
}
function price_format($val)
{
    return number_format($val,2,'.','');
}
function qty_format($val)
{
    return number_format($val,3,'.','');
}

function cmm_encode($id){
	$CI = & get_instance();
	//return $CI->encrypt->encode($id);
	return str_replace(array('/'), array('asdf99797'),$CI->encrypt->encode($id));
    }
function cmm_decode($id){
	$CI = & get_instance();
	$id=str_replace(array('asdf99797',' '), array('/','+'), $id);
     return $CI->encrypt->decode($id);
  }


function get_paginationConfig() {
	//config for bootstrap pagination class integration
		$config = array();
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
		$config['first_url'] = 0;

		return $config;
}


/**
 * Send email
 * 
 * 
 */
function send_email( $to,$subject = "---", $body,$cc=NULL,$from='noreply@sps.com',$from_name='Entransys SPS', $bcc=NULL, $replyto=NULL,  $attachments=[]) {
    $ci = & get_instance();
    $ci->load->helper('email');
    $ci->load->library('email');
    
    /*$config['protocol'] = 'smtp';
    $config['smtp_host'] = '192.168.173.27';
    $config['smtp_port'] = '25';
    $config['smtp_timeout'] = '7';*/
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_timeout'] = '7';
    $config['smtp_user'] = 'sps.entransys@gmail.com';
    $config['smtp_pass'] = 'Entransys@2016';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html'; // or html
    $config['validation'] = TRUE; // bool whether to validate email or not      

    $ci->email->initialize($config);
    $email_object = $ci->email;

    $email_object->from($from,$from_name);
    $email_object->to($to);
    $email_object->cc($cc);
    // $email_object->cc("rajender.jakka@gmail.com");
    $email_object->subject($subject);
    $email_object->message($body);
    $email_object->bcc($bcc);
    $email_object->reply_to($replyto);
    
    if(count($attachments)>0){
        foreach($attachments as $temp_name=>$path){
            $email_object->attach($path, 'attachment',$temp_name);
        }
    }
    $status = $email_object->send();
    
    return $status;

    //echo $ci->email->print_debugger();

   
    $email_object->clear(TRUE);
}

function date_difference ($date1timestamp, $date2timestamp) {
$all = round(($date1timestamp - $date2timestamp) / 60);
$d = floor ($all / 1440);
$h = floor (($all - $d * 1440) / 60);
$m = $all - ($d * 1440) - ($h * 60);
//Since you need just hours and mins
return array('hours'=>$h, 'mins'=>$m);
}

//mahesh 3rd august 2016 02:57 pm
// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//mahesh 3rd august 2016 2:59 pm
function getOS($user_agent) {

	$os_platform    =   "Unknown OS Platform";
	$os_array       =   array(
	                        '/windows nt 6.2/i'     =>  'Windows 8',
	                        '/windows nt 6.1/i'     =>  'Windows 7',
	                        '/windows nt 10.0/i'    =>  'Windows 10',
	                        '/windows nt 6.0/i'     =>  'Windows Vista',
	                        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
	                        '/windows nt 5.1/i'     =>  'Windows XP',
	                        '/windows xp/i'         =>  'Windows XP',
	                        '/windows nt 5.0/i'     =>  'Windows 2000',
	                        '/windows me/i'         =>  'Windows ME',
	                        '/win98/i'              =>  'Windows 98',
	                        '/win95/i'              =>  'Windows 95',
	                        '/win16/i'              =>  'Windows 3.11',
	                        '/macintosh|mac os x/i' =>  'Mac OS X',
	                        '/mac_powerpc/i'        =>  'Mac OS 9',
	                        '/linux/i'              =>  'Linux',
	                        '/ubuntu/i'             =>  'Ubuntu',
	                        '/iphone/i'             =>  'iPhone',
	                        '/ipod/i'               =>  'iPod',
	                        '/ipad/i'               =>  'iPad',
	                        '/android/i'            =>  'Android',
	                        '/blackberry/i'         =>  'BlackBerry',
	                        '/webos/i'              =>  'Mobile'
	                     );

	foreach ($os_array as $regex => $os_platform) {
		if (preg_match($regex, $user_agent)) {
		    return $os_platform;
		}
	}
}

//mahesh 3rd august 2016 03:03 pm
function getBrowser($user_agent) {

	$browser        =   "Unknown Browser";
	$browser_array  =   array(
	                         '/msie/i'       =>  'Internet Explorer',
	                         '/firefox/i'    =>  'Firefox',
	                         '/safari/i'     =>  'Safari',
	                         '/chrome/i'     =>  'Chrome',
	                         '/opera/i'      =>  'Opera',
	                         '/netscape/i'   =>  'Netscape',
	                         '/maxthon/i'    =>  'Maxthon',
	                         '/konqueror/i'  =>  'Konqueror',
	                         '/mobile/i'     =>  'Handheld Browser'
	                   );

	foreach ($browser_array as $regex => $browser) {
	  if (preg_match($regex, $user_agent)) {
	     return $browser;
	  }
	}
}/**
 * uploading DOcument
 * @$file_name = 'userfile',
 * @$new_name = will take by default random name, 
 * @$upload_path = 'uploads/', 
 * @$types = 'gif|jpg|png|jpeg|pdf|doc|doc', 
 * @$max_size = 2048
 * 
 * returns:file name
 */
function file_upload($file_name = 'userfile', $new_name = NULL, $upload_path = 'uploads/',$display_errors=TRUE, $types = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx', $max_size = 2048) {

    $ci = & get_instance();
    $ci->load->helper('string');
    $date = new DateTime();
    $time = $date->getTimestamp();
    $u = $time * random_string('numeric', 4);
    if ($new_name == NULL) {
        $new_name = get_unique_name();
    }
    //$config['file_name']=date('YmdHis').'_'.$u."-".random_string('numeric',4);
    $config['file_name'] = $new_name;
    $config['upload_path'] = './' . $upload_path;
    $config['allowed_types'] = $types;
    $config['max_size'] = $max_size;
    //$config['max_width'] = 1024;
    //$config['max_height'] = 768;
   
    $ci->load->library('upload', $config);

    if (!$ci->upload->do_upload($file_name)) {
       
        $error = array('error' => $ci->upload->display_errors()
                );
        //$ci->load->view('upload_form', $error); 
        if($display_errors){
             return $error;
        }
    } else {
       
        $data = array('upload_data' => $ci->upload->data());
        return $data['upload_data']['file_name'];
    }
}

function get_unique_name() {
    $ci = & get_instance();

    $ci->load->helper('string');
    $date = new DateTime();
    $time = $date->getTimestamp();
    $u = $time;
    return date('YmdHis') . '_' . random_string('alnum', 10);
    ;
}

function get_percentage($total,$per){
    return (($total*$per)/100);
}
function convert_number_to_words($number) {
//$number = 190908100.25;
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  return $result . "Rupees  " . $points . " ";
}

function getDefaultSelect2Limit()
{
	return 10;
}

/**
 * Formats the price to Indian thousand separator.
 *
 * @param price(int)
 * @return formatted_prcie(string)
 * Author: Mahesh created on: 15th july 2016 11:35 am, updated on:
 */
function indian_format_price($price) 
{
    $str=strrev($price);
    $len = strlen($str);
    if($len>3)
    {
        $str1 = substr($str,0,3);
        $str = preg_replace('/'.$str1.'/','',$str,1);
        $str1.=',';
        $str2 = '';
        while(strlen($str)>2)
        {
            $substr = substr($str,0,2);
            $str = preg_replace('/'.$substr.'/','',$str,1);
            $str2.=$substr.',';
        }
        $mainstr = $str1.$str2.$str;
        //echo $mainstr;
        $finalPrice = strrev($mainstr);
        
    }
    else
    {
        $finalPrice = $price;
         
    }
    return $finalPrice;
}

//mahesh 3rd august 2016 03:44 pm
function update_userLastActive(){
	$CI = & get_instance();
	//UPDATE USER LOG , mahesh 3rd august 2016 03:43 pm
	$log_qry = 'UPDATE user_log SET last_active = "'.date('Y-m-d H:i:s').'" WHERE user_id = '.$CI->session->userdata('employee_id').' ORDER BY user_log_id DESC LIMIT 1';
	$CI->db->query($log_qry);
}

// Priyanka 25th nov 2016 12:50
function generatePassword($password, $username)
{
    $password= substr($password, 0, 2);
    $name = substr($username, 0, 2);
    $pass = $password.$name;
    //echo $pass.'<br>';
    return $pass;
}

//mahesh 17th aug 2016, 06:08 pm
function getTimeDiffInSeconds($timestamp1,$timestamp2){
    //echo strtotime($timestamp2).'-'.strtotime($timestamp1).'<br>';
    $sec_diff = strtotime($timestamp2)-strtotime($timestamp1);
    //echo $ms_diff.'--<br>';
    return abs($sec_diff);
}

function DateFormatAM($timestamp)
{
    if($timestamp != '')
    {
        $time = strtotime($timestamp);
        return date('d M Y h:i A',$time);
    }
    else return '';
}

function DateFormat($timestamp)
{
    if($timestamp != '')
    {
        $time = strtotime($timestamp);
        return date('dMY',$time);
    }
    else return '';
}

include('mahesh_helper.php');
include('naveen_helper.php');
include('sahu_helper.php');
include('maruthi_helper.php');
include('koushik_helper.php');
include('prasad_helper.php');
include('srilekha_helper.php');
include('masthan_helper.php');
include('mounika_helper.php');
include('nagarjuna_helper.php');
include('priyanka_helper.php');



/* file end: ./application/helpers/main_helper.php */
