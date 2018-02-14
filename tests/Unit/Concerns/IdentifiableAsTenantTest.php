<?php

/*
 * This file is part of the tenancy/tenancy package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see http://laravel-tenancy.com
 * @see https://github.com/tenancy
 */

namespace Tenancy\Tests\Unit\Concerns;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use Tenancy\Concerns\AllowsTenantIdentification;
use Tenancy\Contracts\IdentifiableAsTenant;
use Tenancy\Tests\TestCase;

class IdentifiableAsTenantTest extends TestCase
{
    protected $class;

    protected function afterSetUp()
    {
        $this->class = new class() extends Model {
            use AllowsTenantIdentification;
        };
    }

    /**
     * @test
     */
    public function has_required_methods()
    {
        $has = collect((new ReflectionClass($this->class))->getMethods())->pluck('name');
        $needs = collect((new ReflectionClass(IdentifiableAsTenant::class))->getMethods())->pluck('name');

        $this->assertCount(
            $needs->count(),
            $has->intersect($needs),
            AllowsTenantIdentification::class.' does not implement all required interface methods from '.IdentifiableAsTenant::class
        );
    }
}
