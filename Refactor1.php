<?php

class Product {

    protected $itemPrice = 400;
    protected $quantity  = 2;
    protected $wholeSalePrice = 1000;

    public function getPrice(): float {

        $basePrice = $this->quantity * $this->itemPrice;

        if ($basePrice > $this->wholeSalePrice) {

            $discountFactor = 0.95;

        } else {

            $discountFactor = 0.98;
        }

        return $basePrice * $discountFactor;

    }

}

echo (new Product)->getPrice();