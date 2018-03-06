<?php

namespace Drupal\d8_cache\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Cache\Cache;
use Drupal\user\Entity\User;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

/**
 * Example: Expires cache in 10 seconds.
 */
  public function cacheMaxAge() {
    return [
      '#markup' => t('Temporary by 10 seconds @time', ['@time' => time()]),
      '#cache' => [
        'max-age' => 10,
      ]
    ];
  }

  /**
   * Example: Invalidates cache permanently!
   */
  public function cacheMaxAgePermanent() {
    return [
      '#markup' => t('WeKnow is the coolest @time', ['@time' => time()]),
      '#cache' => [
        'max-age' => \Drupal\Core\Cache\Cache::PERMANENT,
      ]
    ];
  }

  /**
   * Example: An array of one or more cache context IDs.
   * These are converted to a final value depending on the request.
   * (For instance, 'user' is mapped to the current user's ID.)
   * In this example we are invalidating cache from any query parameter ""
   * @see: https://www.drupal.org/docs/8/api/cache-api/cache-contexts
   */
  public function cacheContextsByUrl() {
    return [
      '#markup' => t('WeKnow is the coolest @time', ['@time' => time()]),
      '#cache' => [
        'contexts' => ['url.query_args'],
      ]
    ];
  }

  /**
   * Example: An array of one or more cache context IDs.
   * These are converted to a final value depending on the request.
   * (For instance, 'user' is mapped to the current user's ID.)
   * In this example we are invalidating cache from query parameter "your_query_param".
   * @see: https://www.drupal.org/docs/8/api/cache-api/cache-contexts
   */
  public function cacheContextsByUrlParam() {
    return [
      '#markup' => t('WeKnow is the coolest @time', ['@time' => time()]),
      '#cache' => [
        'contexts' => ['url.query_args:your_query_param’'],
      ]
    ];
  }

  /**
   * Example: Use of cache tags = dependency data!
   */
  public function cacheTags() {
    $userName = \Drupal::currentUser()->getAccountName();
    $cacheTags = User::load(\Drupal::currentUser()->id())->getCacheTags();
    return [
      '#markup' => t('WeKnow is the coolest! Do you agree @userName ?', ['@userName' => $userName]),
      '#cache' => [
        // We need to use entity->getCacheTags() instead of hardcoding "user:2"(where 2 is uid) or trying to memorize each pattern.
        'tags' => $cacheTags,
      ]
    ];
  }

  /**
   * Example: Cache multiple array elements using 'keys' from cache property.
   */
  public function cacheTree() {

    /**
     * Use the #cache property of elements in a render array to specify the cacheability of that item. The value of the #cache property is an array with the following, optional, key-value pairs:
    keys: An array of one or more keys that identify the element. If 'keys' is set, the cache ID is created automatically from these keys.
    tags: An array of one or more cache tags identifying the data this element depends on.
    contexts: An array of one or more cache context IDs. These are converted to a final value depending on the request. (For instance, 'user' is mapped to the current user's ID.)
    max-age: A time in seconds. Zero seconds means it is not cacheable. \Drupal\Core\Cache\Cache::PERMANENT means it is cacheable forever.
    bin: Specify a cache bin to cache the element in. Default is 'default'.
     */

    /**
     * BE CAREFUL:
     * IF we set any type of cache "max-age, context, tags" it invalidates cache
     * from children to TOP - if many caches in a render array with multiple elements and children
     * then just listen to the last one declared!
     * to avoid above use "keys"
     *   It does protect against other cache invalidation from (siblings render array elements or children).
     *   BE CAREFUL if 2 keys are given the same! then it will replace it after cached
     *   so a key MUST be unique.
     */
    return [
      'permanent' => [
        '#markup' => 'PERMANENT: weKnow is the coolest ' . time() . '<br>',
        '#cache' => [
          'max-age' => Cache::PERMANENT,
        ],
      ],
      'message' => [
        '#markup' => 'Just a message! <br>',
        '#cache' => [
        ]
      ],
      'parent' => [
        'child_a' => [
          '#markup' => '--->Temporary by 20 seconds ' . time() . '<br>',
          '#cache' => [
            'max-age' => 20,
          ],
        ],
        'child_b' => [
          '#markup' => '--->Temporary by 10 seconds ' . time() . '<br>',
          '#cache' => [
            'max-age' => 10,
          ],
        ],
      ],
      'contexts_url' => [
        '#markup' => 'Contexts url - ' . time(),
        '#cache' => [
          'contexts' => ['url.query_args'],
        ]
      ]
    ];
  }

  /**
   * Example: Cache multiple array elements using 'keys' from cache property.
   */
  public function cacheTreeKeys() {
    /**
     * Use the #cache property of elements in a render array to specify the cacheability of that item. The value of the #cache property is an array with the following, optional, key-value pairs:
    keys: An array of one or more keys that identify the element. If 'keys' is set, the cache ID is created automatically from these keys.
    tags: An array of one or more cache tags identifying the data this element depends on.
    contexts: An array of one or more cache context IDs. These are converted to a final value depending on the request. (For instance, 'user' is mapped to the current user's ID.)
    max-age: A time in seconds. Zero seconds means it is not cacheable. \Drupal\Core\Cache\Cache::PERMANENT means it is cacheable forever.
    bin: Specify a cache bin to cache the element in. Default is 'default'.
     */

    /**
     * BE CAREFUL:
     * IF we set any type of cache "max-age, context, tags" it invalidates cache
     * from children to TOP - if many caches in a render array with multiple elements and children
     * then just listen to the last one declared!
     * to avoid above use "keys"
     *   It does protect against other cache invalidation from (siblings render array elements or children).
     *   BE CAREFUL if 2 keys are given the same! then it will replace it after cached
     *   so a key MUST be unique.
     */
    return [
      'permanent' => [
        '#markup' => 'PERMANENT: weKnow is the coolest ' . time() . '<br>',
        '#cache' => [
          'max-age' => Cache::PERMANENT,
          'keys' => ['d8_cache_permament']
        ],
      ],
      'message' => [
        '#markup' => 'Just a message! <br>',
        '#cache' => [
          'keys' => ['d8_cache_time']
        ]
      ],
      'parent' => [
        'child_a' => [
          '#markup' => '--->Temporary by 20 seconds ' . time() . '<br>',
          '#cache' => [
            'max-age' => 20,
            'keys' => ['d8_cache_child_a']
          ],
        ],
        'child_b' => [
          '#markup' => '--->Temporary by 10 seconds ' . time() . '<br>',
          '#cache' => [
            'max-age' => 10,
            'keys' => ['d8_cache_child_b']
          ],
        ],
      ],
      'contexts_url' => [
        '#markup' => 'Contexts url - ' . time(),
        '#cache' => [
          'contexts' => ['url.query_args'],
          'keys' => ['d8_cache_contexts_url']
        ]
      ]
    ];
  }

}
