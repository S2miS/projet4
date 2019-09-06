<?php
/**
 * Created by PhpStorm.
 * User: Sim25
 * Date: 27/08/2019
 * Time: 15:10
 */

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url, $expectedCode)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $client->getResponse()->getContent();
        $this->assertEquals($expectedCode,$client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        return [
            ['/', 200],
            ['/votre-commande', 200],
            ['/recapitulatif', 404],
            ['/vos-tickets', 404],
            ['/validation', 404],
        ];
    }
}