<?php


namespace Cuadrik\Shared\Infrastructure\Persistence;


use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticClient
{

    public function instance(): Client
    {
        $hosts = [
//            [
//                'host' => '192.168.1.143',
//                'port' => '9200',
//                'scheme' => 'http',
//                'path' => '/elastic',
//                'user' => 'username',
//                'pass' => 'password!#$?*abc'
//            ],
//            "http://username:password!#$?*abc@192.168.1.143:9200/elastic",
            $_SERVER['ELASTIC_DNS']
        ];

        // full DNS example: http://username:password!#$?*abc@192.168.1.143:9200/elastic
        return ClientBuilder::create()  // Instantiate a new ClientBuilder
        ->setHosts($hosts)              // Set the hosts
        ->build();                      // Build the client object

    }

}