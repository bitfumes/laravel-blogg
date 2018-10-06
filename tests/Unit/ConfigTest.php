<?php

namespace Bitfumes\Blogg\Tests\Unit;

use Bitfumes\Blogg\Tests\TestCase;

class ConfigTest extends TestCase
{
    /** @test */
    public function package_can_set_pagination_value()
    {
        app()['config']->set('blogg.paginate', 10);
        $this->assertEquals(app()['config']['blogg.paginate'], 10);
    }
}
