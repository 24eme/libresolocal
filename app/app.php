<?php

require __DIR__ . '/bootstrap.php';

$f3 = require __DIR__ . '/../vendor/fatfree/lib/base.php';


$f3->route('GET /',
    function() {
        echo View::instance()->render('../view/index.html.php');
    }
);

$f3->route('GET /search',
    function($f3) {
        $search = new Search($f3->get("GET.q"));
        $urls = $search->getUrls();

        $commerce = new Commerce();
        foreach($urls as $url) {
            $commerce->addPage($url);
        }
        $commerce->save();

        $f3->reroute('@commerce(@key='.$commerce->getKey().')');
    }
);

$f3->route('GET @commerce: /commerce/@key',
    function($f3, $params) {
        $f3->set('commerce', Commerce::find($params['key']));

        echo View::instance()->render('../view/commerce.html.php');
    }
);

$f3->run();
