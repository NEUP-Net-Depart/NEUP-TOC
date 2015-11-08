<?php

    //$ip = '192.168.43.19';
    $ip = 'localhost';
    $port = 2666;

    $resSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    if(checkOK($resSocket,'Sock Create') == -1) exit(-1);
    $resClientConn = socket_connect($resSocket, $ip, $port);

    if(checkOK($resClientConn, 'Sock Conn') == -1) exit(-1);
    echo "Starting Client";

    while(1)
    {
        //$msgFromServer = socket_read($resSocket, 2345);
        $msgToServer = "a.cpp#C#20151111#whatthefuckismd5sum";
        echo "Sending compiling request to server ...";
        socket_write($resSocket, $msgToServer, strlen($msgToServer) + 1);
        $msgFromServer = socket_read($resSocket,1000);
        if($msgFromServer == "FATAL")
        {
            die("Server is down now 233\n");
        }
        else if($msgFromServer == "OK")
        {
            echo "Running ok Result is below\n";
            $msgFromServer = socket_read($resSocket, 1000);
            echo $msgFromServer;
        }
        else if($msgFromServer == "NO")
        {
            echo "Running Failed , errMsg is below\n";
            $msgFromServer = socket_read($resSocket, 1000);
            echo $msgFromServer;
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
