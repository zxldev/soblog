<?php

/*
 +------------------------------------------------------------------------+
 | Phosphorum                                                             |
 +------------------------------------------------------------------------+
 | Copyright (c) 2013-2015 Phalcon Team and contributors                  |
 +------------------------------------------------------------------------+
 | This source file is subject to the New BSD License that is bundled     |
 | with this package in the file docs/LICENSE.txt.                        |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to license@phalconphp.com so we can send you a copy immediately.       |
 +------------------------------------------------------------------------+
*/

namespace Souii\Controllers;

use Souii\Models\Article;
use Phalcon\Http\Response;

/**
 * Class SitemapController
 *
 * @package Phosphorum\Controllers
 */
class SitemapController extends ControllerBase
{

    public function initialize()
    {
        $this->view->disable();
    }

    /**
     * Generate the website sitemap
     *
     */
    public function indexAction()
    {

        $response = new Response();

        $expireDate = new \DateTime();
        $expireDate->modify('+1 day');

        $response->setExpires($expireDate);

        $response->setHeader('Content-Type', "application/xml; charset=UTF-8");

        $sitemap = new \DOMDocument("1.0", "UTF-8");

        $urlset = $sitemap->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $urlset->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

        $url = $sitemap->createElement('url');
        $url->appendChild($sitemap->createElement('loc', 'http://www.souii.com/'));
        $url->appendChild($sitemap->createElement('changefreq', 'daily'));
        $url->appendChild($sitemap->createElement('priority', '1.0'));
        $urlset->appendChild($url);

        $parametersPosts = array(
            'conditions' => 'deleted != 1',
            'columns'    => 'id, slug, modified_at, number_views + ((IF(votes_up IS NOT NULL, votes_up, 0) - IF(votes_down IS NOT NULL, votes_down, 0)) * 4) + number_replies AS karma',
            'order'      => 'karma DESC'
        );
        $posts = Article::find();


        $baseUrl = $this->config->site->url;
        foreach ($posts as $post) {

            $url = $sitemap->createElement('url');
            $href = $baseUrl . '/article/info/' . $post->id;
            $url->appendChild(
                $sitemap->createElement('loc', $href)
            );

            $url->appendChild(
                $sitemap->createElement('priority', '1.0')
            );
            $url->appendChild($sitemap->createElement('lastmod', date_create_from_format('Y-m-d H:i:s',$post->updated_at)->format('Y-m-d\TH:i:s\Z')));
            $urlset->appendChild($url);
        }

        $sitemap->appendChild($urlset);

        $response->setContent($sitemap->saveXML());
        return $response;
    }
}
