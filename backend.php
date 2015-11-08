<?php
error_reporting(E_ERROR);
require_once('function.php');
require_once('queue.php');
require_once('actionclass.php');

$actionList = new actionQueue();
$socketQueue = new actionQueue();
//$actionList->initQueue();
$socketQueue->initQueue();
$mainSocket = SocketOpen();

while(TRUE)
{
    if($socketQueue->len > 5)//Maximum count
        continue;               //Do not accept create new socket
    //if($resSocket = socket_accept($mainSocket) && $resSocket != FALSE)
	$resSocket = socket_accept($mainSocket);
	if($resSocket != FALSE)
    {
        $socketQueue->push($resSocket);
    }
    if($socketQueue->isempty() == FALSE)
    {
        $currentSocket = $socketQueue->pop();
        $rawMsg = socket_read($currentSocket, 1000);
        if(Auth($rawMsg) == true)
        {
            $actionObj = ParseMsg($rawMsg);
            var_dump($actionObj);
            $actionObj->Compile();
            $simpleResultObj = $actionObj->Run();

            //Send Msg back to client
            if($simpleResultObj->resultno == 0)
            {
                socket_write($currentSocket, "OK\n");
                socket_write($currentSocket, "OK\n");
                socket_write($currentSocket, $simpleResultObj->resultStr, strlen($simpleResultObj->resultStr));
            }
            else
            {
                socket_write($currentSocket, "ERR");
                socket_write($currentSocket, $simpleResultObj->resultStr, strlen($simpleResultObj->resultStr));
            }
        }
        else
        {
            socket_write($currentSocket, "FATAL");
        }
    }
}
