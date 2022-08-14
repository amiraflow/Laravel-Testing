<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CurrencyService;

class CurrencyTest extends TestCase
{
 
    public function test_convert_usd_to_eur_successful()
    {
        $this->assertEquals(98,  (new CurrencyService())->convert(100, 'usd', 'eur'));
    }

    public function test_convert_usd_to_gbp_return_zero()
    {
        $this->assertEquals(0,  (new CurrencyService())->convert(100, 'usd', 'gbp'));
    }
}
