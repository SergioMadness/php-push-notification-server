#!/usr/local/bin/php -q
<?php

/**
 * Check dependencies
 */
if (!extension_loaded('sockets')) {
    syslog(LOG_CRIT, 'This example requires sockets extension (http://www.php.net/manual/en/sockets.installation.php)');
    exit(-1);
}
if (!extension_loaded('pcntl')) {
    syslog(LOG_CRIT, 'This example requires PCNTL extension (http://www.php.net/manual/en/pcntl.installation.php)');
    exit(-1);
}

require_once 'vendor/autoload.php';

error_reporting(E_ALL);

/* Позволяет скрипту ожидать соединения бесконечно. */
set_time_limit(0);

/* Включает скрытое очищение вывода так, что мы получаем данные
 * как только они появляются. */
ob_implicit_flush();

function socket_read_all($sock)
{
    $result = '';
    while ($buf = @socket_read($sock, 1024)) {
        if (trim($buf) == "") {
            break;
        }
        $result .= $buf;
    }
    return $result;
}

$validator = new \professionalweb\services\RequestService();
$signer = new \professionalweb\services\JWTResponseSigner();
$pushServiceFactory = new \professionalweb\PushNotificationFactory();

//$address = \professionalweb\Config::get('ip');
$port = \professionalweb\Config::get('port');
echo "Start\n";

//if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
//    $m = "Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error());
//    syslog(LOG_CRIT, $m);
//}
//echo "Created\n";
//if (socket_bind($sock, $address, $port) === false) {
//    echo $m = "Не удалось выполнить socket_bind(): причина: " . socket_strerror(socket_last_error($sock));
//    syslog(LOG_CRIT, "Не удалось выполнить socket_bind(): причина: " . socket_strerror(socket_last_error($sock)));
//}
//echo "Bind\n";
//if (socket_listen($sock, 5) === false) {
//    echo $m = "Не удалось выполнить socket_listen(): причина: " . socket_strerror(socket_last_error($sock));
//    syslog(LOG_CRIT, $m);
//}

if (($sock = $sock = socket_create_listen($port)) === false) {
    $m = "Не удалось выполнить socket_create_listen(): причина: " . socket_strerror(socket_last_error());
    echo $m;
    syslog(LOG_CRIT, $m);
}

do {
    if (!is_resource($sock) || ($msgsock = socket_accept($sock)) === false) {
        echo $m = "Не удалось выполнить socket_accept(): причина: " . socket_strerror(socket_last_error($sock));
        syslog(LOG_CRIT, "Не удалось выполнить socket_accept(): причина: " . socket_strerror(socket_last_error($sock)));
        break;
    }

    echo "Accept\n";

    $pid = pcntl_fork();

    if ($pid == -1) {
        $errorMessage = 'Не удалось выполнить pcntl_fork(): причина: ' . pcntl_get_last_error() . "\n";
        syslog(LOG_CRIT, $errorMessage);
    } elseif ($pid) {
        continue;
    }

    try {
        do {
            if ($msgsock === null) {
                break;
            }
            if (false === ($buf = socket_read_all($msgsock))) {
                echo $m = "Не удалось выполнить socket_read(): причина: " . socket_strerror(socket_last_error($msgsock));
                syslog(LOG_ALERT, $m);
                break;
            }
            echo "Readed: " . $buf . "\n";

            if (!$buf = trim($buf)) {
                echo $m = "Empty message\n";
                socket_write($msgsock, $m, strlen($m));
                break;
            }

            if (!$validator->validate($buf)) {
                $errorMessage = "Bad request\n";
                socket_write($msgsock, $errorMessage, strlen($errorMessage));
                break;
            }

            echo "Validated\n";

            $decodedMessage = $validator->decode($buf);
            if (empty($decodedMessage)) {
                echo $m = "Empty message\n";
                socket_write($msgsock, $m, strlen($m));
                break;
            }
            print_r($decodedMessage);
            $response = $signer->sign($pushServiceFactory->create((string)$decodedMessage['platform'])->push($decodedMessage['tokens'], $decodedMessage['bundleId'], $decodedMessage['message'], $decodedMessage['title']??'', $decodedMessage['sound']??'', (array)$decodedMessage['extraParams']));
            echo 'Response: ' . $response . "\n";
            socket_write($msgsock, $response, strlen($response));
            echo "Response sended";
        } while (true);
    } catch (Throwable $ex) {
        $m = 'Error: ' . $ex->getMessage();
        echo $m;
        syslog(LOG_ALERT, $m);
    }
    if ($msgsock !== null) {
        socket_close($msgsock);
    }
} while (true);

socket_close($sock);