<?php

/*
 * Copyright 2018 Google LLC
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

namespace Apigee\Edge\Api\Monetization\NameConverter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

abstract class NameConverterBase implements NameConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($propertyName): string
    {
        if ($externalPropertyName = array_search($propertyName, $this->getExternalToLocalMapping())) {
            return $externalPropertyName;
        }

        return $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($propertyName): string
    {
        if (array_key_exists($propertyName, $this->getExternalToLocalMapping())) {
            return $this->getExternalToLocalMapping()[$propertyName];
        }

        return $propertyName;
    }

    abstract protected function getExternalToLocalMapping(): array;
}
