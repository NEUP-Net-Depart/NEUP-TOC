<?php

    //$ip = '192.168.43.19';
    $ip = 'localhost';
    $port = 2332;

    $resSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    if(checkOK($resSocket,'Sock Create') == -1) exit(-1);

    $resClientConn = socket_connect($resSocket, $ip, $port);

    if(checkOK($resClientConn, 'Sock Conn') == -1) exit(-1);
    echo "Starting Client";

    //$msgFromServer = socket_read($resSocket, 2345);

    echo $msgFromServer;

    while(1)
    {
        $msgFromServer = socket_read($resSocket, 2345);

        if($msgFromServer != "")
        {
            echo "Msg Recved !\n";
            echo "Msg is : " . $msgFromServer;
        }
    }
    socket_close($resSocket);



    function checkOK ($varr, $errType)
    {
        if ($varr == FALSE)
        {
            echo $errType . " Failed\n";
            return -1;
        }
        else {
            echo $errType . " Success\n";
            return 0;
        }
    }
 ?>
