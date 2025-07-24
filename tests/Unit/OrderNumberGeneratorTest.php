<?php

namespace Tests\Unit;

use App\Support\OrderNumberGenerator;
use PHPUnit\Framework\TestCase;

class OrderNumberGeneratorTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_that_generator_sequence_works_with_previous_number()
    {
        $current = "AZ999999999";
        $next = "BA000000001";

        $result = OrderNumberGenerator::getNextCode($current);

        $this->assertEquals($next, $result);
    }
}
