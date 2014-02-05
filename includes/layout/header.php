<?php
if (!isset($layout_context)) {
	$layout_context = "public";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>CMS App <?php if ($layout_context == "admin") { echo "Admin"; } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="../css/reset.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lobster|Open+Sans">    
    <link href="../css/<?php if ($layout_context == "admin") { echo "admin"; } else { echo "public"; } ?>Style.css" rel="stylesheet" media="screen">
  </head>
  <body>

  	<header>
  		<h1>CMS App <?php if ($layout_context == "admin") { echo "Admin"; } ?></h1>
  		<?php if (logged_in()) { echo "<a href=\"logout.php\">Logout</a>"; } else { echo "<a href=\"login.php\">Login</a>"; } ?>
  	</header>
  	
