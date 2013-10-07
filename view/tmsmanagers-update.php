<?php if(isset($GLOBALS['return_value'][5])) //var_dump($GLOBALS['return_value'][5]); ?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/tmsmanagers.dwt.php" codeOutsideHTMLIsLocked="false" -->
<!--[if IE]>
        <script>
            window.onload = function() {
                var msg="This Page works only in Firefox and Chrome. Internet Explorer is not supported.";
                var body = document.getElementsByTagName('body');
                body[0].innerHTML=msg;	
            }
        </script>
<![endif]-->
<head>
	<meta charset="UTF-8">
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Managers Portal - Update Page</title>
	<!-- InstanceEndEditable -->
	<script src="../js/jquery-2.0.3.min.js"></script>
    <link rel="stylesheet" href="../css/common.css"/>
    <!-- InstanceBeginEditable name="head" -->
    <script>
    	$(document).ready(function(e) {
			 var track_changes = {};
			 var update_bound = false;
			 var bu_defined = false;
			 <?php if(isset($GLOBALS['return_value'][5])) echo "var empid = '" . $GLOBALS['return_value'][5][0]['EmpID'] . "';" ?>
			 <?php if(isset($GLOBALS['return_value'][5])) echo "var bu_defined = true;" ?>
			 
			 function bind_update() {
				 	if(!update_bound) {
							update_bound = true;
							$("#save-member").removeClass("disabled");
							$("#save-member").click(function(e) {
									var avrsid = $("#user_info").attr("data-avrsid");
									var manid = $("#user_info").attr("data-empid");
									var member = $("#EmpID").val();
									var data = avrsid + "#" + manid + "#" + member + "#" + JSON.stringify(track_changes);
									$("#data").val(data);
									$("#handle").val("update");
									$("form#date").submit();
                            });
						}
				 }
			 
			 $("#details div input[type=checkbox]").change(function(e) {
                  var id = $(this).attr("id");
					var value = $(this).is(':checked')?1:0;
					track_changes[id + '-' + empid] = value;
					bind_update();
					//console.info(track_changes);
            });
			 
			 $("#details div input[type=text]").change(function(e) {
				 	var value = $(this).val();
				 	var patt = /[#;'"]/g;
					if(!patt.test(value)) {
						var id = $(this).attr("id");
						track_changes[id + '-' + empid] = value;
						bind_update();
					} else {
							alert('Alert: "#" or ";" or \' or \"are not allowed as valid input characters.');
							$(this).val($(this).attr("data-orig"));
						}
					//console.info(track_changes);
            });
			 
			 $("#details div select").change(function(e) {
					var id = $(this).attr("id");
					var value = $(this).find("option:selected").val();
					track_changes[id + '-' + empid] = value;
					bind_update();
					//console.info(track_changes);
            });
			
			function manager_set(t,sel_first=false) {
					var value = t.find("option:selected").val();
				   	$("#Manager option").css("display","none");
					$("#Manager option[data-bu=" + value.toUpperCase() + "]").css("display","block");
					$("#Manager option[data-bu=" + value.toUpperCase() + "]").each(function(index, element) {
                        if(index == 0 && sel_first ){
								$(this).prop("selected",true);
							}
                    });
				}
			
			if(bu_defined) manager_set($("#BU"));
			
			 $("#BU").change(function(e) {
				 	$("#Manager option:selected").removeAttr("selected");
                  manager_set($(this),true);
            });
			 
			 $("#page").height($("#page").height() + 110);
			 
			 $("#member-select").click(function(e) {
					var avrsid = $("#user_info").attr("data-avrsid");
					var manid = $("#user_info").attr("data-empid");
					var member = $("#team-list select option:selected").val();
					var data = avrsid + "#" + manid + "#" + member;
					$("#data").val(data);
					$("#handle").val("update");
					$("form#date").submit();
            });
			
            $("#date-go").click(function(e) {
				  var year = $("#year option:selected").val();
				  var month = $("#month option:selected").attr("adbmonth");
				  var avrsid = $("#user_info").attr("data-avrsid");
				  var manid = $("#user_info").attr("data-empid");
				  var data = year + "#" + month + "#" + avrsid + "#" + manid;
				  $("#data").val(data);
                $("form#date").submit();

            });
        });
    </script>   
    <!-- InstanceEndEditable -->				
</head>

<body>
	
	<section id="page">
		<section id="user_info" data-name="<?php echo $GLOBALS['user_info'][0]['Name']?>" data-avrsid="<?php echo $GLOBALS['user_info'][0]['avrsid']?>" data-ldap="<?php echo $GLOBALS['user_info'][0]['ldap']?>" data-bu="<?php echo $GLOBALS['user_info'][0]['bu']?>" data-empid="<?php echo $GLOBALS['user_info'][0]['employeenumber']?>">Welcome - <?php echo $GLOBALS['user_info'][0]['Name']?></section>
		<section id="company_info">
        	<?php echo $GLOBALS['config']['company']?>
           <figure>
           	<img src="<?php echo $GLOBALS['config']['company_logo']?>" alt="company logo"/>
           </figure>
        </section>
		<section id="date-filters">
       		<form id="date" method="post" >
				  <input type="hidden" name="controller" value="manager" id="controller"/>
                <input type="hidden" name="handle" value="listteam" id="handle"/>
                <input type="hidden" id="data" name="data" />
                <select id="year" name="year">
                     <option value="2013">2013</option>
               </select>
               <select id="month" name="month">
                    <option value="1" adbmonth="q1m1">Quarter 1 Month 1</option>
                    <option value="2" adbmonth="q1m2">Quarter 1 Month 2</option>
                    <option value="3" adbmonth="q1m3">Quarter 1 Month 3</option>
                    <option value="4" adbmonth="q2m1">Quarter 2 Month 1</option>
                    <option value="5" adbmonth="q2m2">Quarter 2 Month 2</option>
                    <option value="6" adbmonth="q2m3">Quarter 2 Month 3</option>
                    <option value="7" adbmonth="q3m1">Quarter 3 Month 1</option>
                    <option value="8" adbmonth="q3m2">Quarter 3 Month 2</option>
                    <option value="9" adbmonth="q3m3">Quarter 3 Month 3</option>
                    <option value="10" adbmonth="q4m1">Quarter 4 Month 1</option>
                    <option value="11" adbmonth="q4m2">Quarter 4 Month 2</option>
                    <option value="12" adbmonth="q4m3">Quarter 4 Month 3</option>
            	</select>
               <div class="button" id="date-go">Go</div>
           </form>
        </section>
		<!-- InstanceBeginEditable name="content" -->
       		<section id="team-list">
            <select>
				<?php
					  $selected = '';
                    foreach($GLOBALS['return_value'][1] as $value) {
								if($value['EmpID'] == $GLOBALS['return_value'][5][0]['EmpID']) {
										$selected = 'selected';
									} else {
											$selected = '';
										}
                            echo "<option " . $selected . " value='e" . $value['EmpID'] . "'>" . $value['Name'] . "</option>";
                        }
                ?>
            </select>
            <div class="button" id="member-select">Retrieve</div>
           </section>
	   		<section id="details" <?php if(!isset($GLOBALS['return_value'][5])) echo 'style="display:none"'?>>
            	<div>
                    <label for="Zone">Zone : </label>
                    <select id="Zone">
                        <?php 
								if(isset($GLOBALS['return_value'][5])) {
									$selected = '';
									foreach($GLOBALS['return_value'][2] as $value) {
											if($value['value'] == $GLOBALS['return_value'][5][0]['Zone']) {
													$selected = 'selected';
												} else {
														$selected = '';
													}
											echo '<option ' . $selected . ' value="' . $value['value'] . '">' . $value['Zone'] . '</option>';
										}
								}
						   ?>
                    </select>	
               </div>
               <div>
                    <label for="BU">BU : </label>
                    <select id="BU">
                        <?php 
								if(isset($GLOBALS['return_value'][5])) {
									$selected = '';
									foreach($GLOBALS['return_value'][3] as $value) {
											if($value['value'] == $GLOBALS['return_value'][5][0]['BU']) {
													$selected = 'selected';
												} else {
														$selected = '';
													}
											echo '<option ' . $selected . ' value="' . $value['value'] . '">' . $value['bu'] . '</option>';
										}
								}
						   ?>
                    </select>	
               </div>
               <div>
               	  <label for="Manager">Manager : </label>
                    <select id="Manager">
                        <?php 
								if(isset($GLOBALS['return_value'][5])) {
									$selected = '';
									foreach($GLOBALS['return_value'][4] as $value) {
											if($value['avrsid'] == $GLOBALS['return_value'][5][0]['Manager']) {
													$selected = 'selected';
												} else {
														$selected = '';
													}
											echo '<option ' . $selected . ' data-bu="' . $value['bu'] . '" value="' . $value['avrsid'] . '">' . $value['Name'] . '</option>';
										}
								}
						   ?>
                    </select>
               </div>
               <div>
               	  <label for="Name">Name : </label>
                    <input type="text" id="Name" value="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Name'] ?>" data-orig="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Name'] ?>" />
               </div>
               <div>
               	  <label for="EmpID">Emp ID : </label>
                    <input type="text" id="EmpID" value="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['EmpID'] ?>" data-orig="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['EmpID'] ?>"/>
               </div>
               <div>
               	  <label for="Lat">Latitude : </label>
                    <input type="text" id="Lat" value="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Lat'] ?>" disabled data-orig="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Lat'] ?>"/>
               </div>
               <div>
               	  <label for="Lon">Longitude : </label>
                    <input type="text" id="Lon" value="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Lon'] ?>" disabled data-orig="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Lon'] ?>"/>
               </div>
               <div>
               	  <label for="Address">Address : </label>
                    <input type="text" id="Address" value="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Address'] ?>" data-orig="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Address'] ?>"/>
               </div>
               <div>
               	  <label for="Area">Area : </label>
                    <input type="text" id="Area" value="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Area'] ?>" data-orig="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Area'] ?>"/>
               </div>
               <div>
               	  <label for="Phone">Phone : </label>
                    <input type="text" id="Phone" value="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Phone'] ?>" data-orig="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['Phone'] ?>"/>
               </div>
               <div>
               	  <label for="ldap">LDAP : </label>
                    <input type="text" id="ldap" value="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['ldap'] ?>" data-orig="<?php if(isset($GLOBALS['return_value'][5])) echo $GLOBALS['return_value'][5][0]['ldap'] ?>"/>
               </div>
               <div>
               	  <label for="Female">Is Female ? : </label>
                    <input type="checkbox" id="Female" <?php if(isset($GLOBALS['return_value'][5])) if($GLOBALS['return_value'][5][0]['Female'] == 1) echo 'checked' ?> />
               </div>
               <div>
               	  <label for="nocab">Is Cab Not Required ? : </label>
                    <input type="checkbox" id="nocab" <?php if(isset($GLOBALS['return_value'][5])) if($GLOBALS['return_value'][5][0]['nocab'] == 1) echo 'checked' ?> />
               </div>
               <div>
               	<div id="save-member" class="button disabled">Update Record</div>
               </div>
           </section>
	   <!-- InstanceEndEditable -->
	</section>
</body>
<!-- InstanceEnd --></html>