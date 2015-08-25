<?php
    putenv('PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin:/root/bin:/var/www/confogen/');
    exec('cd /var/www/confogen/ && sudo -t git pull https://github.com/himaster/confogen.git master 2>&1', $output);
    print_r($output);
?>