<?php

namespace Drupal\smile\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\smile\SmileInterface;

/**
 * Defines the Smile entity.
 *
 *
 * @ContentEntityType(
 *   id = "smile",
 *   label = @Translation("Smile entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\smile\Entity\Controller\SmileListBuilder",
 *     "views_data" = "Drupal\smile\SmileViewsData",
 *     "form" = {
 *       "add" = "Drupal\smile\Form\SmileForm",
 *       "edit" = "Drupal\smile\Form\SmileForm",
 *       "delete" = "Drupal\smile\Form\SmileDeleteForm",
 *     },
 *     "access" = "Drupal\smile\SmileAccessControlHandler",
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "smile",
 *   admin_permission = "administer smile entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/smile/{smile}",
 *     "edit-form" = "/smile/{smile}/edit",
 *     "delete-form" = "/smile/{smile}/delete",
 *     "collection" = "/smile/list"
 *   },
 *   field_ui_base_route = "smile.smile_settings",
 * )
 *
 */
class Smile extends ContentEntityBase implements SmileInterface {


  /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
//    $values += array(
//      'user_id' => \Drupal::currentUser()->id(),
//    );
  }

  /**
   * @inheritDoc
   */
  public function getChangedTime() {
    return $this->get('created')->value;
  }

  /**
   * @inheritDoc
   */
  public function setChangedTime($timestamp) {
    $this->set('changed', $timestamp);
    return $this;
  }


  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Smile entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Smile entity.'))
      ->setReadOnly(TRUE);

    //A title
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name.'))
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['preferred_brand'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Prefered brand'))
      ->setDescription(t('Preferred brand'))
      ->setSettings([
        'allowed_values' => [
          'samsung' => 'samsung',
          'apple' => 'apple',
        ],
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'list_default',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_select',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['products_owned_count'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Products owned count'))
      ->setDescription(t('Products owned count'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'integer',
        'weight' => -2,
      ])->setDisplayOptions('form', [
        'type' => 'number',
        'min' => 0,
        'weight' => -3,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User Name'))
      ->setDescription(t('User Name'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'entity_reference',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of Smile entity.'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Registered'))
      ->setDescription(t('The time that the user was registered.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
