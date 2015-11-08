<?php

class simpleResultClass
{
    public $resultno;
    public $resultStr;
}
class actionClass
{
    static $execCompiler = [
        "C" => "gcc sandbox/%s -O2 -lm -o sandbox/%s.out",
        "C++" => "g++ -std=c++11 -O2 sandbox/%s -o sandbox/%s.out",
        "Java" => "javac sandbox/%s -o sandbox/%s",
        "python" => "python sandbox/%s",
    ];
    public $codeFileName;
    public $inputFileName;
    public $secureToken;
    public $languageType;
    public $execFileName;
    public function Compile()
    {
        if(needCompile($this->languageType))    //If this is a lang need to be compiled
        {
            //$cmdStr = $execCompiler[$this->languageType] . $codeFileName;
            echo "Lang type = " . $this->languageType;
            var_dump(actionClass::$execCompiler);
            echo "The exec Command is " . actionClass::$execCompiler[$this->languageType]. "\n";
            $cmdStr = sprintf(actionClass::$execCompiler[$this->languageType], $this->codeFileName, "a");
            echo "Debug : Command is " . $cmdStr . "\n";
            $this->execFileName = $codeFileName . "out";
            exec($cmdStr);
        }
    }

    public function Run()
    {
        if(needCompile($this->languageType))    //If this is a lang need to be compiled
        {
            //$cmdStr = "./" . $this->execFileName . " < " . $inputFileName . " 1> " . $this->codeFileName . "out.txt"
            $cmdStr = "sandbox/a.out" . " < " . "sandbox/".$this->inputFileName . " 1> sandbox/out.txt"  . " 2> sandbox/err.txt ";
        }
        else
        {
            $cmdStr = $execCompiler[$this->languageType] . " " . $this->codeFileName . " < " . $this->inputFileName . " 1> out.txt 2> err.txt";
        }
        $resStr = exec($cmdStr);
        //Read the output file and return the result
        $runResObj = new simpleResultClass();
        if(($errFileSize = filesize("err.txt")) == 0)
        {
            $runResObj->resultno = 0;
            $runResObj->resultStr = $resStr;
        }
        else
        {
            $runResObj->resultno = -1;
            $fff = fopen("err.txt", "r");
            $resStr = fread($fff, $errFileSize);
            $runResObj->resultStr = $resStr;
        }
        return $runResObj;

    }
}


?>
