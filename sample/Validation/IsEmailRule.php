<?php namespace Sample\Validation;

/**
 * Copyright 2015-2017 info@neomerx.com
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

use Limoncello\Validation\Blocks\ProcedureBlock;
use Limoncello\Validation\Contracts\Blocks\ExecutionBlockInterface;
use Limoncello\Validation\Contracts\Execution\ContextInterface;
use Limoncello\Validation\Execution\BlockReplies;
use Limoncello\Validation\Rules\BaseRule;

/**
 * @package Sample
 */
class IsEmailRule extends BaseRule
{
    /**
     * @inheritdoc
     */
    public function toBlock(): ExecutionBlockInterface
    {
        return (new ProcedureBlock([self::class, 'execute']))->setProperties($this->getStandardProperties());
    }

    /**
     * @param mixed            $value
     * @param ContextInterface $context
     *
     * @return array
     */
    public static function execute($value, ContextInterface $context): array
    {
        $isValidEmail = is_string($value) === true && filter_var($value, FILTER_VALIDATE_EMAIL) !== false;

        return $isValidEmail === true ?
            BlockReplies::createSuccessReply($value) :
            BlockReplies::createErrorReply($context, $value, CustomErrorCodes::IS_EMAIL);
    }
}
