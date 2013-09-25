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
	<title>Managers Portal</title>
	<!-- InstanceEndEditable -->
	<script src="../js/jquery-2.0.3.min.js"></script>
    <link rel="stylesheet" href="../css/common.css"/>
    <!-- InstanceBeginEditable name="head" -->
    <script src="../js/dates.js"></script>
		<script>
			<?php 
				echo "var request = '" . $GLOBALS['return_value'][0] . "';";
				echo "var shifts = '" . $GLOBALS['return_value'][2] . "';";
			?>
			
			request = request.split("#");
			var number_of_days = calendar['y'+request[0]][request[1]]['days'];
			var number_of_weeks = number_of_days/7;
			var first_day = calendar['y'+request[0]][request[1]]['start'];
			var last_day = calendar['y'+request[0]][request[1]]['end'];
			var week_selected = 0;
			var updator_selected = 0;
			var container_height = 0;
			var save_bound = false;
			var track_changes = {};
			var shiftselopt = '<select><option value="0">OFF</option><option value="1">0600 - 1500</option><option value="2">0700 - 1600</option><option value="3">1230 - 2130</option><option value="4">1300 - 2200</option><option value="5">1400 - 2300</option><option value="6">1800 - 0300</option><option value="7">2000 - 0500</option><option value="8">2100 - 0600</option><option value="9">2230 - 0730</option><option value="10">2330 - 0830</option></select>';
			
			function select_option(el,atr,val) {
					el.find("option:selected").removeAttr('selected');
					el.find("option").filter(function() {
						return $(this).attr(atr) == val;
					}).prop('selected', true);
				}
				
			function generate_shifts() {
					$('#left .non-head').each(function(index, element) {
							var h = '';
							container_height += 20;
                        for(i=1; i<=number_of_days; i++) {
								h += "<div class='non-head right' data-date='d" + i + "'empid='" + $(this).attr("id") + "' style='margin-left: 0px!important;'>" + shiftselopt + "</div>";
							}
							$("#container").append(h);
                    });
				}
				
			function select_marked_shifts() {
					shifts = jQuery.parseJSON(shifts);
					$.each(shifts,function(key,value) {
							$.each(shifts[key],function(i,v) {
									select_option($("div.right[empid=" + key + "][data-date=d" + v['Date'] + "]").find("select"),"value",v['ShiftID']);
								});
						});
				}
				
			function set_dates() {
					for(i=0; i<7;) {
							var d = new Date(first_day);
							d.setDate(d.getDate() + week_selected*7 + i);
							$("#right div.heading:nth-child(" + ++i + ")").html(d.toDateString());
						}
				}

			$(document).ready(function(e) {
				generate_shifts();
				
				select_option($('#year'),"value",request[0]);
				select_option($('#month'),"adbmonth",request[1]);
				
				if(number_of_weeks == 4) {
						$("#week-filters div").eq(4).css("display","none");
					} else {
							$("#container").css("width","3885px");
						}
						
				$("#container").css("height",container_height + 2);
				$("#page").height($("#page").height() + 130);
						
				select_marked_shifts();

				set_dates();

				$("#update-filters div").click(function(e) {
                      $(this).parent().find(".active").removeClass("active");
						$(this).addClass("active");
						updator_selected = $(this).index();
                });
				
				$("#week-filters div").click(function(e) {
                      $(this).parent().find(".active").removeClass("active");
						$(this).addClass("active");
						week_selected = $(this).index();
						set_dates();
						$("#container").css("left",week_selected*-777+1);
						if( week_selected+1==number_of_weeks ) {
								$("#slider").css("width","779px");
							} else {
									$("#slider").css("width","778px");
								}
                });
				
				$(".non-head.right > select").change(function(e) {
					  if(!save_bound) {
						  	save_bound = true;
							$("#save-button div").removeClass("disabled");
							$("#save-button div").click(function(e) {
									var year = $("#year option:selected").val();
									var month = $("#month option:selected").attr("adbmonth");
									var avrsid = $("#user_info").attr("data-avrsid");
									var data = year + "#" + month + "#" + avrsid + "#" + JSON.stringify(track_changes);
									$("#data").val(data);
									$("#handle").val("save");
									$("form#date").submit();
                            });
						  }
                    var v = $(this).val();
					  var parent = $(this).parent();
					  var empid = parent.attr("empid");
					  if( (parent.index()-6)%7 != 1 && (parent.index()-6)%7 !=2 ) {
						  switch(updator_selected) {
								case 0: track_changes[parent.attr("data-date") + "-" + empid] = v;
										break;
								case 1: for(i=week_selected*7+3; i<=(week_selected+1)*7; i++ ) {
												select_option($("div[empid=" + empid + "][data-date=d" + i + "]").find("select"),"value",v);
												track_changes["d" + i + "-" + empid] = v;
											}
										break;
								case 2: for(j=0; j<number_of_weeks; j++) {
												for(i=j*7+3; i<=(j+1)*7; i++ ) {
														select_option($("div[empid=" + empid + "][data-date=d" + i + "]").find("select"),"value",v);
														track_changes["d" + i + "-" + empid] = v;
													}
											}
										break;
							  }
					  }
					});
				
				$("#date-go").click(function(e) {
					  var year = $("#year option:selected").val();
					  var month = $("#month option:selected").attr("adbmonth");
					  var avrsid = $("#user_info").attr("data-avrsid");
					  var data = year + "#" + month + "#" + avrsid;
					  $("#data").val(data);
					$("form#date").submit();
				});
			});
        </script>  
    <!-- InstanceEndEditable -->				
</head>

<body>
	
	<section id="page">
		<section id="user_info" data-name="<?php echo $GLOBALS['user_info'][0]['Name']?>" data-avrsid="<?php echo $GLOBALS['user_info'][0]['avrsid']?>" data-ldap="<?php echo $GLOBALS['user_info'][0]['ldap']?>" data-bu="<?php echo $GLOBALS['user_info'][0]['bu']?>">Welcome - <?php echo $GLOBALS['user_info'][0]['Name']?></section>
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
			<section id="update-filters">
            	 <div class="button active">Update Single</div>
               <div class="button">Update Week</div>
               <div class="button">Update Month</div>
           </section>
            <section id="week-filters">
               <div class="button active">Week 1</div>
               <div class="button">Week 2</div>
               <div class="button">Week 3</div>
               <div class="button">Week 4</div>
               <div class="button">Week 5</div>
           </section>
           <section id="save-button">
           	<div class="button disabled">Save</div>
           </section>
           <section id="calendar">
           	<section id="left">
            		<div class="heading left">My Team</div>
                  <?php
				  		foreach($GLOBALS['return_value'][1] as $value) {
								echo "<div class='non-head left' id='" . $value['EmpID'] . "'>" . $value['Name'] . "</div>";
							}
				  	?>
            	</section>
              <section id="right">
              		<div class="heading right" style="margin-left:0; background-color:#D4FFC1;">Saturday</div>
                  <div class="heading right" style="background-color:#D4FFC1;">Sunday</div>
                  <div class="heading right">Monday</div>
                  <div class="heading right">Tuesday</div>
                  <div class="heading right">Wednesday</div>
                  <div class="heading right">Thursday</div>
                  <div class="heading right">Friday</div>
                  <div id="slider">
                  	<div id="container"></div>
                  </div>
              </section>
           </section>
		<!-- InstanceEndEditable -->
	</section>
</body>
<!-- InstanceEnd --></html>