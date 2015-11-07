<?php

require_once('function.php');

$actionList = new actionQueue();
$socketQueue = new actionQueue();
//$actionList->initQueue();
$socketQueue->initQueue();
$mainSocket = SocketOpen();

while(1)
{
    if($)
    if($resSocket = socket_accept($mainSocket) && $resSocket != FALSE)
    {
        $socketQueue->push($resSocket);
    }
    if($socketQueue->empty() == FALSE)
    {
        $currentSocket = $socketQueue->pop();
        $rawMsg = scoket_read($currentSocket, 1000);
        if(Auth($rawMsg) == true)
        {
            $actionObj = ParseMsg($rawMsg);
            $actionObj->Compile();
            $retval = $actionObj->Execute();
            $errMsg = "";
            $outMsg = "";
            if($retvall != 0)
            {
                $errMsg = fetchError();
            }
            else
            {
                $outMsg = fetchOutput();
            }
            //Send Msg back to client
        }
        else
        {

        }

    }
}
