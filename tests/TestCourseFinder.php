<?php

namespace Raider\CourseFinder\Tests;

use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Raider\CourseFinder\CourseFinder;
use Symfony\Component\DomCrawler\Crawler;

class TestCourseFinder extends TestCase
{
    private ClientInterface $httpClientMock;
    private string $url = 'test-url';

    protected function setUp(): void
    {
        $html = <<<HTML
    <html>
        <body>
            <span class="card-curso__nome">Course Test 1</span>
            <span class="card-curso__nome">Course Test 2</span>
            <span class="card-curso__nome">Course Test 3</span>
        </body>
    </html>
HTML;

        $stream = $this->createMock(StreamInterface::class);
        $stream
            ->expects($this->once())
            ->method('__toString')
            ->willReturn($html);

        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($stream);

        $httpClient = $this
            ->createMock(ClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', $this->url)
            ->willReturn($response);

        $this->httpClientMock = $httpClient;
    }

    public function testSearcherShouldReturnCourses()
    {
        $crawler = new Crawler();
        $searcher = new CourseFinder($this->httpClientMock, $crawler);
        $courses = $searcher->finder($this->url);

        $this->assertCount(3, $courses);
        $this->assertEquals('Course Test 1', $courses[0]);
        $this->assertEquals('Course Test 2', $courses[1]);
        $this->assertEquals('Course Test 3', $courses[2]);
    }

}