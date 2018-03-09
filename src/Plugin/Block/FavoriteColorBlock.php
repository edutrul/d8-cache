<?php

namespace Drupal\d8_cache\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\user\Entity\User;

/**
 * Provides a 'FavoriteColorBlock' block.
 *
 * @Block(
 *  id = "favorite_color_block",
 *  admin_label = @Translation("Favorite color block"),
 * )
 */
class FavoriteColorBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $current_user_id = \Drupal::currentUser()->id();
    // Load user object.
    $user = User::load($current_user_id);
    $favorite_color = $user->field_user_favorite_color->value;
    $build = [
      '#markup' => 'User favorite color is ' . $favorite_color .  time(),
    ];
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(
      parent::getCacheContexts(),
      ['user_favorite_color']
    );
  }

}
