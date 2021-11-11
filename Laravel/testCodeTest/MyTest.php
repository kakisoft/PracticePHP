<?php
/*
tests\MyTest.php
*/
namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Facades\Allocation;
use App\Repositories\ShippingInstructionRepository;

class MyTest extends TestCase
{
    use DatabaseTransactions;
/*
php artisan test tests/myTest.php
php artisan test tests/myTest.php --group=testing
*/

    /**
     * @group testing
     */
    public function testAllocate()
    {
        $allocation = app()->make(Allocation::class);
        $allocation->allocate([1,2], 2);




        $this->assertTrue(true);
    }

    /**
     * group testing
     */
    public function testGetShippingInstructionForAllocation()
    {
        $allocation = app()->make(Allocation::class);
        // $allocation->getShippingInstructionForAllocation(1,2);

        // $allocation->reallocate($reallocationTargets, $shipperId);
        // $allocation->save();

        $shippingInstructionRepository = app()->make(ShippingInstructionRepository::class);
        // $array01 = $shippingInstructionRepository->getShippingInstructionForAllocation(2,[1,2,3,4]);
        $array01 = $shippingInstructionRepository->getShippingInstructionForAllocation(2,[1,2]);

        echo "111";

        \Log::info($array01);


        $this->assertTrue(true);
    }

}
