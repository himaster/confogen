<?php
    putenv('PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin:/root/bin:/var/www/confogen/');
<<<<<<< HEAD
    exec('cd /var/www/confogen/ && git fetch origin && git reset --hard origin/cdn 2>&1', $output);
=======
    exec('cd /var/www/confogen/ && git fetch origin && git reset --hard origin/master 2>&1', $output);
>>>>>>> f735aab7fc8d4f43717abc540098fe3b2077d5ad
    print_r($output);
?>