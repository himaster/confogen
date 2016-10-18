<?php
    putenv('PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin:/root/bin:/var/www/confogen/');
    #exec('cd /var/www/confogen/ && git fetch origin && git reset --hard origin/master 2>&1', $output);
    exec('cd /var/www/confogen/ && git pull 2>&1', $output);
    print_r($output);
?>