
<?php

namespace Drupal\smile\Plugin\Action;

use Drupal\Core\Session\AccountInterface;
use Drupal\views_bulk_operations\Action\ViewsBulkOperationsActionBase;

/**
 * @Action(
 *   id = "smile_custom_action",
 *   label = @Translation("Unset value"),
 *   type = "",
 *   confirm = TRUE
 * )
 */
class SmileAction extends ViewsBulkOperationsActionBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {

    if ($entity->hasField('products_owned_count')) {
      $entity->products_owned_count->value = 0;
      $entity->save();
    }

    // Don't return anything for a default completion message, otherwise return translatable markup.
    return $this->t('Count unseted');
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    if ($object->getEntityType() === 'smile') {
      $access = $object->access('update', $account, TRUE)
        ->andIf($object->status->access('edit', $account, TRUE));
      return $return_as_object ? $access : $access->isAllowed();
    }

    return TRUE;
  }

}