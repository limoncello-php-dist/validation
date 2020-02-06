<?php declare(strict_types=1);

namespace Limoncello\Validation\Rules\Comparisons;

/**
 * Copyright 2015-2020 info@neomerx.com
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use Limoncello\Validation\Contracts\Errors\ErrorCodes;
use Limoncello\Validation\Contracts\Execution\ContextInterface;
use Limoncello\Validation\I18n\Messages;
use function assert;
use function call_user_func;
use function in_array;
use function is_scalar;

/**
 * @package Limoncello\Validation
 */
final class ScalarInValues extends BaseOneValueComparision
{
    /**
     * @param mixed $scalars
     */
    public function __construct(array $scalars)
    {
        assert(call_user_func(function () use ($scalars) {
            foreach ($scalars as $scalar) {
                assert(static::isValidType($scalar) === true);
            }

            return true;
        }));

        parent::__construct(
            $scalars,
            ErrorCodes::SCALAR_IN_VALUES,
            Messages::SCALAR_IN_VALUES,
            $scalars
        );
    }

    /**
     * @inheritdoc
     */
    public static function compare($value, ContextInterface $context): bool
    {
        assert(static::isValidType($value) === true);
        $result = is_scalar($value) === true && in_array($value, static::readValue($context));

        return $result;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    private static function isValidType($value): bool
    {
        return is_scalar($value) === true || $value === null;
    }
}
