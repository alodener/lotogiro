<?php

namespace Feature;

use App\Models\UsersHasQualifications;
use Tests\TestCase;

class UsersHasQualificationsTest extends TestCase
{
    public function testShouldBeReprocess()
    {
        UsersHasQualifications::reprocess();
        $this->assertTrue(true);
    }
}
