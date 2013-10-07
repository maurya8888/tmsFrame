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
    </section>
</body>
</html>	