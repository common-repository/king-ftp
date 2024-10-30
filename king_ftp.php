<?php

/*
Plugin Name:king_ftp
Plugin URI: http://gm3.ir
Description:connect to ftp and get file  from file  manger
Author: saiid mohsen sadat rasoll
Version: 1.0
Author URI: http://kingblack.ir/
Text Domain: king_ftp
Domain Path: /lang/
*/
//Function Long  Name  : King View the file via FTP
//Function short  Name  : KVfFTP
if ( ! defined( 'ABSPATH' ) ) exit; 

function KVfFTP_textdomain() {
  load_plugin_textdomain( 'king_ftp', false, basename( dirname( __FILE__ ) ) . '/lang' ); 
}

add_action( 'init', 'KVfFTP_textdomain' );




add_action('admin_menu', 'KVfFTP_menu');
add_action( 'admin_init', 'KVfFTP_init' );


// menu s
function KVfFTP_init() {


if ( KVfFTP_sanitize ($_GET['page']) == 'king_ftp_option_menu' ) {
    

    

    
    
    wp_register_style('King_FTP-jquerysctipttop', plugins_url('/css/jquerysctipttop.css', __FILE__));
    wp_enqueue_style('King_FTP-jquerysctipttop');
    
    wp_register_style('King_FTP-style', plugins_url('/css/table.css',__FILE__));
    wp_enqueue_style('King_FTP-style');
    
 
    
}
add_action( 'wp_enqueue_scripts', 'my_enqueue' );
}



function KVfFTP_menu() {
	add_plugins_page(__( 'king ftp', 'king_ftp' ), __( 'king ftp  ', 'king_ftp' ), 'read', 'king_ftp_option_menu', 'KVfFTP_settings_page');

	
	add_action( 'admin_init', 'KVfFTP_setting' );
    
}



function KVfFTP_settings_page()
{
      
    ?>
   <script type="text/javascript">         

        


        jQuery(document).ready(function() {


            // Add row
            jQuery("#addrow").on("click", function() {
               var strcount= jQuery("#numserver").val();
                var count=parseInt(strcount);
                count=count +1;
                jQuery("#numserver").val(count);
jQuery("#tbodyserver").append('<tr id="example_'+count+'"><td id="example_'+count+'_0" class="edit string" contenteditable="true"></td><td id="example_'+count+'_1" class="edit string" contenteditable="true"></td><td id="example_'+count+'_2" class="edit string" contenteditable="true"></td><td id="example_'+count+'_3" class="edit string" contenteditable="true"></td> </tr>')
            });

            // Serialize
            jQuery("#submit").on("click", function() {
                var data = html2json('tbodyserver');
                
                objJsonStr = JSON.stringify(data);
                objJsonB64 = btoa(objJsonStr);
                jQuery("#KVfFTP_ftplist").val(objJsonB64);
                console.log(data);
            });
        });

       
       function html2json(tbid) {
 var rows = [];
            jQuery('#'+tbid+' tr').each(function(i, n){
                var row = jQuery(n);
                rows.push({
                    server: row.find('td:eq(0)').text(),
                    username:   row.find('td:eq(1)').text(),
                    password:    row.find('td:eq(2)').text(),
                    url:       row.find('td:eq(3)').text()
                });
            });
            return JSON.stringify(rows);

   //return json;
}
    </script>

	    <div class="wrap">
	    <h1>Theme Panel</h1>
            <p ><?php _e( "FTP data table" , 'king_ftp' ); ?></p>
    <a id="addrow"><?php _e( "Add Row", 'king_ftp' ); ?></a>
<!--    <a id="serialize"><?php //_e( "Serialize", 'king_ftp' ); ?></a>-->
    <table>
<thead><tr><th>server</th><th>username</th><th>password</th><th>url</th></tr></thead>
        
<tbody id="tbodyserver">
<?php
$decoded = base64_decode(esc_attr( get_option('KVfFTP_ftplist') ));
$decoded=stripslashes($decoded);
$decoded=rtrim($decoded,'"');
$decoded=ltrim($decoded,'"');
$ar = (array)json_decode($decoded, true);
    
$indexcoutn=0;
foreach ($ar as $value) {
//echo '['."'".($value['server'])."',"."'".($value['username'])."',"."'".($value['password'])."',"."'".($value['url'])."'".'],';
    
echo '<tr id="example_'.$indexcoutn.'">';  
echo '<td id="example_'.$indexcoutn.'_0" class="edit string" contenteditable="true">'.$value['server'].'</td>'; 
echo '<td id="example_'.$indexcoutn.'_0" class="edit string" contenteditable="true">'.$value['username'].'</td>'; 
echo '<td id="example_'.$indexcoutn.'_0" class="edit string" contenteditable="true">'.$value['password'].'</td>'; 
echo '<td id="example_'.$indexcoutn.'_0" class="edit string" contenteditable="true">'.$value['url'].'</td>'; 
echo '</tr>';
$indexcoutn=$indexcoutn+1;
}
    ?>

</tbody>
    </table>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("KVfFTP");
	            do_settings_sections("king_ftp_option_menu");      
	            submit_button(); 
	        ?>          
	    </form>
            
		</div>
	<?php
}


/******************************3*/

function KVfFTP_ftplist_call_back()
{
	?>
<input type="hidden" name="KVfFTP_ftplist" id="KVfFTP_ftplist"  value="<?php echo get_option('KVfFTP_ftplist'); ?>" />

    <?php
}

add_action("admin_init", "KVfFTP_display_option");
/****************************************4*/
function KVfFTP_numserver_call_back()
{
	?>
<input type="hidden" name="KVfFTP_numserver" id="KVfFTP_numserver" value="<?php echo get_option('KVfFTP_numserver'); ?>" />
    <?php
}



function KVfFTP_display_option()
{
	add_settings_section("KVfFTP", "All Settings", null, "king_ftp_option_menu");
	
	add_settings_field("KVfFTP_ftplist", "", "KVfFTP_ftplist_call_back", "king_ftp_option_menu", "KVfFTP");
    add_settings_field("KVfFTP_numserver", "", "KVfFTP_numserver_call_back", "king_ftp_option_menu", "KVfFTP");


    register_setting("KVfFTP", "KVfFTP_ftplist");
    register_setting("KVfFTP", "KVfFTP_numserver");
   

	add_settings_section("KVfFTP", "", null, "king_ftp_option_menu");
	
}

add_action("admin_init", "KVfFTP_display_option");

/************************************5*/



/************************************6*/
$KVfFTP_ftplist = get_option('KVfFTP_ftplist');
$KVfFTP_numserver = get_option('KVfFTP_numserver');



  wp_enqueue_script('jquery');


function KVfFTP_setting() {
	//register our settings
	register_setting( 'king_ftp-settings-group', 'KVfFTP_ftplist' );
    
    register_setting( 'king_ftp-settings-group', 'KVfFTP_server' );
    register_setting( 'king_ftp-settings-group', 'KVfFTP_user' );
    register_setting( 'king_ftp-settings-group', 'KVfFTP_pass' );
    register_setting( 'king_ftp-settings-group', 'KVfFTP_url' );
    
}



//menu e
//ajax upload s
add_action( 'wp_ajax_king_ftp_upload_save','KVfFTP_upload' );
  add_action( 'wp_ajax_nopriv_king_ftp_upload_save','KVfFTP_upload' );


function KVfFTP_upload(){
    
$typefile=array("PIF", "SCR", "SCF", "WS", "WSF", "VB", "VBS", "MSI" ,"CMD","BAT","COM","EXE","application/octet-stream");
 


$ftp_server =get_option('KVfFTP_server') ;
$ftp_username=get_option('KVfFTP_user');
$ftp_userpass=get_option('KVfFTP_pass');
$ftp_conn = ftp_connect($ftp_server) or die(KVfFTP_alert(__( "not connect", 'king_ftp' ),__( "Could not connect to $ftp_server", 'king_ftp' )));
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass)  or die(KVfFTP_alert(__( "Account", 'king_ftp' ),__( "Your profile is incorrect to connect to the $ftp_server server ", 'king_ftp' )));;
ftp_set_option($ftp_conn, FTP_USEPASVADDRESS, false); // set ftp option
ftp_pasv($ftp_conn, true);
      
 $logret="";         
    
if(isset($_FILES['file0'])){ 
$total =KVfFTP_sanitize ( $_REQUEST['count']);

 for( $i=0 ; $i < $total ; $i++ ) {
$fileName =  $_FILES['file'.$i]['name'];
$fileTypesource = $_FILES['file'.$i]['type'];
$filetype = wp_check_filetype($fileTypesource);
  

$destination_dir = $_SERVER;
$destination_file = KVfFTP_sanitize ($_REQUEST['directorycur'])."/" ;
$tmpFilePath = $_FILES['file'.$i]['tmp_name'];



if(in_array($fileTypesource, $typefile) ){
    $logret.= __( " This file $fileName is a dangerous file we can not upload.<br>", 'king_ftp' ); 
}else{
if (ftp_put($ftp_conn, $destination_file.sanitize_file_name($fileName), $_FILES['file'.$i]['tmp_name'], FTP_BINARY))
  {
   $logret.= __( "Successfully uploaded $fileName.<br>", 'king_ftp' );
  }
else
  {
  $logret.= __( "Error uploading $fileName.<br>", 'king_ftp' );
       $logret.=$error_message = $error_types[$_FILES['file']['error']];
     $logret.= $error_message;
  }
     
     
 }
    
}
}
 $directoreset=   KVfFTP_sanitize ($_REQUEST['directorycur']);
ftp_chdir($ftp_conn, ftp_pwd($ftp_conn)."/".$directoreset);   
  KVfFTP_rawlist($ftp_conn,$directoreset."/",plugins_url()); 
echo  $logret;
    die();
 }
//ajax upload e
//ajax s
add_action('wp_ajax_getaction', 'KVfFTP_answer');
add_action('wp_ajax_nopriv_getaction', 'KVfFTP_answer');

function KVfFTP_answer() {
$list= esc_attr( get_option('KVfFTP_ftplist') );
$parts = parse_url(KVfFTP_sanitize ($_REQUEST['parameter']));

parse_str($parts['path'], $query);



$ftp_server =get_option('KVfFTP_server') ;
$ftp_username=get_option('KVfFTP_user');
$ftp_userpass=get_option('KVfFTP_pass');

    if(KVfFTP_sanitize ($query['active'])=="changeserver"){
        
$servername=KVfFTP_sanitize ($query['servername']);
$allserver=esc_attr( get_option('KVfFTP_ftplist') );

$decoded = base64_decode($list);
$decoded=stripslashes($decoded);
$decoded=rtrim($decoded,'"');
$decoded=ltrim($decoded,'"');
$ar = (array)json_decode($decoded, true);
foreach ($ar as $value) {

    
if($servername==$value['server']){

$ftp_server = $value['server'];
$ftp_username=$value['username'];
$ftp_userpass=$value['password'];
$ftp_url=$value['url'];

update_option('KVfFTP_server', $ftp_server);
update_option('KVfFTP_user', $ftp_username);
update_option('KVfFTP_pass', $ftp_userpass);
update_option('KVfFTP_url', $ftp_url);

$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
ftp_set_option($ftp_conn, FTP_USEPASVADDRESS, false); // set ftp option
ftp_pasv($ftp_conn, true);
echo KVfFTP_rawlist($ftp_conn,".",plugins_url());
}
    
}
}
    
if($ftp_server==null){
  $allserver=esc_attr( get_option('KVfFTP_ftplist') );

if($allserver== ""){
  echo '<section id="warning">
    
    <section class="warningContent">
      <span>!</span>
      <h5 class="wHeading">'.__( "KING_ftp problem!", 'king_ftp' ).'</h5>
      <p>'.__("you are not set data <strong>in option</strong>! <b>please</b> update data  and try", 'king_ftp' ).' </p>
    </section>
  </section>';
}else{
$decoded = base64_decode($list);
$decoded=stripslashes($decoded);
$decoded=rtrim($decoded,'"');
$decoded=ltrim($decoded,'"');
$ar = (array)json_decode($decoded, true);
 //print_r($ar) ;  
$ftp_server =$ar[0]['server'];
$ftp_username=$ar[0]['username'];
$ftp_userpass=$ar[0]['password'];
    error_reporting(0);
$ftp_conn = ftp_connect($ftp_server) or die(KVfFTP_alert(__( "not connect", 'king_ftp' ),__( "Could not connect to $ftp_server", 'king_ftp' )));
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
ftp_set_option($ftp_conn, FTP_USEPASVADDRESS, false); // set ftp option
ftp_pasv($ftp_conn, true); 
}
}else{
error_reporting(0);
$ftp_conn = ftp_connect($ftp_server) or die(KVfFTP_alert(__( "not connect", 'king_ftp' ),__( "Could not connect to $ftp_server", 'king_ftp' )));
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass)  or die(KVfFTP_alert(__( "Account", 'king_ftp' ),__( "Your profile is incorrect to connect to the $ftp_server  server ", 'king_ftp' )));;
ftp_set_option($ftp_conn, FTP_USEPASVADDRESS, false); // set ftp option
ftp_pasv($ftp_conn, true);
}
    


    
    
 if(KVfFTP_sanitize ($query['active'])=="chnagedirectory"){
    echo ftp_pwd($ftp_conn)."/".KVfFTP_sanitize ($query['directory'])."<br>";
    ftp_chdir($ftp_conn, ftp_pwd($ftp_conn)."/".KVfFTP_sanitize ($query['directory']));
    echo KVfFTP_rawlist($ftp_conn,".",plugins_url());
}
    //delete file
    if(KVfFTP_sanitize ($query['active'])=="deletefile"){
    $filep=KVfFTP_sanitize ($query['file']);
    $directory=KVfFTP_sanitize ($query['directory']);
    echo ftp_pwd($ftp_conn)."/".KVfFTP_sanitize ($query['directory'])."<br>";
  if (ftp_delete($ftp_conn, $directory.$filep))
  {
   ftp_chdir($ftp_conn, ftp_pwd($ftp_conn)."/".$directory);
    echo KVfFTP_rawlist($ftp_conn,".",plugins_url());
  }
else
  {
  echo "Could not delete $file";
  }
   
}
    


    wp_die(); // All ajax handlers die when finished
}

    wp_enqueue_script( 'ajax-script', plugins_url('/ajax.js', __FILE__), array('jquery') );

    wp_localize_script( 'ajax-script', 'my_ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ,'wpplugin_url' => plugins_url() ,'uploadedpleasewait' =>__( "% uploaded... please wait", 'king_ftp' ) ,'percentprogress' => __( " percent na ang progress", 'king_ftp' ) ) );
//ajax e
//tab s
add_filter('media_upload_tabs', 'KVfFTP_tab');
function KVfFTP_tab($tabs) {
    $tabs['KVfFTP_showtabs'] = __( "king ftp", 'king_ftp' );
    return $tabs;
}



// call the new tab with wp_iframe
add_action('media_upload_KVfFTP_showtabs', 'KVfFTP_style');
function KVfFTP_style() {

    
    wp_register_style('King_FTP-font-awesome', plugins_url("css/font-awesome.min.css",__FILE__));
    wp_enqueue_style('King_FTP-font-awesome');
    
    wp_register_style('King_FTP-style-css', plugins_url("/style.css",__FILE__));
    wp_enqueue_style('King_FTP-style-css');
    


wp_iframe( 'KVfFTP_showtabs' );
    
    
}






function KVfFTP_showtabs() {
    wp_enqueue_script('jquery');
    echo media_upload_header();

//function boot_session() {
//  session_start();
//}
//add_action('wp_loaded','boot_session');

    ?>

<?php 

$list= esc_attr( get_option('KVfFTP_ftplist') );
?>


<!DOCTYPE html>
<html>
<head>


</head>
<body>
<div id="loading" class="loading" style="display:none">
		<div class="loading-dot"></div>
		<div class="loading-dot"></div>
		<div class="loading-dot"></div>
    <div class="loading-dot"></div>
</div>
<?php if($list!=""){ ?>
<select id="server"  onchange="changeserver(this)">
<option value="">...</option>
<?php 
$decoded = base64_decode($list);
$decoded=stripslashes($decoded);
$decoded=rtrim($decoded,'"');
$decoded=ltrim($decoded,'"');
$ar = (array)json_decode($decoded, true);
foreach ($ar as $value) {

echo '<option value="'.$value['server'].'">'.$value['server'].'</option>';
}
    ?>
</select>
    <?php }?>
<?php 
  //KVfFTP_showlist($ftp_conn);  
?>
    <?php
define( 'plugins_url', plugins_url() );
define( 'wpaddress', $title );


?>
<div id="main">
<?php 
    if($ftp_server==null){}else{
    KVfFTP_rawlist($ftp_conn,".",plugins_url()); 
    }
    ?> 
</div>

<?php if($list!=""){ ?>

    <form action="javascript:;" enctype="multipart/form-data">
  <table>
    <tr>
      <td colspan="2"><?php __( "Files Upload", 'king_ftp' ); ?></td>
    </tr>
    <tr>
      <th><?php __( "Select File", 'king_ftp' ); ?> </th>
      <td><input class="custom-file-input" id="files" name="files[]" type="file" multiple></td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="button" class="uploadmulti" name="uploadform" value="<?php _e( "Upload", 'king_ftp' ); ?>"/> 
      </td>
    </tr>
  </table>
</form>


<div id="myProgress" class="progress" style="display:none;">
  <div id="myBar" class="bar"><div class="percent">0%</div ></div>
</div>
    
<div id="status"></div>
    <!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onclick="closemodal()">&times;</span>
    <div class="tab">
  <button class="tablinks" onclick="openCity(event, 'show')" id="defaultOpen"><?php _e( "show", 'king_ftp' ); ?></button>
  <button class="tablinks" onclick="openCity(event, 'file')"><?php  _e( "File details", 'king_ftp' ); ?></button>
<!--  <button class="tablinks" onclick="openCity(event, 'editor')"><?php //_e( "The editor", 'king_ftp' ); ?></button>-->
</div>

<div id="show" class="tabcontent">
  <h3><?php _e( "show", 'king_ftp' ); ?></h3>
  <p id="showdiv">
    <img id="imgshow" src="">
      <div id="showcode"></div>
    </p>
</div>

<div id="file" class="tabcontent">
  <h3><?php  _e( "File details", 'king_ftp' ); ?> </h3>
  <p id="filediv">
    
    </p> 
</div>

<div id="editor" class="tabcontent">
  <h3><?php _e( "The editor", 'king_ftp' ); ?></h3>
  <p id="eidtordiv">Tokyo is the capital of Japan.</p>
</div>
  </div>

</div>
      <?php }?>

    

    
    
    <div id="log"></div>
</body>
</html>

<?php 
    
}
//tab e



function KVfFTP_showlist($ftp_conn){
    $filelist = ftp_rawlist($ftp_conn, "/");
    $filelist =array_filter($filelist);
      for ($i = 0; $i <= count($filelist); $i++) {
          if(empty($filelist[$i])){}else{
          $filelist[$i]=ltrim($filelist[$i]," ");
          $filelist[$i]=rtrim($filelist[$i]," ");
      $currenvar=explode(" ",$filelist[$i]);
          echo '<img class="folder" src="f.png" > ';
            for ($x = 0; $x <= count($currenvar)-1; $x++) {
                if(empty($currenvar[$x])){}else{
                    
             echo $currenvar[$x]."*";
                }
            }
          echo"<br>";
      }
      }
}


function KVfFTP_rawlist($ftp_conn,$address,$plugins_url) {
   $ftp_server=get_option('KVfFTP_server');
    //echo $ftp_conn."::::".$address;
  $ftp_rawlist = ftp_rawlist($ftp_conn, $address);
  foreach ($ftp_rawlist as $v) {
    $info = array();
    $vinfo = preg_split("/[\s]+/", $v, 9);
    if ($vinfo[0] !== "total") {
      $info['chmod'] = $vinfo[0];
      $info['num'] = $vinfo[1];
      $info['owner'] = $vinfo[2];
      $info['group'] = $vinfo[3];
      $info['size'] = $vinfo[4];
      $info['month'] = $vinfo[5];
      $info['day'] = $vinfo[6];
      $info['time'] = $vinfo[7];
      $info['name'] = $vinfo[8];
      $rawlist[$info['name']] = $info;
    }
  }
  $dir = array();
  $file = array();
  foreach ($rawlist as $k => $v) {
    if ($v['chmod']{0} == "d") {
      $dir[$k] = $v;
    } elseif ($v['chmod']{0} == "-") {
      $file[$k] = $v;
    }
  }
    $vurrentdirextor=ftp_pwd($ftp_conn);
    $variable = substr($vurrentdirextor, 0, strripos($vurrentdirextor, "/"));
      echo '<a onclick="ajaxsend(\'active=chnagedirectory&directory='.$variable.'\',\'main\')"><img class="folder" src="'.$plugins_url.'/king_ftp/png/back.png" ></a>'  . "<br>";
    echo '<input id="directorycur" type="hidden" value="'.$vurrentdirextor.'">';
  foreach ($dir as $dirname => $dirinfo) {
     /* echo  ''.'<a onclick="ajaxsend(\'active=chnagedirectory&directory='.ftp_pwd($ftp_conn)."/".$dirname.'\',\'main\')"> <img class="folder" src="png/f.png" > '.$dirname.' </a>' . $dirinfo['chmod'] . " | " . $dirinfo['owner'] . " | " . $dirinfo['group'] . " | " . $dirinfo['month'] . " " . $dirinfo['day'] . " " . $dirinfo['time'] . "<br>";
      */
            echo '<div class="row">
    <div class="cell -file">
      <img class="folder" src="'.$plugins_url.'/king_ftp/png/f.png" >
      <div class="inner">
         <a  class="filename">'.$dirname.'</a>
         <small class="details">
<span class="detail -filesize"><i class="fa fa-hashtag" aria-hidden="true"></i> '.$dirinfo['chmod'].'</span>
<span class="detail -filesize"><i class="fa fa-user" aria-hidden="true"></i> '.$dirinfo['owner'].'</span>
<span class="detail -filesize"><i class="fa fa-object-group" aria-hidden="true"></i> '.$dirinfo['group'].'</span>
<span class="detail -filesize"><i class="fa fa-clock-o" aria-hidden="true"></i> '.$dirinfo['month'].'</span>
<span class="detail -filesize"><i class="fa fa-clock-o" aria-hidden="true"></i> '.$dirinfo['day'].'</span>
<span class="detail -updated"><i class="fa fa-clock-o" aria-hidden="true"></i>'.$dirinfo['time'].'</span>
         </small>
      </div>
   </div>
 
   
   <button class="cell -action -share" onclick="ajaxsend(\'active=chnagedirectory&directory='.ftp_pwd($ftp_conn)."/".$dirname.'\',\'main\')">
      <i class="fa fa-share-square-o" aria-hidden="true"></i>
      <span class="label">goto</span>
   </button>
   
 
   
</div>
   ';
  }
  foreach ($file as $filename => $fileinfo) {
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      if($ext==""){$ext="file";}
      /*echo '<a onclick=""><img class="folder" src="png/'.$ext.'.png" > '."<p class=\"namefile\">$filename</p>" .'</a>'. $fileinfo['chmod'] . " | " . $fileinfo['owner'] . " | " . $fileinfo['group'] . " | " . $fileinfo['size'] . " Byte | " . $fileinfo['month'] . " " . $fileinfo['day'] . " " . $fileinfo['time'] . "<br>";*/
      $urlfile= plugin_dir_path(__FILE__) .'/png/'.$ext.'.png';
      //echo $urlfile;
      if(!file_exists($urlfile)){
         $ext="file" ;
          
      }
      $bodytag = str_replace("public_html", "", ftp_pwd($ftp_conn));
      $bodytag = str_replace("//", "", $bodytag);
      if(strcmp($bodytag,"/")==0){
         $vla=""; 
          $bodytag="";
      }else{
          $vla="/";
      }
      
      echo '<div class="row">
    <div class="cell -file">
      <img class="folder" src="'.$plugins_url.'/king_ftp/png/'.$ext.'.png" >
      <div class="inner">
         <a  class="filename">'.$filename.'</a>
         <small class="details">
<span class="detail -filesize"><i class="fa fa-hashtag" aria-hidden="true"></i> '.$fileinfo['chmod'].'</span>
<span class="detail -filesize"><i class="	fa fa-user" aria-hidden="true"></i> '.$fileinfo['owner'].'</span>
<span class="detail -filesize"><i class="fa fa-object-group" aria-hidden="true"></i> '.$fileinfo['group'].'</span>
<span class="detail -filesize"><i class="fa fa-hdd-o" aria-hidden="true"></i> '.$fileinfo['size'].'</span>
<span class="detail -filesize"><i class="fa fa-clock-o" aria-hidden="true"></i> '.$fileinfo['month'].'</span>
<span class="detail -filesize"><i class="fa fa-clock-o" aria-hidden="true"></i> '.$fileinfo['day'].'</span>
<span class="detail -updated"><i class="fa fa-clock-o" aria-hidden="true"></i>'.$fileinfo['time'].'</span>
         </small>
      </div>
   </div>
      <button class="cell -action -download" onclick="window.open(\'http://'.$ftp_server."".$bodytag."/".$filename.'\', \'_blank\');">
      <i class="fa fa-download" aria-hidden="true"></i>
      <span class="label">Download</span>
   </button>
   


   <button id="myBtn" class="cell -action -more" onclick="show(\''.str_replace(".","ggggg",$filename).'\')">
   <input id="'.str_replace(".","ggggg",$filename).'" type="hidden" value="http://'.$ftp_server.$vla.$bodytag."/".$filename.'"  size="'.$fileinfo['size'].'" chmod="'.$fileinfo['chmod'].'" group="'.$fileinfo['group'].'" month="'.$fileinfo['month'].'"  >
      <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
      <span class="label">'.__( "show", 'king_ftp' ).'</span>
   </button>
   
   <button class="cell -action -more" onclick="ajaxsend(\'active=deletefile&directory='.ftp_pwd($ftp_conn)."/"."&file=".$filename.'\',\'main\')">
      <i class="fa fa-trash" aria-hidden="true"></i>
      <span class="label">delete</span>
   </button>
   
</div>
   ';
  }
}

function KVfFTP_sanitize ($sring){
    
$valuere=htmlspecialchars($sring);
$valuere=strip_tags($sring);
     return strip_tags($valuere);
}
function KVfFTP_alert($title,$discription){
    return '<section id="warning">
    
    <section class="warningContent">
      <span>!</span>
      <h5 class="wHeading">'.$title.'</h5>
      <p>'.$discription.' </p>
    </section>
  </section>';  
}




?>
