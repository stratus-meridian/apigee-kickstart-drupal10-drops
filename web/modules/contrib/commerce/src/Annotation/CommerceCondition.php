<?php

namespace Drupal\commerce\Annotation;

use Drupal\Component\Annotation\Plugin;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Defines the condition plugin annotation object.
 *
 * Plugin namespace: Plugin\Commerce\Condition.
 *
 * @Annotation
 */
class CommerceCondition extends Plugin {

  use StringTranslationTrait;

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The condition label.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

  /**
   * The condition display label.
   *
   * Shown in the condition UI when enabling/disabling a condition.
   * Defaults to the main label.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $display_label;

  /**
   * The condition description.
   *
   * Shown in the condition UI when enabling/disabling a condition.
   * Defaults to empty string.
   *
   * @var \Drupal\Core\Annotation\Translation|null
   *
   * @ingroup plugin_translatable
   */
  public $description;

  /**
   * The condition category.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $category;

  /**
   * The condition entity type ID.
   *
   * This is the entity type ID of the entity passed to the plugin during
   * evaluation. For example: 'commerce_order'.
   *
   * @var string
   */
  public $entity_type;

  /**
   * The parent entity type ID.
   *
   * This is the entity type ID of the entity that embeds the conditions.
   * For example: 'commerce_promotion'.
   *
   * When specified, a condition will only be available on that entity type.
   *
   * @var string
   */
  public $parent_entity_type;

  /**
   * The condition weight.
   *
   * Used when sorting the condition list in the UI.
   *
   * @var int
   */
  public $weight = 0;

  /**
   * Constructs a new CommerceCondition object.
   *
   * @param array $values
   *   The annotation values.
   */
  public function __construct(array $values) {
    if (empty($values['display_label'])) {
      $values['display_label'] = $values['label'];
    }
    if (empty($values['category'])) {
      $values['category'] = $this->t('Other');
    }
    parent::__construct($values);
  }

}
