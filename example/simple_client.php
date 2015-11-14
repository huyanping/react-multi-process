<?php
/**
 * @author Jenner <hypxm@qq.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @datetime: 2015/11/13 20:21
 */
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$loop = React\EventLoop\Factory::create();

$dnsResolverFactory = new React\Dns\Resolver\Factory();
$dns = $dnsResolverFactory->createCached('8.8.8.8', $loop);

$connector = new React\SocketClient\Connector($loop, $dns);

for($i=0; $i<1000; $i++){
    $connector->create('127.0.0.1', 4020)->then(function (React\Stream\Stream $stream) use($loop) {
        $stream->on('data', function($data){
            echo $data;
        });
    });
}


$loop->run();