<?php
	print_r("PATH= ".getenv('PATH'));
    putenv('PATH='. getenv('PATH') .':/var/www/confogen/');
    exec('cd /var/www/confogen/ && /usr/bin/git pull https://github.com/himaster/confogen.git master 2>&1', $output);
    print_r($output);
?>