<?php

namespace Drupal\facet_search_access\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase {

  protected function alterRoutes(RouteCollection $collection) {

    // If the route is view.faceted_search.page_1 add permission 'search recipes'
    if ($route = $collection->get('view.faceted_search.page_1')) {

      // Add permission requirement
      $route->setRequirement('_permission', 'search recipes');
    }
  }

}
