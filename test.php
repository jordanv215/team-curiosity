<?php
require_once("/etc/apache2/redrovr-conf/encrypted-config.php");

$info = ['hostname' => 'localhost', 'username' => 'mars', 'password' => 'edgyzairedavitalarmbushy', 'database' => 'mars', 'authkeys' => '{"facebook":{"clientId":"1701694373430554","clientSecret":"6a8c628aa6b5261c174558e66d313349"},"google":{"clientId":"148844505760-ul88sbvg1kppr9emjv1a2bhef0lghjvk.apps.googleusercontent.com","clientSecret":"u6uhKp-YaO9-UqOqYLkgKOFG"},"instagram":{"clientId":"81661637ad7346eb8ed57cccc4179271","clientSecret":"d2cae66b54454ff3aaa9e75834abd396"},"nasa":{"clientSecret":"gunW6j8PSqAlugKjPFXsQc3dZuQhQOzC73nqYAMI"},"reddit":{"clientId":"p-_k1lQpvSBZGQ","clientSecret":"73dn0d7-kWFnQPhySFJCUSVOIo0"}}'];
writeConfig($info, "/etc/apache2/redrovr-conf/mars.ini");