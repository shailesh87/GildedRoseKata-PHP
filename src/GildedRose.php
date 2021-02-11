<?php

declare(strict_types=1);

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

    private function updateItem($item): void
    {
        $this->handleQuality($item);
        $this->decreaseSellInIfNotSulfuras($item);
        $this->handleIfExpired($item);
    }

    private function handleQuality($item): void
    {
        if ($item->name !== 'Aged Brie' and $item->name !== 'Backstage passes to a TAFKAL80ETC concert') {
            $this->decreaseQualityIfItemHasQuality($item);
        } else {
            $this->increaseQualityIncludeBackstagePasses($item);
        }
    }

    private function increaseQualityIncludeBackstagePasses($item): void
    {
        if ($item->quality < 50) {
            $this->increaseQuality($item);
            $this->increaseQualityBackstagePasses($item);
        }
    }

    private function increaseQualityBackstagePasses($item): void
    {
        if ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
            $this->increaseQualityFarToExp($item);
            $this->increaseQualityCloseToExp($item);
        }
    }

    private function increaseQualityCloseToExp($item): void
    {
        if ($item->sell_in < 6) {
            $this->increaseQualityIfNotMax($item);
        }
    }

    private function increaseQualityFarToExp($item): void
    {
        if ($item->sell_in < 11) {
            $this->increaseQualityIfNotMax($item);
        }
    }

    private function decreaseQualityIfItemHasQuality($item): void
    {
        if ($item->quality > 0) {
            $this->decreaseQualityIfItemNotSulfuras($item);
        }
    }

    private function decreaseQualityIfItemNotSulfuras($item): void
    {
        if ($item->name !== 'Sulfuras, Hand of Ragnaros') {
            $this->decreaseQuality($item);
        }
    }

    private function decreaseSellInIfNotSulfuras($item): void
    {
        if ($item->name !== 'Sulfuras, Hand of Ragnaros') {
            $this->decreaseSellIn($item);
        }
    }

    private function decreaseSellIn($item): void
    {
        --$item->sell_in;
    }

    private function handleIfExpired($item): void
    {
        if ($item->sell_in < 0) {
            $this->handleExpired($item);
        }
    }

    private function handleExpired($item): void
    {
        if ($item->name !== 'Aged Brie') {
            $this->handleExpiredNotAgedBrie($item);
        } else {
            $this->increaseQualityIfNotMax($item);
        }
    }

    private function increaseQualityIfNotMax($item): void
    {
        if ($item->quality < 50) {
            $this->increaseQuality($item);
        }
    }

    private function increaseQuality($item): void
    {
        ++$item->quality;
    }

    private function handleExpiredNotAgedBrie($item): void
    {
        if ($item->name !== 'Backstage passes to a TAFKAL80ETC concert') {
            $this->decreseQualityIfItemHasQuality($item);
        } else {
            $item->quality -= $item->quality;
        }
    }

    private function decreseQualityIfItemHasQuality($item): void
    {
        if ($item->quality > 0) {
            $this->decreaseQualityIfItemNotSulfuras($item);
        }
    }

    private function decreaseQuality($item): void
    {
        --$item->quality;
    }
}
