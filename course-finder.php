<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use Raider\CourseFinder\CourseFinder;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client(['base_uri' => 'https://www.alura.com.br/']);
$crawler = new Crawler();

$finder = new  CourseFinder($client, $crawler);
$courses = $finder->finder('/cursos-online-programacao/php');

foreach ($courses as $course) {
    showCourseName($course);
}