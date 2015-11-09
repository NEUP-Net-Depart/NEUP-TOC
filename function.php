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
        //echo $errType . " Success\n";
        return 0;
    }
}

function Auth($rawMsg)
{
    $dataArr = explode("#",$rawMsg);
    $salt = "VOID001mengmengda!!!";
    $sectok = $dataArr[3];
    $timestamp = $dataArr[2];
    $md5sum = md5($timestamp.$salt);
    if($md5sum != $sectok) return false;
    return true;
}

function needCompile($varr)
{
    $COMPILE_LANG = array("C","C++","Java");
    foreach ($COMPILE_LANG as $lang)
    {
        if($varr == $lang)
            return true;
    }
    return false;
}

function SockRead($sock, $length = 0)
{
    $len = 0;
    $msg = "";
    $tmpstr = "";
    //echo 'Resource Socket No.' . $sock ."\n";
    while (true)
    {
        $tmpstr = socket_read($sock,1);
        $msg = $msg . $tmpstr;
        $offset = 0;
        $len++;
        if(($offset = strpos($msg,"##VOID##SOCK_OVER##")) != FALSE || $offset === 0)              //Recv this means conversation complete
        {
            $msg = substr($msg,0, $offset);
            break;
        }
    }
    return $msg;
}


function SockWrite($sock, $msg)
{
    socket_write($sock, $msg);
    socket_write($sock, "##VOID##SOCK_OVER##");
}
