<?php

namespace Raider\CourseFinder;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class CourseFinder
{
    private ClientInterface $httpClient;
    private Crawler $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function finder(string $url): array
    {
        $response = $this->httpClient->request('GET', $url);

        $html = $response->getBody();
        $this->crawler->addHtmlContent($html);

        $elementCourses = $this->crawler->filter('.card-curso__nome');
        $courses = [];

        foreach ($elementCourses as $elementCourse) {
            $courses[] = $elementCourse->textContent;
        }
        return $courses;
    }
}
