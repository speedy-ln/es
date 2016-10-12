<?php
if ($argc == 2)
{
    if (file_exists($argv[1]))
    {
        $file = fopen($argv[1], "r");
        $rules = array();
        while (!feof($file))
        {
            $line = fgets($file);
            $line = trim($line);
            if ($line != "")
            {
                if ($line[0] == '#')
                    ;
                else if ($line[0] == '=')
                {
                    if (strpos($line, '#'))
                        $facts = substr($line, 1, strpos($line, '#'));
                }
                else if ($line[0] == '?')
                {
                    if (strpos($line, '#'))
                        $qu = substr($line, 1, strpos($line, '#'));
                }
                else
                {
                    if (strpos($line, '#'))
                        $line = substr($line, 0, strpos($line, '#'));
                    $line = preg_replace('/\s+/', '', $line);
                    if (strpos($line, "<=>") || strpos($line, "=>"))
                    {
                        if (strpos($line, "<=>"))
                            $array = explode("<=>", $line);
                        else if (strpos($line, "=>"))
                            $array = explode("=>", $line);
                    }
                    else
                    {
                        echo "Syntax error on: " . $line;
                        exit(0);
                    }
                    $i = 0;
                    $check = 1;
                    $bracket = 0;
                    while (isset($array[0][$i]))
                    {
                        if ($array[0][$i] == '(')
                            $bracket++;
                        else if ($array[0][$i] == ')')
                            $bracket--;
                        if (ctype_upper($array[0][$i]) || ($array[0][$i] == '!' && ctype_upper($array[0][$i + 1])) && $check == 1)
                            $check = 0;
                        else if (($array[0][$i] == '+' || $array[0][$i] == '|' || $array[0][$i] == '^') && $check == 0)
                            $check = 1;
                        else
                        {
                            echo "1Syntax error on: " . $line;
                            exit(0);
                        }
                        if ($array[0][$i] == '!')
                            $i++;
                        $i++;
                    }
                    if ($check == 1 && $bracket != 0)
                    {
                        echo "2Syntax error on: " . $line;
                        exit(0);
                    }
                    $i = 0;
                    $check = 1;
                    while (isset($array[1][$i]))
                    {
                        if ($array[0][$i] == '(')
                        {
                            $bracket++;
                            $i++;
                        }
                        else if ($array[0][$i] == ')')
                        {
                            $bracket--;
                            $i++;
                        }
                        if ($check == 1 && ((ctype_upper($array[1][$i])) || ($array[1][$i] == '!' && ctype_upper($array[1][$i + 1]))))
                            $check = 0;
                        else if (($array[1][$i] == '+' || $array[1][$i] == '|') && $check == 0)
                            $check = 1;
                        else
                        {
                            echo "3	Syntax error on: " . $array[1][$i];
                            exit(0);
                        }
                        if ($array[1][$i] == '!')
                            $i++;
                        $i++;
                    }
                    if ($bracket != 0)
                    {
                        echo "3	Syntax error on: " . $array[1][$i];
                        exit(0);
                    }
                    $rules[count($rules)] = $line;
                }
            }

        }
    }
    else
    {
        echo "Failed to open file";
    }
}
else {
    echo "Only one arg";
}
var_dump($rules);
?>