<?php
require_once("./connect.php");
?>
<?php


if($_POST['submit']!='')

{

	if($_POST['username']=='')

	{

		$error .= "Username is required!.<br/>";

	}

	if($_POST['password']=='')

	{

		$error .= "Password is required!.<br/>";

	}

	if($_POST['password2']=='')

	{

		$error .= "Password is required!.<br/>";

	}	

	if($_POST['email']=='')

	{

		$error .= "Email is required!.<br/>";

	}	

	if($_POST['firstname']=='')

	{

		$error .= "firstname is required!.<br/>";

	}

	if($_POST['lastname']=='')

	{

		$error .= "lastname is required!.<br/>";

	}	

	if($_POST['birthdate']=='')

	{

		//$error .= "birthdate is required!.<br/>";

	}	

	if($_POST['gender']=='')

	{

		//$error .= "gender is required!.<br/>";

	}		

	

if(countfield("username",$_POST['username'])!=0)

{

	$error .= "Username is already exist try another!.<br/>";

}

if($_POST['refer']!=''){
if(countfield("username",$_POST['refer'])==0)

{

	$error .= "Referral username is not existing please enter valid one!.<br/>";

}
}

  if(empty($_POST['g-recaptcha-response'])){
     $error[] = "Please confirm you are not robot.";
  }


if(countfield("email",$_POST['email'])!=0)

{

	$error .= "Email is already exist try another!.<br/>";

}
if($_POST['password']!=$_POST['password2'])

{

  $error .= "Password do not match.<br/>";

}


if($error=='')

{
	unset($_POST['submit']);
	unset($_POST['password2']);
	unset($_POST['termscondition']);
	unset($_POST['g-recaptcha-response']);
	mysql_query_cheat("INSERT INTO tbl_accounts SET ".setinsert($_POST));


  $row = getuser($_POST['username'],$_POST['password']);
    foreach($row as $key=>$val){
      $_SESSION[$key] = $val;
    }
    $_SESSION['loggedin'] = $_POST['username'];
	
	?>
	<script>
		window.location = 'index.php?page=singin&success=1';
	</script>
	<?php
	exit();
	
}




}

?>



<?php
$field[] = array("type"=>"text","value"=>"username");

$field[] = array("type"=>"password","value"=>"password");

$field[] = array("type"=>"password","value"=>"password2","label"=>"Re-enter Password");

$field[] = array("type"=>"email","value"=>"email");

$field[] = array("type"=>"text","value"=>"firstname"); 

$field[] = array("type"=>"text","value"=>"lastname");

//$field[] = array("type"=>"date","value"=>"birthdate");

//$field[] = array("type"=>"select","value"=>"gender","option"=>array("Male","Female"));

//$field[] = array("type"=>"text","value"=>"mobile","label"=>"Contact Number");


$field[] = array("type"=>"text","value"=>"refer","label"=>"Referred by","placeholder"=>"Please enter the username of your referrer");
?>


<div class="panel panel-default">

                        <div class="panel-heading" style='  background-color: #ddd'>

                        <strong>Register</strong>  

</div>

               <?php

			   if($error!='')

			   {

			   echo "<p style='color: red;margin-left: 33px;font-size:12px;'>$error</p>";

			   }

			   ?>								

                            <div class="panel-body">

<form method='POST' action=''>

<table width="100%">

            <?php

            $is_editable_field = 1;

            foreach($field as $inputs)

            {

                        if($inputs['label']!='')

                        {

                        $label = $inputs['label'];

                        }

                        else

                        {

                        $label = ucwords($inputs['value']);

                        }

            ?>

                  

                    <tr>

                      <td width="20%" class="key" valign="top" ><label for="accounts_name"><?php echo $label; ?><?php echo $req_fld?>:</label></td>

                      <?php if ( $is_editable_field ) { ?>

                      <td width="60%">

                      <?php

                      if ($inputs['type']=='select')

                      {

          

                          

                        

                      

                        ?>

                        <select name="<?php echo $inputs['value']; ?>" id="<?php echo $inputs['value']; ?>" required <?php echo $inputs['attr']; ?>>

                        <?php

                        foreach($inputs['option'] as $val)

                        {

                          ?>

                          <option <?php if($$inputs['value']==$val){echo"selected='selected'";} ?> value='<?php echo $val;?>'><?php echo $val;?></option>

                          <?php

                        }

                        ?>

                        </select>

                        <span class="validation-status"></span>

                        <?php

                        

                      }

                      else

                      {

                        ?>

                        <input <?php if($inputs['value']!='refer') { echo 'required'; }?> <?php echo $inputs['attr']; ?> type="<?php echo $inputs['type']; ?>" name="<?php echo $inputs['value']; ?>" id="<?php echo $inputs['value']; ?>" placeholder="<?php echo $inputs['placeholder']; ?>" maxlength="255" value="<?php echo $_POST[$inputs['value']]; ?>" />

                        <span class="validation-status"></span>                       

                        <?php

                      }

                      ?>



                      </td>

                      <?php } else { ?>

                      <td><?php echo $$inputs['value']; ?></td>

                      <?php } ?>                                                                                                    

                    </tr>

            <?php

            }

            ?>

			
			
<!-- 			
					<tr>
                      <td class="key" valign="top"><label for="accounts_name">Referral Username:</label></td>

                      
                      <td>

                      
                        <input required="" type="text" name="refer" id="refer" maxlength="255" value="">

                        <span class="validation-status"></span>                       

                        


                      </td>

                                                                                                                          

                    </tr>	 -->		
			
			
			
			
			
			
</table>
<br/>
<center>
      <div class='row'>
        <div class='col-xs-12'>
          <script type="text/javascript">
          var onloadCallback = function() {
          grecaptcha.render('test', {
          'sitekey' : '6LfmMTkUAAAAAI-BqOClWhvBByuZ65CZmFgvp9px',
          'callback' : verifyCallback,
          });
          };
         var verifyCallback = function(response) {
            if(response!=''){
             jQuery('#recap').val(response);
            }
          };

          </script>
          <div id='test' style='margin-left: 10px;'></div>
          <br/>
        </div>
      </div>  

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script>
</center>
<?php
$queryx = "SELECT * FROM tbl_cmsmanager WHERE id='39'";
$qx = mysql_query_cheat($queryx);
$rowx = mysqli_fetch_array_cheat($qx);
?>
<style>
#agreement {
    width: 60%;
    text-align: left;
    border: 1px solid grey;
    padding: 4px;
	display:none;
}
#registerbutton{
	display:none;
}

input[type=text],input[type=password],input[type=email], select {
  width:60%;
}
</style>
<br/><br/>

<input type='hidden' name='date_created' value='<?php echo date("Y-m-d h:i:s"); ?>'> 
<center>
<table>
<tr>
<td><input id='terms' name='termscondition' type='checkbox'onclick="checkterms()" style='margin-top: 11px;'></td>
<td>I agree to the terms and conditions. <a href='javascript:void(0)' onclick="jQuery('#agreement').slideToggle();">View here</a></td></tr>
</table>
</center>
<center>
	<div id='agreement'>
		<?php echo $rowx['cmsmanager_content']; ?>
	</div>
</center>
<center><input id='registerbutton' type='submit' name='submit' value='Register'></center>

</form>

                            </div>

                           

                        </div>
                