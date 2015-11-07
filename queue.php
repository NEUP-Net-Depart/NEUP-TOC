<?php

class actionQueue
{
    private $_queueArr;

    public function initQueue()
    {
        $this->_queueArr = array();
    }
    public function push($actionItem)
    {
        array_push($this->_queueArr, $actionItem);
    }
    public function pop()
    {
        return array_shift($this->_queueArr);
    }
}


 ?>
