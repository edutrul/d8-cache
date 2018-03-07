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
    if ($cache = \Drupal::cache()->get('d8_cache_data_operation')) {
      $dummyData = $cache->data;
      kint($dummyData);
    }
    else {
      $dummyData = time();
      // The last parameter is TAGS which have to be added in array format.
      \Drupal::cache()->set('d8_cache_data_operation', $dummyData, time() + 80, ['user:1']);
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

  public function getDummyData() {
    $dummy = 0;
    for ($i = 0; $i < 1000; $i++ ) {
      $dummy++;
      for ($j = 0; $j < 40000; $j++) {
        $dummy++;
      }
    }

    return $dummy + time();
  }

}
