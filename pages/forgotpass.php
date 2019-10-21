<?php
require_once("./connect.php");
?>

<div id="notibar">



</div>

<?php

if($_GET['error']==1)

{

	?>

<div class="warning"><ul class="fa-ul"><li><i class="fa fa-warning fa-li"></i> Please login before accessing that page.</li></ul></div>

	<?php

}

?>



                        <div class="panel panel-default">

                        <div class="panel-heading" style=' background-color: #ddd'>

                        <strong>Forgot Pass</strong>  

                        </div>

                            <div class="panel-body">

                                <form role="form">

                                       <br />

                                     <div class="form-group input-group">

                                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>

                                            <input id="email" type="email" class="form-control" placeholder="Your Email" />

                                        </div>                              

                                     <a href="javascript:void(0);" onclick="processemail()" class="btn btn-primary ">Send now</a>

									 <a href='index.php?page=signin' style='float:right;'><< Back</a>

                                    </form>

                            </div>

                          

                        </div>

                    </div>

                

	<script>

	function processemail()

	{

		var email = $('#email').val();

		$('#notibar').html('<div class="noti"><ul class="fa-ul"><li><i class="fa fa-cog fa-spin fa-li"></i> Please wait.. Checking your acccount.</li></ul></div>');

    $.post("action/process-email.php",{email:email}, function(data, status){

		//alert(data);

		$('#notibar').html('');

		if(data=="0")

		{

			$('#notibar').html('<div class="warning"><ul class="fa-ul"><li><i class="fa fa-warning fa-li"></i>Please check your email not exist.</li></ul></div>');

		}

		if(data=="1")

		{

			$('#notibar').html('<div class="noti"><ul class="fa-ul"><li><i class="fa fa-check fa-li"></i> Password sent to the email.</li></ul></div>');

		}

    });		

	}

	</script>
                