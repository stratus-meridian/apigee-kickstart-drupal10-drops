<?php

/**
 * @file
 * Copyright 2022 Google Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public
 * License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc., 51
 * Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 */

namespace Drupal\apigee_freeform_doc\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\views\Views;

/**
 * Provides a confirmation form before clearing out the references in views.
 */
class ConfirmRemoveViewsReferencesForm extends ConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'apigee_freeform_doc_confirm_remove_views_references';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to remove references of Free-form in views before uninstallation of the module?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('system.modules_uninstall');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $view = Views::getView('apigee_api_catalog');
    if (is_object($view)) {
      $display = $view->getDisplay();

      $filters = $view->display_handler->getOption('filters');
      if ($filters['type']['value']['freeform_doc']) {
        unset($filters['type']['value']['freeform_doc']);
      }
      if (isset($filters['type_1']) && $filters['type_1']['value']['freeform_doc']) {
        unset($filters['type_1']['value']['freeform_doc']);
      }
      $view->display_handler->overrideOption('filters', $filters);

      $view->save();

      $this->messenger()->addStatus($this->t('Updating Views - API Catalog'));
    }

    $view = Views::getView('api_catalog_admin');
    if (is_object($view)) {
      $display = $view->getDisplay();

      $filters = $view->display_handler->getOption('filters');
      if ($filters['type']['value']['freeform_doc']) {
        unset($filters['type']['value']['freeform_doc']);
      }
      if (isset($filters['type_1']) && $filters['type_1']['value']['freeform_doc']) {
        unset($filters['type_1']['value']['freeform_doc']);
      }
      $view->display_handler->overrideOption('filters', $filters);

      $view->save();

      $this->messenger()->addStatus($this->t('Updating Views - API Catalog Admin'));
    }

    $form_state->setRedirectUrl($this->getCancelUrl());
  }

}
