<?php

namespace Drupal\recipe_statistics_command\Commands;

use Drush\Commands\DrushCommands;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\search_api\IndexInterface;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\taxonomy\TermInterface;

class RecipeStatsCommands extends DrushCommands {

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs the command object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct();
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Show recipe search statistics.
   *
   * @command recipe:stats
   * @aliases rs
   * @description Shows total recipes indexed, most common ingredient, and top 5 tags.
   */
  public function stats() {

    // Fetch the content index entity.
    $index = $this->entityTypeManager
      ->getStorage('search_api_index')
      ->load('content_index');

    if (!$index instanceof IndexInterface) {
      $this->logger()->error('Recipe Search API index not found.');
      return;
    }

    $query = $index->query();
    $query->range(0, 1000);
    $results = $query->execute();
    $items = $results->getResultItems();

    $ingredient_count = [];
    $tag_count = [];
    $tag_tids = [];

    // loop through the items to fetch the fields.
    foreach ($items as $item) {
      $fields = $item->getFields();
      // If field_ingredient is set then loop through the values
      if (isset($fields['field_ingredients'])) {
        foreach ($fields['field_ingredients']->getValues() as $value) {
          $ingredient = strtolower(trim($value));
          $ingredient_count[$ingredient] = ($ingredient_count[$ingredient] ?? 0) + 1;
        }
      }
      //If field_tags is set then loop through the values
      if (isset($fields['field_tags'])) {
        foreach ($fields['field_tags']->getValues() as $tid) {
          $tag_tids[(int) $tid] = (int) $tid;
        }
      }
    }

    // As tags give tids fetch the label of the tids at one go
    $terms = $this->entityTypeManager
      ->getStorage('taxonomy_term')
      ->loadMultiple($tag_tids);

    // Second pass: count tags by label.
    foreach ($items as $item) {
      $fields = $item->getFields();

      if (isset($fields['field_tags'])) {
        foreach ($fields['field_tags']->getValues() as $tid) {
          if (isset($terms[$tid]) && $terms[$tid] instanceof TermInterface) {
            $label = strtolower($terms[$tid]->label());
            $tag_count[$label] = ($tag_count[$label] ?? 0) + 1;
          }
        }
      }
    }

    arsort($ingredient_count);
    arsort($tag_count);

    /**
     * Cached the result for 1 week .
     */
    $cache_metadata = new CacheableMetadata();
    $cache_metadata->setCacheTags([
      'node_list',
      'taxonomy_term_list',
      'search_api_index:content_index',
    ]);
    $cache_metadata->setCacheContexts([]);
    $cache_metadata->setCacheMaxAge(604800);

    // Log cache metadata for visibility / reuse.
    $this->logger()->debug('Recipe stats cache metadata', [
      'tags' => $cache_metadata->getCacheTags(),
      'max-age' => $cache_metadata->getCacheMaxAge(),
    ]);

    // Output.
    $this->output()->writeln('');
    $this->output()->writeln('📊 Recipe Search Statistics');
    $this->output()->writeln('---------------------------');
    $this->output()->writeln('Total recipes indexed: ' . count($items));
    $this->output()->writeln('Most common ingredient: ' . (key($ingredient_count) ?: 'N/A'));
    $this->output()->writeln('Top 5 tags:');

    foreach (array_slice(array_keys($tag_count), 0, 5) as $tag) {
      $this->output()->writeln(' - ' . $tag);
    }
  }

}
