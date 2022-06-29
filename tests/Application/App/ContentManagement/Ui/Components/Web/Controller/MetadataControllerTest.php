<?php

namespace Tests\Application\App\ContentManagement\Ui\Components\Web\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Application\App\ContentManagement\Domain\Website\Model\Page\PageFactory;
use Tests\Application\App\ContentManagement\Domain\Website\Model\Page\RouteFactory;

class MetadataControllerTest extends WebTestCase
{
    private ?EntityManagerInterface $entityManager;
    private ?KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();

        $this->entityManager = $this->client->getKernel()->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testIsAccessible(): void
    {
        $this->client->request('GET', '/components/metadata', [
            'encodedPath' => urlencode('/')
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testRenderTitle(): void
    {
        $title = "A super basic title";
        
        $page = PageFactory::new(
            title: $title,
            route: RouteFactory::new(
                path: '/'
            )
        );

        $this->entityManager->persist($page);
        $this->entityManager->flush();

        $this->client->request('GET', '/components/metadata', [
            'encodedPath' => urlencode('/')
        ]);
        
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame($title);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;

        $this->client = null;
    }
}
