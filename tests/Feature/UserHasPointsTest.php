<?php

namespace Feature;

use App\Models\User;
use App\Models\UsersHasPoints;
use Exception;
use Tests\TestCase;

class UsersHasPointsTest extends TestCase
{
    public function ShouldBeGeneratePointPositive()
    {
        $result = false;
        $user = User::find(82);
        try {
            UsersHasPoints::generatePoints($user, 200, 'Jogo 01');
            $result = true;
        } catch (Exception $e) {
        }

        $this->assertTrue($result);
    }

    public function ShouldBeGeneratePointNegative()
    {
        $result = false;
        $user = User::find(82);
        try {
            UsersHasPoints::generatePoints($user, 100 * (-1), 'Cancelamento do jogo 01');
            $result = true;
        } catch (Exception $e) {
        }

        $this->assertTrue($result);
    }
}
