<?php

namespace Drupal\commerce_checkout\Event;

/**
 * Defines events for the checkout module.
 */
final class CheckoutEvents {

  /**
   * Name of the event fired when the customer completes checkout.
   *
   * @Event
   *
   * @see \Drupal\commerce_order\Event\OrderEvent
   */
  const COMPLETION = 'commerce_checkout.completion';

  /**
   * Name of the event fired when the customer registers at the end of checkout.
   *
   * @Event
   *
   * @see \Drupal\commerce_checkout\Event\CheckoutCompletionRegisterEvent
   */
  const COMPLETION_REGISTER = 'commerce_checkout.completion_register';

  /**
   * Name of the event fired when the customer registers during checkout.
   *
   * @Event
   *
   * @see \Drupal\commerce_checkout\Event\RegisterDuringCheckoutEvent
   */
  const CHECKOUT_REGISTER = 'commerce_checkout.checkout_register';

}
