<?php
function and_op($command)
{
    $command = preg_replace('/\s+/', '', $command);
    $coms = explode("+", $command);
    foreach ($coms as $char)
    {
        if (substr($char, 0, 1) == "!")
        {
            $char = substr($char, 1, 2);
            if ($GLOBALS['alpha'][$char] != 0)
                return (0);
        }
        else if ($char == '0')
            return (0);
        else if ($GLOBALS['alpha'][$char] == 0)
            return (0);
    }
    return (1);
}
function or_op($command)
{
    $coms = explode("|", trim($command));
    foreach ($coms as $value)
    {
        if (and_op(trim($value)) == 1)
            return (1);
    }
    return (0);
}
function xor_op($coms)
{
    $new = array();
    if (count($coms) == 1)
        return (or_op($coms[0]));
    for ($i = 0; $i < count($coms); $i++) {
        if ($i == count($coms) - 1)
        {}
        else if (or_op($coms[$i]) == or_op($coms[$i + 1]))
            $new[] = 0;
        else
            $new[] = 1;
    }
    if (count($new) == 1)
        return $new[0];
    else
        return (xor_op($new));
}
function implies($value)
{
    $commands = explode("=>", $value);
    $coms = explode("^", $commands[0]);
    $ret = xor_op($coms);
    if (!strpos($commands[1],"(") && !strpos($commands[1],"^"))
    {
        if (strpos($commands[1],"|"))
        {
        }
        else {
            $commands[1] = preg_replace('/\s+/', '', $commands[1]);
            $coms = explode("+", $commands[1]);
            foreach ($coms as $value)
            {
                echo "$value\n";
                if (substr($value, 0, 1) == "!")
                {
                    $value = substr($value, 1, 2);
                    if ($GLOBALS['alpha'][$value] == 1)
                    {
                        if ($ret == 1)
                            $GLOBALS['alpha'][$value] = 0;
                        else
                            $GLOBALS['alpha'][$value] = 1;
                        echo "here";
                    }
                    else
                    {
                        if ($ret == 1)
                            $GLOBALS['alpha'][$value] = 1;
                        else
                            $GLOBALS['alpha'][$value] = 0;
                    }
                }
                else
                {
                    $GLOBALS['alpha'][$value] = $ret;
                }
            }
        }
    }
    else
    {
        echo "Error: Syntax Error" . PHP_EOL;
        exit(0);
    }
}
function solve($value)
{
    echo "!!!!"  . strpos($commands[0],"(");
    if (strpos($commands[1],"("))
    {
        echo "Helloooooooooooooooooooooooooooooooooooo!";
        echo strpos($commands[1],"(") . ":" . strpos($commands[1],"(") . PHP_EOL;
    }
    echo "implies return " . implies($value) . PHP_EOL;
}
function algo() {
    foreach ($GLOBALS['rules'] as $value) {
        echo $value . PHP_EOL;
        //brackets
        solve($value);
        var_dump($GLOBALS['alpha']);
    }
}
?>