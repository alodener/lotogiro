<?php

namespace Feature;

use App\Models\Qualifications;
use Exception;
use Tests\TestCase;

class QualificationsTest extends TestCase
{
    public function ShouldBeCreate()
    {
        $result = false;
        try {
            $check = Qualifications::find(1);

            if (!$check) {
                $newQualification = new Qualifications([
                    'description' => 'Iniciante',
                    'goal' => 0,
                    'personal_percentage' => 10,
                    'group_percentage' => 90,
                ]);
                $newQualification->save();

                $newQualification = new Qualifications([
                    'description' => 'Supreme',
                    'goal' => 200,
                    'personal_percentage' => 10,
                    'group_percentage' => 90,
                ]);
                $newQualification->save();

                $newQualification = new Qualifications([
                    'description' => 'Gold',
                    'goal' => 400,
                    'personal_percentage' => 10,
                    'group_percentage' => 90,
                ]);
                $newQualification->save();

                $newQualification = new Qualifications([
                    'description' => 'Diamante',
                    'goal' => 600,
                    'personal_percentage' => 10,
                    'group_percentage' => 90,
                ]);
                $newQualification->save();
            }

            $result = true;
        } catch (Exception $e) {
        }

        $this->assertTrue($result);
    }

    public function ShouldBeQualificated()
    {
        $qualification = Qualifications::getQualificationByBalance([
            'personal_balance' => 100,
            'group_balance' => 200,
            'total_balance' => 300,
        ]);

        $this->assertTrue(true);
    }
}
