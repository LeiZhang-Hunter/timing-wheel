--TEST--
phpsciter load frame
--FILE--
<?php

$pid = pcntl_fork();
if ($pid == 0)
{
    ($oSciter = new PHPSciter());
    var_dump($oSciter->getVersion());
    var_dump($oSciter->setResourcePath('file://' . __DIR__ . '/res/'));
    var_dump($oSciter->setWindowTitle('hello'));
    var_dump($oSciter->setWindowFrame(100, 100, 100 + 800 + 1, 100 + 600 + 1));
    var_dump($oSciter->loadFile('default.htm'));

    $oSciter->setOption(PHPSciter::SCITER_SET_SCRIPT_RUNTIME_FEATURES,
    PHPSciter::ALLOW_FILE_IO | PHPSciter::ALLOW_SOCKET_IO | PHPSciter::ALLOW_EVAL |
                                   PHPSciter::ALLOW_SYSINFO);

    exit(3);
    $oSciter->run(PHPSciter::SW_TITLEBAR | PHPSciter::SW_RESIZEABLE | PHPSciter::SW_MAIN | PHPSciter::SW_ENABLE_DEBUG
    |PHPSciter::SW_CONTROLS);
    exit(0);
} else {
    sleep(2);
    pcntl_waitpid($pid, $status, WNOHANG);
    if (pcntl_wexitstatus($status) > 0)
    {
        exit(pcntl_wexitstatus($status));
    }
    $r = posix_kill($pid, 15);

}

?>
--EXPECT--
true