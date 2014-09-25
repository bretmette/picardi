<?php namespace Picardi\Controllers;

class HomeController extends BaseController {

	public function index()
	{
		$phrase_count = 0;
		
		$client = new \GuzzleHttp\Client();
		$response = $client->get('http://www.chakoteya.net/NextGen/episodes.htm');

		if ($response->getBody()) {
			$crawler = new \Symfony\Component\DomCrawler\Crawler((string)$response->getBody());
			
			$links = $crawler->filter('a')->each(function ($node, $i) {
				return $node->attr('href');
			});
			
			if (is_array($links) && count($links)) {
				foreach ($links as $link) {
					if (preg_match('/^\d{1,3}.htm$/', $link) === 1) {
						$response = $client->get('http://www.chakoteya.net/NextGen/' . $link);

						if ($response->getBody()) {
							$body = (string)$response->getBody();
							
							$phrase_count += substr_count(strtolower($body), 'make it so');
						}
					}
				}
			}
			
			return $phrase_count;
		}
	}

}
