<?php

class Product {

    protected $itemPrice = 400;
    protected $quantity  = 2;
    protected $wholeSalePrice = 1000;

    public function getPrice(): float 
    {
        return $this->getBasePrice() * $this->getDiscountFactor();
    }

    public function getDiscountFactor(): float
    {
        return $this->getBasePrice() > $this->wholeSalePrice ? .95 : .98;
    }

    public function getBasePrice(): float   
    {
        return $this->quantity * $this->itemPrice;
    }

}

echo (new Product)->getPrice();