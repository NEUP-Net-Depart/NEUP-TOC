<?php

class actionQueue
{
    private $_queueArr;
    public $len;
    public function initQueue()
    {
        $this->_queueArr = array();
        $this->len = 0;
    }
    public function push($actionItem)
    {
        array_push($this->_queueArr, $actionItem);
        $this->len++;
    }
    public function pop()
    {
        return array_shift($this->_queueArr);
        if($this->len > 0) $this->len--;
    }
    public function length()
    {
        return $this->len;
    }
	public function isempty()
	{
		if($this->len == 0) return true;
		return false;
	}
}


 ?>
