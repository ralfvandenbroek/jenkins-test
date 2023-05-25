<?php

$foo = $_GET["foo"];
mysql_query("SELECT * FROM table WHERE foo = $foo");
