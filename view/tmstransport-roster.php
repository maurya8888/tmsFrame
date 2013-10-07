<!doctype html>
<html>
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
    <script src="../js/jquery-2.0.3.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/dates.js"></script>
    <link rel="stylesheet" href="../css/common.css"/>
    <link rel="stylesheet" href="../css/jquery-ui.css"/>
    <title>Transport Portal</title>
	<script>
		$(function() {
			var year;
			var month_number;
			var date_number;
			$( "#datepicker" ).datepicker({
				numberOfMonths: 3,
				showAnim: "fold",
				showButtonPanel: true
			});
			
			function convert_date(d) {
					for(x in calendar) {
						for(y in calendar[x]) {
								if(new Date(calendar[x][y].start) <= d && d <= new Date(calendar[x][y].end) ) {
										year = x;
										month_number = y;
										date_number = 1;
										for(i=new Date(calendar[x][y].start); i<d; i.setDate(i.getDate()+1) ) {
												date_number++;
											}
									}
							}
						}
				}
				
			$("#generate").click(function(e) {
					if($("#datepicker").val() != '') {
						var date = new Date($("#datepicker").val());
						convert_date(date);
						$("#data").val(date_number + "#" + month_number + "#" + year);
						$("form#generate").submit();
					}
            });
		});
    </script>
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
        <section id="d-picker">
        	<p>Date: <input type="text" id="datepicker" placeholder="Click here to select date" /></p>
           <div id="generate" class="button">Generate Roster</div>
        </section>
        <form id="generate" method="post">
            <input type="hidden" name="controller" value="thd" id="controller"/>
            <input type="hidden" name="handle" value="generate" id="handle"/>
            <input type="hidden" id="data" name="data" />
        </form>
        <section id="roster">
        	<table border="1">
        	<?php 
				function seconds_to_time($v) {
						$rem_sec = $v % 3600;
						$hours = (int) ($v / 3600);
						$minutes = (int) ($rem_sec/60);
						$r = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
						return $r;
					}
				foreach($GLOBALS['return_value']['roster'] as $key => $roster) {
							foreach($GLOBALS['return_value']['shifts'] as $s) {
									if($s['value'] == $key) {
											$shift = $s['shift'];
										}
								}
						foreach($roster as $k => $routes) {
									foreach($GLOBALS['return_value']['zones'] as $z) {
											if($z['value'] == $k) {
													$zone = $z['Zone'];
												}
										}
								for($n=0; $n<count($routes)-1; $n++) {
										$rn = 1 + (int)$n;
										$t_time = (int) $routes[$n]['route_time'] + (int) $routes[$n]['time_from_last'] + 900;
										$tmp = explode(" - ",$shift);
										$to_seconds = ((int) $tmp[0]/100)*3600;
										if($to_seconds - $t_time < 0) {
												$pu_time = (24*3600*$to_seconds) - $t_time;
											} else {
													$pu_time = $to_seconds - $t_time;
												}
										if($routes[$n]['guard_required']) {
												$n_pickups = $routes[$n]['route_count'] - 1;
												$guard_required = 'Yes';
											} else {
													$n_pickups = $routes[$n]['route_count'];
													$guard_required = 'No';
												}
										echo '<tr><td>Sl No</td><td>R.No</td><td>Shift</td><td>C.Center</td><td>Gender</td><td>Name</td><td>Address</td><td>Phone</td><td>Pickup Time</td><td>OCP</td><td>Location</td><td>Zone</td><td>Cab Type</td><td>Guard</td></tr>';
										for($i=0; $i<$n_pickups; $i++) {
												echo '<tr>';
												$sn = $i + 1;
												echo '<td>' . $sn . '</td>';
													$empid = array_keys($routes[$n][$i]);
													$pu_time += $routes[$n][$i][$empid[0]];
													foreach($routes['emp_list'] as $e) {
															if($e['EmpID'] == $empid[0]) {
																	echo "<td>$rn</td>";
																	echo "<td>" . $shift . "</td>";
																	echo "<td>" . $e['BU'] . "</td>";
																	$g = $e['Female']=='1'?'F':'M';
																	echo "<td>" . $g . "</td>";
																	echo "<td>" . $e['Name'] . "</td>";
																	echo "<td>" . $e['Address'] . "</td>";
																	echo "<td>" . $e['Phone'] . "</td>";
																	echo "<td>" . seconds_to_time($pu_time) . "</td>";//'-' . $t_time . '-'  . $routes[$n][$i][$empid[0]] . "</td>";
																	echo "<td>" . $n_pickups . "</td>";
																	echo "<td>" . $e['Area'] . "</td>";
																	echo "<td>" . $zone . "</td>";
																	$cab = $n_pickups<=3?"INDICA":"XYLO";
																	echo "<td>" . $cab . "</td>";
																	echo "<td>" . $guard_required . "</td>";
																}
														}
												echo '</tr>';
											}
									}
							}
					}
			?>
           </table>
        </section>
	</section>
</body>
</html>