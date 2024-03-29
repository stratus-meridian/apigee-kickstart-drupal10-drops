<?php

/*
 * Copyright 2021 Google Inc.
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

namespace Drupal\apigee_m10n\Entity\ParamConverter;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Http\Exception\CacheableNotFoundHttpException;
use Drupal\Core\ParamConverter\EntityConverter;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\Core\ParamConverter\ParamNotConvertedException;
use Symfony\Component\Routing\Route;

/**
 * Parameter converter for up-casting purchased plan entity IDs to full objects.
 *
 * {@inheritdoc}
 */
class XRatePlanConverter extends EntityConverter implements ParamConverterInterface {

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\ParamConverter\ParamNotConvertedException
   */
  public function convert($value, $definition, $name, array $defaults) {
    if (!($xproduct_id = $defaults['xproduct']) || empty($xproduct_id)) {
      $cache_metadata = new CacheableMetadata();
      // If there is no product bundle set the URL is invalid.
      throw new CacheableNotFoundHttpException($cache_metadata->setCacheContexts(['url']), 'Invalid product X.');
    }

    try {
      /** @var \Drupal\apigee_m10n\Entity\Storage\XRatePlanStorageInterface $storage */
      $storage = $this->entityTypeManager->getStorage('xrate_plan');
      // The rate plan value should already be validated so just load it.
      $entity = $storage->loadById($xproduct_id, $value);
      $this->entityTypeManager->getStorage('xproduct')->loadProducts($xproduct_id);
    }
    catch (EntityStorageException $ex) {
      throw new ParamNotConvertedException('Unable to load rate plan X.', 404, $ex);
    }

    return $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {
    // This only applies to purchased_plan entities.
    return (parent::applies($definition, $name, $route) && $definition['type'] === 'entity:xrate_plan');
  }

}
