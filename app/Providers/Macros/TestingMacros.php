<?php

namespace App\Providers\Macros;

use Closure;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;

/**
 * @mixin TestResponse
 */
class TestingMacros
{
    public function assertJsonStructureMissing(): Closure
    {
        return function (array $structure = null, $responseData = null) {
            if (is_null($structure)) {
                return $this->assertJson($this->json());
            }

            if (is_null($responseData)) {
                $responseData = $this->decodeResponseJson();
            }

            foreach ($structure as $key => $value) {
                if (is_array($value) && $key === '*') {
                    /** @noinspection PhpUndefinedMethodInspection */
                    Assert::assertInternalType('array', $responseData);

                    foreach ($responseData as $responseDataItem) {
                        /** @noinspection PhpExpressionResultUnusedInspection, PhpMethodParametersCountMismatchInspection */
                        $this->assertJsonStructureMissing($structure['*'], $responseDataItem);
                    }
                } elseif (is_array($value)) {
                    Assert::assertArrayHasKey($key, $responseData);

                    /** @noinspection PhpMethodParametersCountMismatchInspection */
                    $this->assertJsonStructureMissing($value, $responseData[$key]);
                } else {
                    Assert::assertArrayNotHasKey($value, $responseData);
                }
            }

            return $this;
        };
    }
}
