<?php

namespace Tests\Application\App\ContentManagement\Ui\Components\Web\Controller;

use App\Supporting\Domain\I18n\Model\Locale;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
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

    public function testMissingPathParameterReturnsNoContent(): void
    {
        $this->client->request('GET', '/components/metadata');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    public function testUnreachablePageReturnsNoContent(): void
    {
        $this->client->request('GET', '/components/metadata', [
            'path' => urlencode('/definitely-not-a-page')
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    public function testTitleIsRendered(): void
    {
        $title = "A super basic title";
        
        $page = PageFactory::new(
            title: $title,
            route: RouteFactory::new(path: '/')
        );

        $this->entityManager->persist($page);
        $this->entityManager->flush();

        $this->client->request('GET', '/components/metadata', ['path' => urlencode('/')]);
        
        $this->assertPageTitleSame($title);
    }

    public function testMetaDescriptionIsRendered(): void
    {
        $description = "A super basic description";
        
        $page = PageFactory::new(
            description: $description,
            route: RouteFactory::new(path: '/')
        );

        $this->entityManager->persist($page);
        $this->entityManager->flush();

        $this->client->request('GET', '/components/metadata', ['path' => urlencode('/')]);
        
        $metaDescription = $this->client->getCrawler()
            ->filter('meta[name="description"]')
            ->eq(0)
            ->attr('content');
        
        $this->assertEquals($description, $metaDescription);
    }

    public function testLocalAlternatesAreRenderedBasedOnTheRouteName(): void
    {
        $routeName = "homepage";
        
        $english = PageFactory::new(
            locale: Locale::from('EN'),
            route: RouteFactory::new(name: $routeName, path: '/', url:'https://localhost/')
        );
        $this->entityManager->persist($english);

        $french = PageFactory::new(
            locale: Locale::from('FR'),
            route: RouteFactory::new(name: $routeName, path: '/fr/', url:'https://localhost/fr/')
        );
        $this->entityManager->persist($french);

        $japan = PageFactory::new(
            locale: Locale::from('JP'),
            route: RouteFactory::new(name: $routeName, path: '/jp/', url:'https://localhost/jp/')
        );
        $this->entityManager->persist($japan);
        $this->entityManager->flush();

        $this->client->request('GET', '/components/metadata', ['path' => urlencode('/')]);
        
        $englishNode = $this->client->getCrawler()->filter('link[hreflang="EN"][href="https://localhost/"]');
        $this->assertEquals(1, $englishNode->count());
        
        $japanNode = $this->client->getCrawler()->filter('link[hreflang="JP"][href="https://localhost/jp/"]');
        $this->assertEquals(1, $japanNode->count());
        
        $frenchNode = $this->client->getCrawler()->filter('link[hreflang="FR"][href="https://localhost/fr/"]');
        $this->assertEquals(1, $frenchNode->count());
    }

    public function testOpenGraphUrlIsSameHasCanonicalUrl(): void
    {
        $url = "https://localhost/a-fancy-url";
        
        $page = PageFactory::new(
            route: RouteFactory::new(path: '/fancy-path', url: $url)
        );
        $this->entityManager->persist($page);
        $this->entityManager->flush();

        $this->client->request('GET', '/components/metadata', [
            'path' => urlencode('/fancy-path')
        ]);

        $ogUrl = $this->client->getCrawler()
            ->filter('meta[property="og:url"]')
            ->eq(0)
            ->attr('content');
        
        $this->assertEquals($url, $ogUrl);
    }

    public function testOpenGraphLocaleIsSameHasPage(): void
    {
        $locale = Locale::from('NL');
        
        $page = PageFactory::new(
            locale: $locale,
            route: RouteFactory::new(path: '/nl/')
        );
        $this->entityManager->persist($page);
        $this->entityManager->flush();
        
        $this->client->request('GET', '/components/metadata', ['path' => urlencode('/nl/')]);

        $language = $this->client->getCrawler()
            ->filter('meta[property="og:locale"]')
            ->eq(0)
            ->attr('content');
        
        $this->assertEquals($locale->language(), $language);
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
