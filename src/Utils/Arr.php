<?php

namespace SilvioIannone\EnvoyerPhp\Utils;

use Illuminate\Support\Collection;

/**
 * Array utilities.
 */
class Arr
{
    /**
     * Transform the given array into a collection recursively.
     */
    public static function toCollection($array): Collection
    {
        return collect($array)
            ->map(static function ($item) {
                if (is_array($item)) {
                    $itemContainsArrays = (bool) collect($item)
                        ->map(static fn ($value) => is_array($value))
                        ->count();
    
                    if ($itemContainsArrays) {
                        return Arr::toCollection($item);
                    }
                    
                    return collect($item);
                }
                
                return $item;
            });
    }
}
