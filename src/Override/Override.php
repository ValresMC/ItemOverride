<?php

namespace Overwrite;

use Closure;
use pocketmine\data\bedrock\item\SavedItemData;
use pocketmine\inventory\CreativeInventory;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\world\format\io\GlobalItemDataHandlers;

final class Override
{
    protected static $itemDeserializers;
    protected static $itemSerializers;

    public static function override(string $name, Item $item): void
    {
        StringToItemParser::getInstance()->override($name, fn() => $item);
    }

    public static function deserializer(string $typeName, Item $item, Closure $deserialize = null): void
    {
        (function(Item $item, Closure $deserializer): void {
            self::$itemDeserializers[$item->getTypeId()] = $deserializer;
        })->call(
            GlobalItemDataHandlers::getDeserializer(),
            $typeName,
            $deserialize ?? fn() => clone $item
        );
    }

    public static function serializer(string $typeName, Item $item, Closure $serialize = null): void
    {
        (function(Item $item, Closure $serializer): void {
            self::$itemSerializers[$item->getTypeId()] = $serializer;
        })->call(
            GlobalItemDataHandlers::getSerializer(),
            $item,
            $serialize ?? fn() => new SavedItemData($typeName)
        );
    }

    public static function resetCreativeInventory() : void
    {
        CreativeInventory::reset();
        CreativeInventory::getInstance();
    }
}
