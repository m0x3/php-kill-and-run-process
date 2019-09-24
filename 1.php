<?php

$script = "fr/server.py";

$python_path = array(
  'win' => array(
    "python",
    "%userprofile%\AppData\Local\Programs\Python\Python37\python.exe",
    "C:\python36\python.exe",
  ),
  'nix' => array(
    "python3",
    "/usr/bin/python3",
    "/usr/bin/env python3",
    "/usr/local/bin/python3",
  )
);

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo "This is a server using Windows!\n";

    $script = str_replace('/', '\\', $script); //у виндовс обратные слеши в путях

    foreach($python_path['win'] as $pypath) {
      if (strtoupper(substr(shell_exec($pypath.' -V'), 0, 8)) == 'PYTHON 3') {

        foreach(explode("\n", shell_exec('cscript find.vbs')) as $proc) {
            $pid = 0;
            if(stripos($proc, $script) !== false) {
                $pid = explode(";", $proc)[0];

                if($pid) shell_exec('taskkill /PID '.$pid.' /F');
            }
        }
        //var_dump(shell_exec('START /B /W "" "'.$pypath.'" "'.$script.'"')); //ждем ответ
        //shell_exec('start /b "" "'.$pypath.'" "'.$script.'"'); //не ждем ответ
        pclose(popen('start /B "" "'.$pypath.'" "'.$script.'"', "r")); //не ждем ответ

        break; //выходим если нашли интерпретатор
      }
    }
}
else {
    echo "This is a server using Nix!\n";

    foreach($python_path['nix'] as $pypath) {
      if (strtoupper(substr(shell_exec($pypath.' -V'), 0, 8)) == 'PYTHON 3') {

        shell_exec('pkill -9 -f "'.$script.'"');

        //var_dump(shell_exec('"'.$pypath.'" "'.$script.'"')); //ждем ответ
        shell_exec('nohup "'.$pypath.'" "'.$script.'" </dev/null >/dev/null 2>&1 &'); //не ждем ответ

        break; //выходим если нашли интерпретатор
      }
    }
}
