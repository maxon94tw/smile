<?php
namespace Drupal\smile;

use Drupal\views\EntityViewsData;

/**
 * Provides the views data for the entity.
 */
class SmileViewsData extends EntityViewsData {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();
    return $data;
  }
}
