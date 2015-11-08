<?php
require_once('actionclass.php');
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
    $port = 2333;
    $mainSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    if (checkOK ($mainSocket, 'Socket Create') == -1) exit (-1);
    $resBindResult = socket_bind($mainSocket, $ip, $port);
    if (checkOK($resBindResult, 'Sck bind') == -1) exit (-1);
    $resListenResult = socket_listen($mainSocket, 300);
    if (checkOK($resListenResult, 'Sck listen') == -1) exit (-1);

    echo "Listening " . $ip . ':'. $port . "....\n";

    return $mainSocket;
}


function ParseMsg($rawMsg)
{
    $dataArr = explode("#", $rawMsg);
    $actionObj = new actionClass;
    $actionObj->codeFileName = $dataArr[0];
    $actionObj->languageType = $dataArr[1];
    $actionObj->timestamp = $dataArr[2];
    $actionObj->secureToken = $dataArr[3];
    $actionObj->inputFileName = $actionObj->codeFileName.".in";

    return $actionObj;
}

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

function Auth($rawMsg)
{
	return true;
}

function needCompile($varr)
{
	return true;
}
