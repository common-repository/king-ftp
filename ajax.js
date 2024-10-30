function ajaxsend(parameter,showdiv){
//  jQuery.ajax({url: "<?php //echo plugins_url(); ?>/king_ftp/ftp.php?url=<?php //echo plugins_url(); ?>&"+"dir="+"<?php //echo jQuerytitle ; ?>&"+parameter, success: function(result){
//    jQuery("#"+showdiv).html(result);
//  }});   
  jQuery("#loading").css("display","unset");  
var data = {action: 'getaction',url:my_ajax_object.wpplugin_url,dir:"",parameter:parameter};
jQuery.post(my_ajax_object.ajax_url, data, function(response) {
   jQuery("#"+showdiv).html(response);
    jQuery("#loading").css("display","none");
});     
}
    

//jQuery(document).on('change', '#server', function(e) {
//    var servername= (this.options[e.target.selectedIndex].text);
//    ajaxsend('active=changeserver&servername='+servername,'main');
//});
function changeserver(elementselect){
    var servername = jQuery(elementselect).find(":selected").text();
     
    ajaxsend('active=changeserver&servername='+servername,'main'); 
}
    function show(divid) {
// Get the modal
jQuery("#filediv").html("");  
var modal = document.getElementById('myModal');
modal.style.display = "block";
var urlfile =jQuery("input#"+divid).val();
var size =jQuery("input#"+divid).attr("size");
    console.log(urlfile); 
var ext = urlfile.split('.').pop();
  
var typefile = ["png", "jpg", "gif", "html", "xml", "php", "css", "js", "exe", "json", "zip", "rar", "iso"];
var arraycontainsturtles = (typefile.indexOf(ext) > -1);
jQuery("#filediv").append(urlfile+"<br>");           
jQuery("#filediv").append(size+"<br>");  
if(arraycontainsturtles==true){
      
if(ext== "png" || ext== "jpg" || ext== "gif" ){
jQuery("#imgshow").attr("src",urlfile);
jQuery("#imgshow").attr("width"," 100%");
}else if(ext== "html" ||  ext== "xhtml"  || ext== "xml" || ext== "css" || ext== "js" || ext== "shtml" ){
    jQuery("#showcode").load(urlfile);
}else{

 jQuery("#imgshow").attr("src",my_ajax_object.wpplugin_url+"/king_ftp/png/"+ext+".png");
jQuery("#imgshow").attr("width"," 32px");
}
    }else{
jQuery("#imgshow").attr("src",my_ajax_object.wpplugin_url+"/king_ftp/png/file.png");
jQuery("#imgshow").attr("width"," 32px");
    }
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
}
    
    function closemodal(){
       var modal = document.getElementById('myModal');
  modal.style.display = "none";

    }


        
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
if(btn!=null){
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
}

function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

   //form Submit
      jQuery(document).on('click', '.uploadmulti', function (e) {

                      
        var file_data = jQuery('#files').prop('files')[0];

                        var form_data = new FormData();

var ins = document.getElementById('files').files.length;
for (var x = 0; x < ins; x++) {
form_data.append("file"+x, document.getElementById('files').files[x]);
}
         var directorycur=jQuery("#directorycur").val();
                        form_data.append('action', 'king_ftp_upload_save');
                   form_data.append('count', ins);
          form_data.append('directorycur', directorycur);

                        jQuery.ajax({
                            url: my_ajax_object.ajax_url,
                            type: 'post',
                            contentType: false,
                            enctype: 'multipart/form-data',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            xhr: function()
                                        {
                                          var xhr = new window.XMLHttpRequest();
                                          xhr.upload.addEventListener("progress",uploadProgressHandler,false);
                                          xhr.addEventListener("load", loadHandler, false);
                                          

                                          return xhr;
                                        },complete: function(){
                                            jQuery("#myProgress").css("display","none");
                                            jQuery("#loading").css("display","none");
                                        }

                        });
                    });

        
     
       function uploadProgressHandler(event)
  {
      jQuery("#myProgress").css("display","unset");
       jQuery("#loading").css("display","unset");
    jQuery("#loaded_n_total").html("Uploaded "+event.loaded+" bytes of "+event.total);
    var percent = (event.loaded / event.total) * 100;
    var progress = Math.round(percent);
    jQuery(".percent").html(progress + my_ajax_object.percentprogress);
    jQuery("#myBar").css("width", progress + "%");
      
    jQuery("#status").html(progress +my_ajax_object.uploadedpleasewait);
  }

  function loadHandler(event)
  {
    jQuery("#main").html(event.target.responseText);
    jQuery("#uploadProgressBar").css("width", "0%");
      jQuery("#status").html("");
  }

