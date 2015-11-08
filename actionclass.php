<?php
error_reporting(E_ALL);
class simpleResultClass
{
    public $resultno;
    public $resultStr;
}
class actionClass
{
    static $execCompiler = [
        "C" => "gcc sandbox/%s -O2 -lm -o sandbox/%s.out 2>sandbox/cerr.txt",
        "C++11" => "g++ -std=c++11 -O2 sandbox/%s -o sandbox/%s.out 2>sandbox/cerr.txt",
        "C++" => "g++ -O2 sandbox/%s -o sandbox/%s.out 2>sandbox/cerr.txt",
        "Java" => "javac sandbox/%s -o sandbox/%s 2>sandbox/cerr.txt",
        "python" => "python sandbox/%s 2>sandbox/cerr.txt",
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
            $this->execFileName = $this->codeFileName . "out";
            exec($cmdStr);
            $runResObj = new simpleResultClass();
            if(($errFileSize = filesize("sandbox/cerr.txt")) == 0)
            {
                $runResObj->resultno = 0;
                $runResObj->resultStr = $resStr;
            }
            else
            {
                $runResObj->resultno = -1;
                $fff = fopen("sandbox/cerr.txt", "r");
                $resStr = fread($fff, $errFileSize);
                $runResObj->resultStr = $resStr;
            }
        }
        return $runResObj;
    }

    public function Run()
    {
        if(needCompile($this->languageType))    //If this is a lang need to be compiled
        {
            //$cmdStr = "./" . $this->execFileName . " < " . $inputFileName . " 1> " . $this->codeFileName . "out.txt"
            $cmdStr = "sandbox/a.out" . " < " . "sandbox/".$this->inputFileName ./* " 1> sandbox/out.txt"  .*/ " 2> sandbox/err.txt ";
        }
        else
        {
            $cmdStr = $execCompiler[$this->languageType] . " " . $this->codeFileName . " < " . $this->inputFileName . "  2> err.txt";
        }
        echo "Running .. command is " . $cmdStr . "\n";
        /*$resStr = */
        exec($cmdStr,$resStr);
        var_dump($resStr);
        $resStr = join("\n",$resStr);
        echo "Server result:".$resStr;
        //Read the output file and return the result
        $runResObj = new simpleResultClass();
        if(($errFileSize = filesize("sandbox/err.txt")) == 0)
        {
            $runResObj->resultno = 0;
            $runResObj->resultStr = $resStr;
        }
        else
        {
            $runResObj->resultno = -1;
            $fff = fopen("sandbox/err.txt", "r");
            $resStr = fread($fff, $errFileSize);
            $runResObj->resultStr = $resStr;
        }
        return $runResObj;

    }
}


?>
