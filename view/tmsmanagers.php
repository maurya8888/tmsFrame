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
	<title></title>
	<!-- InstanceEndEditable -->
	<script src="../js/jquery-2.0.3.min.js"></script>
    <link rel="stylesheet" href="../css/common.css"/>
    <!-- InstanceBeginEditable name="head" -->
    <script>
    	$(document).ready(function(e) {
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
        
		<!-- InstanceEndEditable -->
	</section>
</body>
<!-- InstanceEnd --></html>