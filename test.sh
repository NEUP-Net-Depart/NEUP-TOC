#########################################################################
# File Name: test.sh
# Author: VOID_133
# QQ: 393952764
# mail: zhangjianqiu13@gmail.com
# Created Time: Sun 08 Nov 2015 08:55:06 AM CST
#########################################################################
#!/bin/bash

/opt/lampp/bin/php backend.php &
/opt/lampp/bin/php testcase/testClient.php &

read()

killall php
