<?php
    putenv('PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin:/root/bin:/var/www/confogen/');
    exec('cd /var/www/confogen/ && /usr/bin/git pull https://github.com/himaster/confogen.git master 2>&1', $output);
    print_r($output);
?>