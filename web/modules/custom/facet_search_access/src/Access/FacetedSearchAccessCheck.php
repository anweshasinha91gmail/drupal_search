<?php

declare(strict_types=1);

namespace Drupal\facet_search_access\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use \Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;

/**
 * Checks if passed parameter matches the route configuration.
 *
 * Usage example:
 * @code
 * foo.example:
 *   path: '/example/{parameter}'
 *   defaults:
 *     _title: 'Example'
 *     _controller: '\Drupal\facet_view_search_access_check\Controller\FacetViewSearchAccessCheckController'
 *   requirements:
 *     _foo: 'some value'
 * @endcode
 */
final class FacetedSearchAccessCheck implements AccessInterface {

  /**
   * Access callback.
   *
   * @DCG
   * Drupal does some magic when resolving arguments for this callback. Make
   * sure the parameter name matches the name of the placeholder defined in the
   * route, and it is of the same type.
   * The following additional parameters are resolved automatically.
   *   - \Drupal\Core\Routing\RouteMatchInterface
   *   - \Drupal\Core\Session\AccountInterface
   *   - \Symfony\Component\HttpFoundation\Request
   *   - \Symfony\Component\Routing\Route
   * Below allow access only if account has permission
   */
  public function access(AccountInterface $account): AccessResult {
    return AccessResult::allowedIfHasPermission($account, 'search recipes');
  }

}
