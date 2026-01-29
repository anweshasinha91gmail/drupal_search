<?php

namespace Drupal\ingredient_count_processor\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\search_api\Entity\Index;

/**
 * Field handler to display ingredient count in Search API Views.
 *
 * @ViewsField("recipe_ingredient_count")
 */
class RecipeIngredientCount extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // This is a computed field, so we don't modify the search query.
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    // Get the entity from the Search API result row
    $entity = $values->_item->getOriginalObject()->getValue();

    if ($entity && $entity->hasField('field_ingredients')) {
      return $entity->get('field_ingredients')->count();
    }

    return 0;
  }
}
