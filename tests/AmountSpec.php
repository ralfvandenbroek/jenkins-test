<?php

use PHPUnit\Framework\TestCase;

class AmountSpec extends TestCase
{
    public function testGivenSameAmountThenEqual(): void {
        $a = new Amount(2.0);
        $b = new Amount(2.0);
        $this->assertEquals($a, $b);
    }

    public function testWhenAddAmountThenCorrectTotal(): void {
        $a = new Amount(2.0);
        $b = new Amount(3.0);
        $sum = $a->add($b);
        $this->assertEquals(new Amount(5.0), $sum);
    }

    public function testGivenEqualWhenCompareThenZero(): void {
        $a = new Amount(2.0);
        $b = new Amount(2.0);
        $cmp = $a->compare($b);
        $this->assertEquals(0, $cmp);
    }

    public function testGivenGreaterWhenCompareThenOne(): void {
        $a = new Amount(3.0);
        $b = new Amount(2.0);
        $cmp = $a->compare($b);
        $this->assertEquals(1, $cmp);
    }

    public function testGivenLesserWhenCompareThenMinusOne(): void {
        $a = new Amount(2.0);
        $b = new Amount(3.0);
        $cmp = $a->compare($b);
        $this->assertEquals(-1, $cmp);
    }

    public function testGivenDifferentCurrencyThenNotEqual(): void {
        $a = new Amount(2.0, "EUR");
        $b = new Amount(2.0, "USD");
        $this->assertNotEquals($a, $b);
    }

    public function testWhenAddAmountThenCorrectCurrency(): void {
        $a = new Amount(2.0, "USD");
        $b = new Amount(3.0, "USD");
        $sum = $a->add($b);
        $this->assertEquals(new Amount(5.0, "USD"), $sum);
    }

    public function testWhenAddCurrencyThenConvertAmount(): void {
        $a = new Amount(2.0, "EUR");
        $b = new Amount(3.0, "USD");
        $sum = $a->add($b, ["EUR/USD" => 1.2]);
        $this->assertEquals(new Amount(4.5, "EUR"), $sum);
    }

    #[Test]
    public function testWhenAddReversedThenConvertAmount(): void {
        $a = new Amount(2.0, "EUR");
        $b = new Amount(3.0, "USD");
        $sum = $a->add($b, ["USD/EUR" => 1.2]);
        $this->assertEquals(new Amount(5.6, "EUR"), $sum);
    }

    public function testWhenAddInconvertibleThenException(): void {
        $a = new Amount(2.0, "EUR");
        $b = new Amount(3.0, "USD");
        $this->expectException(DomainException::class);
        $a->add($b);
    }

    public function testWhenCompareCurrencyThenConvertAmount(): void {
        $a = new Amount(2.0, "EUR");
        $b = new Amount(3.0, "USD");
        $cmp = $a->compare($b, ["EUR/USD" => 1.5]);
        $this->assertEquals(0, $cmp);
    }

    public function testWhenCompareReversedThenConvertAmount(): void {
        $a = new Amount(2.0, "EUR");
        $b = new Amount(3.0, "USD");
        $cmp = $a->compare($b, ["USD/EUR" => 0.5]);
        $this->assertEquals(1, $cmp);
    }

    public function testWhenCompareInconvertibleThenException(): void {
        $a = new Amount(2.0, "EUR");
        $b = new Amount(3.0, "USD");
        $this->expectException(DomainException::class);
        $a->compare($b);
    }
}