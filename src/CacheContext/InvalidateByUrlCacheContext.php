<?php

namespace Drupal\d8_cache\CacheContext;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;

/**
* Class InvalidateByUrlCacheContext.
*/
class InvalidateByUrlCacheContext implements CacheContextInterface {


  /**
   * Constructs a new InvalidateByUrlCacheContext object.
   */
  public function __construct() {
  
  }

  /**
  * {@inheritdoc}
  */
  public static function getLabel() {
    drupal_set_message('Lable of cache context');
  }

  /**
  * {@inheritdoc}
  */
  public function getContext() {
    // Actual logic of context variation will lie here.
  }

  /**
  * {@inheritdoc}
  */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
