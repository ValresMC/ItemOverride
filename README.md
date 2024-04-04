# ItemOverride :
A PocketMine-MP virion for easier override items.

---

### Usage :
Just intergrate the virion itself into your plugin.

---

### Exemples :
```php
public function onLoad(): void {
        // Define the override item :
        $ironSword = new IronSword(new ItemIdentifier(ItemTypeIds::IRON_SWORD), "Iron sword");
        
        Override::override("iron_sword", $ironSword);
        // Remove the oldest item :
        Override::deserializer(ItemTypeNames::IRON_SWORD, $ironSword, function () use ($ironSword) {
            return clone $ironSword;
        });
        // Set the override item :
        Override::serializer(ItemTypeNames::IRON_SWORD, $ironSword);
        
        Override::resetCreativeInventory();
    }
```

---

**This framework is a trial. For any feedback or improvement, please create an issue.**
