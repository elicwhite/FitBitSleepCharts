<!DOCTYPE html>
<html>
    <head>
        <title>FitBit Sleep Charts</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->getWebRoot() ?>favicon.ico" />
        <script type="text/javascript">
            var ROOT_URL = "<?php echo $GLOBALS['registry']->config["siteUrl"]?>";
        </script>
        <?php echo $this->headStyles()
            ->appendFile("bootstrap/css/bootstrap.min.css")
            ->appendFile("css/theme.css")
            ->appendFile("css/site.css")
            ->appendFile("bootstrap/css/bootstrap-responsive.min.css")
            //->appendFile("css/main.css")
            ->appendFile("css/rickshaw.min.css")
            ->appendFile("css/charts.css");
             ?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <?php echo $this->headScripts()
            ->appendFile("js/globals.php")
            ->appendFile("bootstrap/js/bootstrap.min.js")
            ->appendFile("js/d3.min.js")
            ->appendFile("js/d3.layout.min.js")
            ->appendFile("js/rickshaw.min.js")
            ->appendFile("js/charts.js") ?>
    </head>
    <body>

        <div class="container">
            <div class="masthead">
                <h3 class="muted">FitBit Sleep Charts</h3>
                <div class="navbar">
                    <div class="navbar-inner">
                        <div class="container">
                            <ul class="nav">
                                <li class="active"><a href="<?php echo $GLOBALS["registry"]->utils->makeLink("Index")?>">Home</a></li>
                                <li><a href="<?php echo $GLOBALS["registry"]->utils->makeLink("Index", "update")?>">Update</a></li>
                                <li><a href="<?php echo $GLOBALS["registry"]->utils->makeLink("Index", "graph")?>">Chart</a></li>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Contact</a></li>
                                <li><a href="<?php echo $GLOBALS["registry"]->utils->makeLink("Index", "logout")?>">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div><!-- /.navbar -->
            </div>

            <?php
                echo $this->content()
            ?>

            <hr>

            <div class="footer">
                <p>&copy; Eli White 2013 - <?php echo \Spot\Log::queryCount() ?> Queries</p>
            </div>

        </div> <!-- /container -->
    </body>
</html>