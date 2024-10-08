<?php

namespace App\Service;

use TusPhp\Cache\FileStore;
use TusPhp\Tus\Server as TusServer;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TusService
{
    protected ParameterBagInterface $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @throws \ReflectionException
     */
    public function getServer(): TusServer
    {
        $server = new TusServer();

        $cache = new FileStore($this->params->get('kernel.project_dir'). '/var/tus-cache/');

        $server
            ->setApiPath('/tus') // tus server endpoint.
            ->setCache($cache)
            ->setUploadDir($this->params->get('kernel.project_dir') . '/var/uploads'); // uploads dir.

        return $server;
    }
}