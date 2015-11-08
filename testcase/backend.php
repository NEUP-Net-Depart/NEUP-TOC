<?php

    error_reporting(E_ALL);

    $port = 2332;
    $ip = '0.0.0.0';

    $resSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    if (checkOK ($resSocket, 'Socket Create') == -1) exit (-1);

    $resBindResult = socket_bind($resSocket, $ip, $port);

    if (checkOK($resBindResult, 'Sck bind') == -1) exit (-1);

    $resLisnResult = socket_listen($resSocket, 300);

    if (checkOK($resLisnResult, 'Sck listen') == -1) exit (-1);

    echo "Listening " . $ip . ':'. $port . "....\n";
    $cnt = 1;
    while(1)
    {
        $commSocket = socket_accept($resSocket);
        if($commSocket != FALSE)
        {
            $ttimasdf = "DMK is SB".$cnt++;

            socket_write($commSocket, $ttimasdf, strlen($ttimasdf));

            socket_close($commSocket);
        }
    }

    socket_close($resSocket);

    //$resConnResult = socket_connect($resSocket, $ip, $port);
    //echo $resConnResult;
    //echo socket_strerror(socket_last_error());
    //if (checkOK ($resConnResult, 'Socket Connect') == -1) exit(-1);
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
