<?php

namespace Tests\Application\App\ContentManagement\Ui\Static\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Application\App\ContentManagement\Domain\Website\Model\Page\PageFactory;

class HomepageControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
//        $page = PageFactory::new();
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Share your travel, easier than never.');
    }
}
