<?php

namespace Drupal\d8_cache\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Cache\Cache;

/**
 * Class CacheController.
 */
class CacheController extends ControllerBase {

  /**
   * It is better to render array caches if it is possible!
   * else you have to se use cache->set and cache->get
   */
  public function cacheMethods() {
    $invalidate = \Drupal::request()->query->get('invalidate');
    if ($invalidate) {
      \Drupal::cache()->invalidate('d8_cache_data_operation');
    }
    if ($cache = \Drupal::cache()->get('d8_cache_data_operation')) {
      $dummyData = $cache->data;
      $dummyData .= print_r($cache, TRUE);
      kint($dummyData);
    }
    else {
      $dummyData = time();
      // The last parameter is TAGS which have to be added in array format.
      \Drupal::cache()->set('d8_cache_data_operation', $dummyData, time() + 8, ['user:1']);
    }
    return [
      '#markup' => t('Dummy data @dummyData', ['@dummyData' => $dummyData]),
      '#cache' => [
        // I am setting max-age to 0 (NO CACHE) for testing purposes
        // since by default it is always -1! and above code will not be invalidated
        // and this is for demo purposes!
        'max-age' => 0,
      ]
    ];
  }

  /**
   * Example: addCacheableDependency(render array and config).
   */
  public function cacheDependencyObject() {
    $renderer = \Drupal::service('renderer');

    $config = \Drupal::config('system.site');

    $build = [
      '#markup' => t('Hi, welcome back to @site!', [
        '@site' => $config->get('name') . print_r($config->getCacheTags(), TRUE),
      ])
    ];
    // Merges cache dependency to render array (when merging it
    // asks for ->getCacheTags(), ->getContexts(), ->getMaxAge() and does a merge!.
    $renderer->addCacheableDependency($build, $config);

    return $build;
  }

}
