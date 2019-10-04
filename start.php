<?php
$python_path = array(
  'win' => array(
    "python",
    "%userprofile%\AppData\Local\Programs\Python\Python37\python.exe",
    "%userprofile%\AppData\Local\Programs\Python\Python37-32\python.exe",
    "C:\python36\python.exe",
  ),
  'nix' => array(
    "python3",
    "/usr/bin/python3",
    "/usr/bin/env python3",
    "/usr/local/bin/python3",
  )
);

$python_found=false;

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { //windows
    $script = str_replace('/', '\\', $script); //у виндовс обратные слеши в путях

    foreach($python_path['win'] as $pypath) {
      if (strtoupper(substr(shell_exec($pypath.' -V'), 0, 8)) == 'PYTHON 3') {

        shell_exec('drivers\\restart.vbs "'.$pypath.'" "'.$script.'"'); //не ждем ответ

        $python_found=true;

        break; //выходим если нашли интерпретатор
      }
    }
}
else { //Nix
    foreach($python_path['nix'] as $pypath) {
      if (strtoupper(substr(shell_exec($pypath.' -V'), 0, 8)) == 'PYTHON 3') {

        shell_exec('pkill -9 -f "'.$script.'"');

        shell_exec('export LC_ALL="en_US.UTF-8"; export PYTHONIOENCODING=utf8; nohup "'.$pypath.'" "'.$script.'" < /dev/null > /dev/null 2>&1 &'); //не ждем ответ
        $python_found=true;

        break; //выходим если нашли интерпретатор
      }
    }
}

if($python_found===false) {
  echo "Python 3 не обнаружен";
  exit();
}

sleep(2);
