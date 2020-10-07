<?php include_once "../includes/header.php"; ?>
<?php
$db = ConnecttoDB();
$images_url = "PitchSessionFiles/";
echo $AccountID = $_COOKIE["AccountID"];
?>
<style type="text/css">
 .account li {
    list-style: none;
    display: inline-block;
    padding: 0 60px;
    font-weight:bold;
    letter-spacing:2px;
}
.account {
  background: #E9ECEF;
  width: 100%;
  border-radius: .25rem;
  padding:5px;
}
.account span{
  display: block;
  font-weight:400;
  letter-spacing:0px;
}
.account {
    margin: 12px 0;
}
.account ul {
    margin-bottom: 3px;
}
</style>
<div style="display:;">
<audio controls>
        <source id="source" src="exampleDOTwav_WHAT-PHP-IS-LOOKING-FOR-TO-PLAY-DELETE_11-06-18htc.wav" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
</div>
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>
    <div class="container" id="target-options">
        <div class="row">
            <div class="col-sm-12">
              <div class="row">
              <div class="col-md-3 pitch_img">
              <img src='<?php echo $images_url; ?>Impact.jpg' />
              <img src='<?php echo $images_url; ?>front.png' />
              <img src='<?php echo $images_url; ?>side.png' />
    <img src='<?php echo $images_url; ?>top.png' />
              <img src='<?php echo $images_url; ?>Cam1CriticalFrame.jpg' />
              <img src='<?php echo $images_url; ?>Cam3CriticalFrame.jpg' />
              </div>
              <div class="col-md-9 pitch_data">
 
          <div class="col-sm-12 text-center">
            <?php
            $AccountID = $_COOKIE['AccountID'];
            $sql_c = "SELECT MachineID, SeqSessionNumber FROM sessions where AccountID='$AccountID' ORDER BY SeqSessionNumber DESC LIMIT 1";
            $sql_machine_id = "SELECT UnitSerialNumber FROM smconfig where id=1 LIMIT 1";
            $sqlQuery1 = $db->query($sql_c);
            $sqlQuery1_machine_id = $db->query($sql_machine_id);
            $result1 = $sqlQuery1->fetchAll();
      $result2 = $sqlQuery1_machine_id->fetchAll();
            $last_squ_id = $result1['0']['SeqSessionNumber'];
            $machine_id = $result2['0']['UnitSerialNumber'];
            ?>
            <div class="account">
            <ul>
              <li> Account ID <span><?php echo $_COOKIE['AccountID']; ?></span></li>
           <li> Student name <span> <?php echo $_COOKIE['StudentFirst'].' '.$_COOKIE['StudentLast']; ?></span></li>
           <li> Machine id <span> <?php echo $machine_id; ?></span></li>
           <li> Session Number<span> <?php echo $last_squ_id; ?></span></li>
            </ul>
            </div>
          </div>
              <button class="btn btn-danger float-right" id="stop_session" data-toggle="modal" data-target="#stopmodal"><i class="fa fa-stop-circle" aria-hidden="true"></i> Stop</button>
              <div class="row mbt-40">
                <div class="col-md-4">
                  <div class="card">
<style>
#target-options { max-width: 100%; }
.pitch_img img {
    height: 375px !important;
    margin: 0 0 25px 0;
    max-width: 100% !important;
    width: 100% !important;
}
/*div#target-options { max-width: 100%; }
table.table.table-striped.table-dark img {
    width: 90px;
}
table.table.table-striped.table-dark tr td, table.table.table-striped.table-dark tr th {
vertical-align:middle;
}*/
</style>
<?php
//$db = ConnecttoDB();
                    $acc_id = $_COOKIE["AccountID"];
                    $sql3 = "SELECT SeqSessionNumber FROM sessions where AccountID='$acc_id' ORDER BY SeqSessionNumber DESC LIMIT 1";
                    $sqlQuery = $db->query($sql3);
                    $result = $sqlQuery->fetchAll();
                    $last_squ_ID1 = $result['0']['SeqSessionNumber'];
                    
                    $sql4 = "SELECT * FROM LocalPitchTable where SessionNumber=$last_squ_ID1 and PitchCall='SUCCESS'";
                    $sqlQuery = $db->query($sql4);
                    $result = $sqlQuery->fetchAll();
    $success = count($result);
$sql5 = "SELECT * FROM LocalPitchTable where SessionNumber=$last_squ_ID1 and PitchCall='MISS'";
                    $sqlQuery = $db->query($sql5);
                    $result = $sqlQuery->fetchAll();
    $miss = count($result);
?>
                    <div class="card-body text-center bg-success">
                      <h3 class="card-title text-light">Successes</h3>
                      <p class="text-light count succ_count">0</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card">
                    <div class="card-body text-center bg-danger">
                      <h3 class="card-title text-light">Misses</h3>
                      <p class="text-light count miss_count">0</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card">
                    <div class="card-body text-center bg-primary">
                      <h3 class="card-title text-light">Pitch Count</h3>
                      <p class="text-light count pitch_count">0</p>
                    </div>
                  </div>
                </div>
              </div>
              <table class="table table-striped table-dark">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Hit Target</th>
                    <th scope="col">Speed</th>
                    <th scope="col">Column</th>
                    <th scope="col">Expected Pitch</th>
                    <th scope="col">Rows</th>
                    <th scope="col">Select Video</th>
                  </tr>
                </thead>
                <tbody id="table_data">
                  
                </tbody>
              </table>
              <button id="display-video">Display Video</button>
            </div>
            </div>
        </div>
        </div>
  </div>
<script>
$(document).ready(function() {
  $(document).on('click', "#table_data tr", function() {
    var row_id = $(this).attr('id');
    var audio_url = $(this).attr('data-audio');
    $('audio #source').attr('src', ''+audio_url+"?t=" + new Date().getTime());
    $('audio').get(0).load();
    $('audio').get(0).play();
    $.ajax({
         type: "GET",
         url: "get-pitch-image.php",
         data: "row_id="+row_id,
       }).done(function( data ) {
var realdata = jQuery.parseJSON(data);
$('.pitch_img').html("<img src='"+realdata.UserDisplayImage1FullLocalPath+"'?t=" + new Date().getTime()+"' /><img src='"+realdata.UserDisplayImage2FullLocalPath+"?t=" + new Date().getTime()+"' /><img src='"+realdata.UserDisplayImage3FullLocalPath+"?t=" + new Date().getTime()+"' /><img src='"+realdata.UserDisplayImage4FullLocalPath+"?t=" + new Date().getTime()+"' /><img src='"+realdata.UserDisplayImage5FullLocalPath+"?t=" + new Date().getTime()+"' /><img src='"+realdata.UserDisplayImage6FullLocalPath+"?t=" + new Date().getTime()+"' />");
});
  });
});
</script>
<script>
  $(document).ready(function(){
     var pitchNum = 0;
     var noPitchCount = '1';
     var ids_array = [];
     interval = setInterval(function(){
       console.log("Checking for pitch");
       $.ajax({
         type: "GET",
         url: "get-pitch.php",
       }).done(function( data ) {
var realdataMain = jQuery.parseJSON(data);
$.each( realdataMain , function( index, realdata ){
//console.log(ids_array);
  
if( realdata.id != null || realdata.id != undefined ) {
if($.inArray(realdata.id , ids_array) < 0){
//console.log(" In array check");
var audio_url = realdata.AudioFileToPlayOnceFullLocalPath;
console.log('play file - '+audio_url);
  $('audio #source').attr('src', ''+audio_url+"?t=" + new Date().getTime());
        $('audio').get(0).load();
        $('audio').get(0).play();
$('.pitch_img').html("<img src='"+realdata.UserDisplayImage1FullLocalPath+"'?t=" + new Date().getTime()+"' /><img src='"+realdata.UserDisplayImage2FullLocalPath+"?t=" + new Date().getTime()+"' /><img src='"+realdata.UserDisplayImage3FullLocalPath+"?t=" + new Date().getTime()+"' /><img src='"+realdata.UserDisplayImage4FullLocalPath+"?t=" + new Date().getTime()+"' /><img src='"+realdata.UserDisplayImage5FullLocalPath+"?t=" + new Date().getTime()+"' />");
            $("tbody").append("<tr id='"+realdata.id+"' data-audio='"+realdata.AudioFileToPlayOnceFullLocalPath+"'><td>" + realdata.PitchNumber + "</td><td>"+ realdata.PitchCall +"</td><td>"+realdata.PlateSpeedMph+ "</td><td>"+realdata.ImpactXstr+"</td><td>"+realdata.ExpectedPitch+"</td><td>"+realdata.ImpactYint+"</td><td><input class='row-check-action' type='checkbox' value="+realdata.id+"></td></tr>")
          //}
           pitchNum = data
           //noPitchCount = 0
            //location.reload();
if(realdata.PitchCall == 'MISS') {
var miss = $(".miss_count").text();
var miss_total = parseInt(miss)+parseInt(noPitchCount);
$(".miss_count").text(realdataMain.number_of_miss_rows);
}
if(realdata.PitchCall == 'SUCCESS') {
var suc = $(".succ_count").text();
var succ_total = parseInt(suc)+parseInt(noPitchCount);
$(".succ_count").text(realdataMain.number_of_success_rows);
}
$(".pitch_count").text(realdataMain.number_of_rows);
  ids_array.push(realdata.id);
  } // ends inArray checking
} // ends undefined or null check
<?php //unlink('example.wav')?>
});
       });
     }, 5000);
  });
  $(document).ready(function(){ 
    //var limit = 2;
          var limit = 2;
        $(document).on('change','.row-check-action', function(evt) {
           if($('.row-check-action:checked').length > limit) {
              alert("You can't select more than Two pitches." );
               this.checked = false;
           }
        });
        $(document).on('click','#display-video', function(evt) {
          var url ='/students/video.php?video=';
           if($('.row-check-action:checked').length > 0) {
           $('.row-check-action:checked').each(function(index, el) {
            url+=$(this).val()+'-';
            });
            window.location.href = url;
          }else{
            alert("Please select a pitch first")
          }
        });
  });
</script>
<?php //include_once $_SERVER['DOCUMENT_ROOT']."/includes/footer.php"; ?>
              
              
              
<!--Stop Modal-->
<div class="modal fade show" id="stopmodal" tabindex="-1" role="dialog" aria-labelledby="stopModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="stopModalLabel">Please choose below action.</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <select class="form-control" name="stop-option" id="stop-option-select">
                  <option value="SUSPENDED">Suspend for Later</option>
                  <option value="COMPLETED">Save and Upload Pitch Data</option>
                  <option value="CANCELLED">Cancel/Delete Data</option>
                </select>
<input type="hidden" value="<?php echo $_COOKIE["AccountID"]; ?>" id="account_id" />
              </div>
              <button type="submit" class="float-right" id="stop-action-submit">SUBMIT</submit>
          </div>
        </div>
      </div>
</div>
<?php include_once "../includes/footer.php"; ?>
<script>
$('#stop-action-submit').click(function(){
    var check = false;
    var select_val = $('#stop-option-select').val();
var account_id = $("#account_id").val();
    $('#stopmodal').modal('hide');
    if(select_val == 'CANCELLED'){
        var con = confirm('Are you sure again for cancel/delete.');
        if(con){
            check = true;
        }
    }else{
        check = true;
    }
    
    if(check){
    $.ajax({
      type: "POST",
      url: "write_log.php",
      data: { val : select_val, account_id:account_id },
       success: function(response) {
var response = $.trim(response);
console.log(response);               
           if(response == 'ok'){
              /*location.reload();*/
              window.location.href = '/students/students.php?logout=true';
           }else{
               alert('Some error occured please try again');
           }
           
       }              
      });
    }
    
});
</script>
