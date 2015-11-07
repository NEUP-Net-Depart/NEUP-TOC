<?php

/*
 * Function: Listen the msg from client and return to backend
 * @return return the rawMsg from Client
 * if no msg get , return null
 */
function Listen()
{

}

/*
 * Open the raw Socket , and prepare for Listen
 *
 */

function SocketOpen()
{
    $ip = 'localhost';
    $port = 2666;
    $mainSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    if (checkOK ($mainSocket, 'Socket Create') == -1) exit (-1);
    $resBindResult = socket_bind($mainSocket, $ip, $port);
    if (checkOK($resBindResult, 'Sck bind') == -1) exit (-1);
    $resListennResult = socket_listen($mainSocket, 300);
    if (checkOK($resListenResult, 'Sck listen') == -1) exit (-1);

    echo "Listening " . $ip . ':'. $port . "....\n";

    return $mainSocket;
}
