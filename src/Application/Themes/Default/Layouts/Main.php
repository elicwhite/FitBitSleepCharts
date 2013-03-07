<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Saros Framework</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->getWebRoot() ?>images/favicon.ico" />
    <script type="text/javascript">
        var ROOT_URL = "<?php echo $GLOBALS['registry']->config["siteUrl"]?>";
    </script>
	<?php echo $this->headStyles()->appendFile("css/main.css")
                                    ->appendFile("css/rickshaw.min.css")
                                    ->appendFile("css/charts.css") ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <?php echo $this->headScripts()->appendFile("js/d3.min.js")
                                    ->appendFile("js/d3.layout.min.js")
                                    ->appendFile("js/rickshaw.min.js")
                                    ->appendFile("js/charts.js") ?>
</head>
<body>
	<div id="container">
		<div id="main">
			<?php
            echo $this->content()
            ?>
		</div>
		<div id="footer">
            <?php echo \Spot\Log::queryCount() ?> Queries
		</div>
	</div>
</body>
</html>