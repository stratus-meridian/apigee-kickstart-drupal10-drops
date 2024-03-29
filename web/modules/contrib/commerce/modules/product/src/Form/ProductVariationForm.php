<?php

namespace Drupal\commerce_product\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\entity\Form\EntityDuplicateFormTrait;

/**
 * Defines the add/edit/duplicate form for product variations.
 */
class ProductVariationForm extends ContentEntityForm {

  use EntityDuplicateFormTrait;

  /**
   * {@inheritdoc}
   */
  public function getEntityFromRouteMatch(RouteMatchInterface $route_match, $entity_type_id) {
    if ($route_match->getRawParameter('commerce_product_variation') !== NULL) {
      $entity = $route_match->getParameter('commerce_product_variation');
    }
    else {
      /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
      $product = $route_match->getParameter('commerce_product');
      /** @var \Drupal\commerce_product\Entity\ProductVariationTypeInterface $product_variation_type */
      $product_variation_type = $route_match->getParameter('commerce_product_variation_type');
      $values = [
        'type' => $product_variation_type->id(),
        'product_id' => $product->id(),
      ];
      $entity = $this->entityTypeManager->getStorage('commerce_product_variation')->create($values);
    }

    return $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $save_return = $this->entity->save();
    $this->postSave($this->entity, $this->operation);
    $this->messenger()->addMessage($this->t('Saved the %label variation.', ['%label' => $this->entity->label()]));
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $save_return;
  }

}
