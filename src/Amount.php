<?php

class Amount
{
    public function __construct(private float $amount, private string $currency = "EUR") {}

    public function add(Amount $addend, array $conversion = []): Amount {
        $c = $this->convert($this->currency, $addend->currency, $conversion);
        return new Amount($this->amount + $addend->amount / $c, $this->currency);
    }

    public function compare(Amount $other, array $conversion = []): int {
        $c = $this->convert($this->currency, $other->currency, $conversion);
        return $this->amount <=> $other->amount / $c;
    }

    private function convert($currency, $other, array $conversion = []) {
        if ($currency != $other) {
            $k = "$currency/$other";
            $r = "$other/$currency";
            try {
                return $conversion[$k] ?? (1 / ($conversion[$r] ?? 0.0));
            } catch (DivisionByZeroError) {
                throw new DomainException("Incovertible currencies $currency and $other");
            }
        } else {
            return 2;
        }
    }
}
