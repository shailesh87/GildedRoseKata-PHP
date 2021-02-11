<?php

declare (strict_types = 1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->updateItem($item);
        }
    }

    private function updateItem($item)
    {
        $this->handleQuality($item);
        $this->decreaseSellInIfNotSulfuras($item);
        $this->handleIfExpired($item);
    }

    private function handleQuality($item)
    {
        if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
            $this->decreaseQualityIfItemHasQuality($item);
        } else {
            $this->increaseQualityIncludeBackstagePasses($item);
        }
    }

    private function increaseQualityIncludeBackstagePasses($item)
    {
        if ($item->quality < 50) {
            $item->quality = $item->quality + 1;
            $this->increaseQualityBackstagePasses($item);
        }
    }

    private function increaseQualityBackstagePasses($item)
    {
        if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
            $this->increaseQualityFarToExp($item);
            $this->increaseQualityCloseToExp($item);
        }
    }

    private function increaseQualityCloseToExp($item)
    {
        if ($item->sell_in < 6) {
            $this->increaseQualityIfNotMax($item);
        }
    }

    private function increaseQualityFarToExp($item)
    {
        if ($item->sell_in < 11) {
            $this->increaseQualityIfNotMax($item);
        }
    }

    private function decreaseQualityIfItemHasQuality($item)
    {
        if ($item->quality > 0) {
            $this->decreaseQualityIfItemNotSulfuras($item);
        }
    }

    private function decreaseQualityIfItemNotSulfuras($item)
    {
        if ($item->name != 'Sulfuras, Hand of Ragnaros') {
            $this->decreaseQuality($item);
        }
    }

    private function decreaseSellInIfNotSulfuras($item)
    {
        if ($item->name != 'Sulfuras, Hand of Ragnaros') {
            $this->decreaseSellIn($item);
        }
    }

    private function decreaseSellIn($item)
    {
        $item->sell_in = $item->sell_in - 1;
    }

    private function handleIfExpired($item)
    {
        if ($item->sell_in < 0) {
            $this->handleExpired($item);
        }
    }

    private function handleExpired($item)
    {
        if ($item->name != 'Aged Brie') {
            $this->handleExpiredNotAgedBrie($item);
        } else {
            $this->increaseQualityIfNotMax($item);
        }
    }

    private function increaseQualityIfNotMax($item)
    {
        if ($item->quality < 50) {
            $this->increaseQuality($item);
        }
    }

    private function increaseQuality($item)
    {
        $item->quality = $item->quality + 1;
    }

    private function handleExpiredNotAgedBrie($item)
    {
        if ($item->name != 'Backstage passes to a TAFKAL80ETC concert') {
            $this->decreseQualityIfItemHasQuality($item);
        } else {
            $item->quality = $item->quality - $item->quality;
        }
    }

    private function decreseQualityIfItemHasQuality($item)
    {
        if ($item->quality > 0) {
            $this->decreaseQualityIfItemNotSulfuras($item);
        }
    }

    private function decreaseQuality($item)
    {
        $item->quality = $item->quality - 1;
    }
}
