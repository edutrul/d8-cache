<?php

namespace Drupal\d8_cache\CacheContext;

use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\user\Entity\User;


/**
* Class UserFavoriteColorCacheContext.
*/
class UserFavoriteColorCacheContext implements CacheContextInterface {


  /**
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;
  
  public function __construct(AccountProxyInterface $current_user) {
    $this->currentUser = $current_user;
  }
  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    return t('User favorite color cache context');
  }
  /**
   * {@inheritdoc}
   */
  public function getContext() {
    $current_user_id = $this->currentUser->getAccount()->id();
    // Load user object.
    $user = User::load($current_user_id);
    $favorite_color = $user->field_favorite_color->value;
    return $favorite_color;
  }

  /**
  * {@inheritdoc}
  */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
