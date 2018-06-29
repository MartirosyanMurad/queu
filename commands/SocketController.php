<?php
/**
 * Created by PhpStorm.
 * User: Aram
 * Date: 3/10/2018
 * Time: 12:38 PM
 */

namespace app\commands;


namespace console\controllers;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use app\servers\SocketServer; //не забудьте поменять, если отличается

class SocketController extends  \yii\console\Controller
{
    public function actionStartSocket($port=8080)
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SocketServer()
                )
            ),
            $port
        );
        $server->run();
    }
}