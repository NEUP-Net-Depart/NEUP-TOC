<?php
    error_reporting(E_ALL);
    //$ip = '192.168.43.19';
    $ip = 'localhost';
    $port = 2333;

    $resSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    if(checkOK($resSocket,'Sock Create') == -1) exit(-1);
    $resClientConn = socket_connect($resSocket, $ip, $port);

    if(checkOK($resClientConn, 'Sock Conn') == -1) exit(-1);
    echo "Starting Client\n";

        //$msgFromServer = socket_read($resSocket, 2345);
        $msgToServer = "1043.cpp#C++#20151111#whatthefuckismd5sum";
        echo "Sending compiling request to server ...\n";
        socket_write($resSocket, $msgToServer, strlen($msgToServer) + 1);
        $msgFromServer = socket_read($resSocket,5);         //Listening for signal
        echo "DEBUG: Recvd##" . $msgFromServer . "\n";
        if($msgFromServer == "FATAL")
        {
            die("Server is down now 233\n");
        }
        else if($msgFromServer == "###OK")
        {
            echo "Compiling ok ... Program running\n";
            $msgFromServer = socket_read($resSocket,5);     //Listening for signal
            //echo "DEBUG: Recvd" . $msgFromServer . "\n";
            if($msgFromServer == "###OK")
            {
                echo "Running ok ... Generate output\n";
                $msgFromServer  = socket_read($resSocket, 99999);
                //echo "DEBUG: Recvd" . $msgFromServer . "\n";
                echo $msgFromServer . "\n";
            }
            //echo "DEBUG: Recvd" . $msgFromServer . "\n";
        }
        else if($msgFromServer == "##ERR")
        {
            //echo "DEBUG: Recvd" . $msgFromServer . "\n";
            echo "Compile Failed , errMsg is below\n";
            $msgFromServer = socket_read($resSocket, 99999);
            //echo "DEBUG: Recvd" . $msgFromServer . "\n";
            echo $msgFromServer;
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
