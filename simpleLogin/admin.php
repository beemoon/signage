<?php
// Déconnection si un simple utilisateur connecté tente de venir sur cette page
session_set_cookie_params('1800','/',$_SERVER['HTTP_HOST']);

$SID = session_id();
if(empty($SID)) session_start() or exit(basename(__FILE__).'(): Could not start session');

if (basename($_SESSION['parentURL'])!='admin.php'){
	session_destroy();
	include('beeProtect.php');
} else {
	include('beeProtect.php');
}
?>
<!--
Source:
	http://htmlrockstarsdemo.com/playground/tab-example/index.html
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<!--[if lte IE 7]><meta http-equiv="X-UA-Compatible" content="chrome=1"><![endif]--> 

<title>Layout</title>

<link rel="stylesheet" href="css/adminreset.css" type="text/css" media="screen" />

<link rel="stylesheet" href="css/adminstyle.css" type="text/css" media="screen" />

</head>
<body>


<div id="box">
	
	<ul id="menu">
		<li><a href="#users">Simple users</a></li>
		<li><a href="#admin">Admin users</a></li>
		<li>
			<a href="">
			<FORM action="#" method="post">
			    <P>
			    <INPUT type="hidden" name="logout" value="logout">
			    <INPUT type="submit" value="Logout" class="text_button"> 
			    </P>
			</FORM>
			</a>
		</li>
	</ul>
	<!-- e tab menu -->
	
	<ul id="boxes">
		
		<li id="users" class="box">
		Un utilisateur par ligne.<br/>Le login et mot de passe sont séparés par 2 : (::)<br/><br/>
			<?php
				if ($_POST['newContent']!=''){
				file_put_contents('usersList/users.acl', $_POST['newContent']);
				}
				$fileContent = file_get_contents('usersList/users.acl');
				echo "
				<FORM action=\"\" method=\"post\">
				<textarea style=\"height:200px; width:275px;\" name=\"newContent\">".$fileContent."</textarea><br/>
				<p style=\"text-align:center\"><INPUT type=\"submit\" value=\"Valider\"></p>
				</FORM>";
			?>
			<span></span>
		</li>
		
		
		
		<li id="admin" class="box">
		<b><u>ATTENTION</u></b>: ces utilisateurs pourront accéder à la liste des utilisateurs et les gérer!<br/><br/>
			<?php
				if ($_POST['newContentAdmin']!=''){
				file_put_contents('usersList/admin.acl', $_POST['newContentAdmin']);
				}
				$fileContentAdmin = file_get_contents('usersList/admin.acl');
				echo "
				<FORM action=\"\" method=\"post\">
				<textarea style=\"height:200px; width:265px;\" name=\"newContentAdmin\">".$fileContentAdmin."</textarea><br/>
				<p style=\"text-align:center\"><INPUT type=\"submit\" value=\"Valider\"></p>
				</FORM>";
			?>
			<span></span>
		</li>
		
		
		
		<li id="logout" class="box">
			
			<span></span>
		</li>
		
	</ul><!-- e: boxes -->

	
</div><!-- e: global wrapping #box -->

</body>
<!--[if lt IE 7]><script type="text/javascript" src="js/unitpngfix.js"></script><![endif]-->
</html>
