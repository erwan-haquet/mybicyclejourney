<?php

namespace Tests\Application\App\ContentManagement\Ui\Pages\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    public function testHomepageShouldBeReachable(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->expectExceptionCode('400');
    }
}
