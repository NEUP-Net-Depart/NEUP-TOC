<?php
error_reporting(E_ALL);
require_once('function.php');
require_once('queue.php');
require_once('actionclass.php');

$socketQueue = new actionQueue();
$socketQueue->initQueue();
$mainSocket = SocketOpen();
//socket_set_nonblock($mainSocket);
socket_set_option($mainSocket, SOL_SOCKET, SO_REUSEADDR, 1);

while(TRUE)
{
    if($socketQueue->len > 5)//Maximum count
        continue;               //Do not accept create new socket
    //if($resSocket = socket_accept($mainSocket) && $resSocket != FALSE)
	$resSocket = socket_accept($mainSocket);
    //echo "Listening\n";
	if($resSocket != FALSE)
    {
        $socketQueue->push($resSocket);
        //socket_set_nonblock($resSocket);
    }
    if($socketQueue->isempty() == FALSE)
    {
        $currentSocket = $socketQueue->pop();
        $rawMsg = socket_read($currentSocket, 1000);
        if(Auth($rawMsg) == true)
        {
            $actionObj = ParseMsg($rawMsg);
            //var_dump($actionObj);
            $simpleResultObj = $actionObj->Compile();
            if($simpleResultObj->resultno != 0)
            {
                echo "Compile Error";
                socket_write($currentSocket, "##ERR", 100);
                socket_write($currentSocket, $simpleResultObj->resultStr, 99999);
            }
            else
            {
                echo "Compile OK";
                socket_write($currentSocket, "###OK", 100);
                $simpleResultObj = $actionObj->Run();

                //Send Msg back to client
                if($simpleResultObj->resultno == 0)
                {
                    socket_write($currentSocket, "###OK");
                    socket_write($currentSocket, $simpleResultObj->resultStr, strlen($simpleResultObj->resultStr));
                }
                else
                {
                    socket_write($currentSocket, "##ERR");
                    socket_write($currentSocket, $simpleResultObj->resultStr, strlen($simpleResultObj->resultStr));
                }
            }
        }
        else
        {
            $getaddr = "";
            $getport = "";
            socket_getsockname($currentSocket, $getaddr, $getport);
            echo "Invalid request from $getaddr:$getport";
            socket_write($currentSocket, "FATAL");
        }
    }
}
