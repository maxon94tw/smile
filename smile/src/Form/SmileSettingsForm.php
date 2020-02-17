<?php

namespace Drupal\smile\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SmileSettingsForm.
 */
class SmileSettingsForm extends FormBase {
  /**
   * Get From ID.
   */
  public function getFormId() {
    return 'smile_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['smile_settings']['#markup'] = 'Settings form for Smile. Manage field settings here.';
    return $form;
  }

}
