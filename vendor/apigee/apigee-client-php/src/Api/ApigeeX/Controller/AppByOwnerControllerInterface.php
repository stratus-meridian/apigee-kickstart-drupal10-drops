<?php

/*
 * Copyright 2023 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Apigee\Edge\Api\ApigeeX\Controller;

use Apigee\Edge\Api\Management\Controller\AttributesAwareEntityControllerInterface;
use Apigee\Edge\Controller\EntityControllerInterface;
use Apigee\Edge\Controller\EntityCrudOperationsControllerInterface;
use Apigee\Edge\Controller\StatusAwareEntityControllerInterface;

/**
 * Describes common operations for appgroup and developer apps.
 */
interface AppByOwnerControllerInterface extends
    AttributesAwareEntityControllerInterface,
    EntityControllerInterface,
    EntityCrudOperationsControllerInterface,
    StatusAwareEntityControllerInterface
{
    /**
     * Returns a list of entities from Apigee Edge.
     *
     * It only returns maximum 100 entities in case of developer- and appgroup
     * apps. Check the related API documentation for more information.
     * Use implementation of the AppControllerInterface to load _all_ apps
     * from Apigee Edge.
     *
     * @return \Apigee\Edge\Entity\EntityInterface[]
     */
    public function getEntities(): array;
}
