<?php
    putenv('PATH='. getenv('PATH') .':/home/developer/www/confogen/');
    exec('cd /home/developer/www/confogen/ && git pull https://github.com/himaster/confogen.git master 2>&1', $output);
?>