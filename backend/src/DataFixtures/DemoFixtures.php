<?php

declare(strict_types=1);

namespace MarcusSports\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

// Product domain
use MarcusSports\Catalog\CompatibilityRule\Domain\CompatibilityRule;
use MarcusSports\Catalog\CompatibilityRule\Domain\CompatibilityRuleCollection;
use MarcusSports\Catalog\CompatibilityRule\Domain\CompatibilityRuleUuid;
use MarcusSports\Catalog\CompatibilityRule\Domain\RuleExpression;
use MarcusSports\Catalog\Product\Domain\Product;
use MarcusSports\Catalog\Product\Domain\ProductUuid;
use MarcusSports\Catalog\Product\Domain\ProductName;
use MarcusSports\Catalog\Product\Domain\ProductDescription;
use MarcusSports\Catalog\Product\Domain\ProductCategory;
use MarcusSports\Catalog\Product\Domain\ProductBasePrice;
use MarcusSports\Catalog\Product\Domain\ProductCreatedAt;
use MarcusSports\Catalog\Product\Domain\ProductUpdatedAt;
// PriceModifier domain
use MarcusSports\Catalog\PriceModifier\Domain\PriceModifier;
use MarcusSports\Catalog\PriceModifier\Domain\PriceModifierUuid;
use MarcusSports\Catalog\PriceModifier\Domain\PriceModifierCondition;
use MarcusSports\Catalog\PriceModifier\Domain\PriceModifierAdjustment;
use MarcusSports\Catalog\PriceModifier\Domain\PriceModifierScope;
// PartType domain
use MarcusSports\Catalog\PartType\Domain\PartType;
use MarcusSports\Catalog\PartType\Domain\PartTypeUuid;
use MarcusSports\Catalog\PartType\Domain\PartTypeName;
use MarcusSports\Catalog\PartType\Domain\PartTypeRequired;
use MarcusSports\Catalog\PartType\Domain\PartTypeCollection;
use MarcusSports\Catalog\PartType\Domain\PartTypeCreatedAt;
use MarcusSports\Catalog\PartType\Domain\PartTypeUpdatedAt;
// PartItem domain
use MarcusSports\Catalog\PartItem\Domain\PartItem;
use MarcusSports\Catalog\PartItem\Domain\PartItemUuid;
use MarcusSports\Catalog\PartItem\Domain\PartItemCollection;
use MarcusSports\Catalog\PartItem\Domain\PartItemLabel;
use MarcusSports\Catalog\PartItem\Domain\PartItemPrice;
use MarcusSports\Catalog\PartItem\Domain\PartItemStatus;
use MarcusSports\Catalog\PartItem\Domain\PartItemAttributes;
use MarcusSports\Catalog\PartItem\Domain\PartItemRestrictions;
use MarcusSports\Catalog\PartItem\Domain\PartItemCreatedAt;
use MarcusSports\Catalog\PartItem\Domain\PartItemUpdatedAt;

final class DemoFixtures extends Fixture
{
    private Product $bikeProduct;
    private Product $surfProduct;

    public function load(ObjectManager $manager): void
    {
        // Create the "Custom Mountain Bike" product
        $this->bikeProduct = new Product(
            new ProductUuid('11111111-1111-1111-1111-111111111111'),
            new ProductName('Custom Mountain Bike'),
            new ProductDescription('A fully customizable mountain bike designed for off-road adventures.'),
            ProductCategory::from('cycling'),
            new ProductBasePrice(500.00),
            null,
            null,
            ProductCreatedAt::create(),
            ProductUpdatedAt::create(),
            null  // Not deleted
        );
        $manager->persist($this->bikeProduct);

        $bikePartTypes = $this->createBikePartTypes($manager);
        $this->bikeProduct->partTypes()->clear();
        foreach ($bikePartTypes as $partType) {
            $this->bikeProduct->partTypes()->add($partType);
        }

        $bikeCompatibilityRules = $this->createBikeCompatibilityRules($manager);
        $this->bikeProduct->rules()->clear();
        foreach ($bikeCompatibilityRules as $bikeCompatibilityRule) {
            $this->bikeProduct->rules()->add($bikeCompatibilityRule);
        }

        // Create PriceModifiers for the bike product:
        $priceModifier1 = new PriceModifier(
            new PriceModifierUuid('66666666-1111-1111-1111-111111111111'),
            $this->bikeProduct,
            new PriceModifierCondition('{"if": {"frame_finish": "Matte", "frame_type": "Full-suspension"}, "then": {"apply_modifier": true}}'),
            new PriceModifierAdjustment(50.00),
            PriceModifierScope::GLOBAL // Assuming GLOBAL is defined in your enum
        );
        $manager->persist($priceModifier1);

        $priceModifier2 = new PriceModifier(
            new PriceModifierUuid('88888888-2222-2222-2222-222222222222'),
            $this->bikeProduct,
            new PriceModifierCondition('{"if": {"frame_finish": "Matte", "frame_type": "Diamond"}, "then": {"apply_modifier": true}}'),
            new PriceModifierAdjustment(35.00),
            PriceModifierScope::GLOBAL
        );
        $manager->persist($priceModifier2);

        // Create the "Custom Surfboard" product
        $this->surfProduct = new Product(
            new ProductUuid('22222222-2222-2222-2222-222222222222'),
            new ProductName('Custom Surfboard'),
            new ProductDescription('A high-performance surfboard that can be fully customized to match your style and the wave conditions.'),
            ProductCategory::from('surf'),
            new ProductBasePrice(800.00),
            null,
            null,
            ProductCreatedAt::create(),
            ProductUpdatedAt::create(),
            null
        );

        $manager->persist($this->surfProduct);

        $surfPartTypes = $this->createSurfboardPartTypes($manager);
        $this->surfProduct->partTypes()->clear();
        foreach ($surfPartTypes as $partType) {
            $this->surfProduct->partTypes()->add($partType);
        }

        $surfCompatibilityRules = $this->createSurfboardCompatibilityRules($manager);
        $this->surfProduct->rules()->clear();
        foreach ($surfCompatibilityRules as $surfCompatibilityRule) {
            $this->surfProduct->rules()->add($surfCompatibilityRule);
        }

        $manager->flush();
    }

    private function createBikePartTypes(ObjectManager $manager): ArrayCollection
    {
        $collection = new ArrayCollection();

        // FRAME TYPE: Options: "Full-suspension", "Diamond", "Step-through"
        $frameTypeItems = new ArrayCollection();

        $partTypeFrame = new PartType(
            new PartTypeUuid('a1b2c3d4-e5f6-1111-2222-333344445555'),
            new PartTypeName('Frame Type'),
            $this->bikeProduct,
            new PartTypeRequired(true),
            $frameTypeItems,
            PartTypeCreatedAt::create(),
            PartTypeUpdatedAt::create(),
            null
        );

        $collection->add($partTypeFrame);

        $frameTypeItems->add(new PartItem(
            new PartItemUuid('11111111-aaaa-1111-aaaa-111111111111'),
            $partTypeFrame,
            new PartItemLabel('Full-suspension'),
            new PartItemPrice(130.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Lightweight carbon frame"}'),
            null,  // No restrictions
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $frameTypeItems->add(new PartItem(
            new PartItemUuid('11111111-bbbb-1111-bbbb-111111111111'),
            $partTypeFrame,
            new PartItemLabel('Diamond'),
            new PartItemPrice(0.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Classic diamond frame"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $frameTypeItems->add(new PartItem(
            new PartItemUuid('11111111-cccc-1111-cccc-111111111111'),
            $partTypeFrame,
            new PartItemLabel('Step-through'),
            new PartItemPrice(20.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Easy mounting design"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));



        // FRAME FINISH: Options: "Matte", "Shiny"
        $frameFinishItems = new ArrayCollection();

        $partTypeFrameFinish = new PartType(
            new PartTypeUuid('a1b2c3d4-e5f6-1111-2222-333344445556'),
            new PartTypeName('Frame Finish'),
            $this->bikeProduct,
            new PartTypeRequired(true),
            $frameFinishItems,
            PartTypeCreatedAt::create(),
            PartTypeUpdatedAt::create(),
            null
        );

        $collection->add($partTypeFrameFinish);

        $frameFinishItems->add(new PartItem(
            new PartItemUuid('11111111-dddd-1111-dddd-111111111111'),
            $partTypeFrameFinish,
            new PartItemLabel('Matte'),
            new PartItemPrice(50.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "High coverage matte finish"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $frameFinishItems->add(new PartItem(
            new PartItemUuid('11111111-eeee-1111-eeee-111111111111'),
            $partTypeFrameFinish,
            new PartItemLabel('Shiny'),
            new PartItemPrice(30.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Reflective and sleek"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));


        // WHEELS: Options: "Road wheels", "Mountain wheels", "Fat bike wheels"
        $wheelsItems = new ArrayCollection();

        $partTypeWheels = new PartType(
            new PartTypeUuid('a1b2c3d4-e5f6-1111-2222-333344445557'),
            new PartTypeName('Wheels'),
            $this->bikeProduct,
            new PartTypeRequired(true),
            $wheelsItems,
            PartTypeCreatedAt::create(),
            PartTypeUpdatedAt::create(),
            null
        );

        $collection->add($partTypeWheels);

        $wheelsItems->add(new PartItem(
            new PartItemUuid('11111111-ffff-1111-ffff-111111111111'),
            $partTypeWheels,
            new PartItemLabel('Road wheels'),
            new PartItemPrice(80.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Designed for speed and agility"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $wheelsItems->add(new PartItem(
            new PartItemUuid('11111111-1111-2222-1111-111111111112'),
            $partTypeWheels,
            new PartItemLabel('Mountain wheels'),
            new PartItemPrice(90.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Built for rough terrain"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $wheelsItems->add(new PartItem(
            new PartItemUuid('11111111-2222-3333-4444-555555555555'),
            $partTypeWheels,
            new PartItemLabel('Fat bike wheels'),
            new PartItemPrice(100.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Extra wide for stability on soft terrain"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));


        // RIM COLOR: Options: "Red", "Black", "Blue"
        $rimColorItems = new ArrayCollection();

        $partTypeRimColor = new PartType(
            new PartTypeUuid('a1b2c3d4-e5f6-1111-2222-333344445558'),
            new PartTypeName('Rim Color'),
            $this->bikeProduct,
            new PartTypeRequired(false),
            $rimColorItems,
            PartTypeCreatedAt::create(),
            PartTypeUpdatedAt::create(),
            null
        );

        $collection->add($partTypeRimColor);

        $rimColorItems->add(new PartItem(
            new PartItemUuid('11111111-3333-4444-5555-666666666666'),
            $partTypeRimColor,
            new PartItemLabel('Red'),
            new PartItemPrice(20.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Vibrant red finish"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $rimColorItems->add(new PartItem(
            new PartItemUuid('11111111-3333-4444-5555-777777777777'),
            $partTypeRimColor,
            new PartItemLabel('Black'),
            new PartItemPrice(15.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Sleek and modern"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $rimColorItems->add(new PartItem(
            new PartItemUuid('11111111-3333-4444-5555-888888888888'),
            $partTypeRimColor,
            new PartItemLabel('Blue'),
            new PartItemPrice(20.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Cool blue tone"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));


        // CHAIN: Options: "Single-speed chain", "8-speed chain"
        $chainItems = new ArrayCollection();

        $partItemChain = new PartType(
            new PartTypeUuid('a1b2c3d4-e5f6-1111-2222-333344445559'),
            new PartTypeName('Chain'),
            $this->bikeProduct,
            new PartTypeRequired(true),
            $chainItems,
            PartTypeCreatedAt::create(),
            PartTypeUpdatedAt::create(),
            null
        );

        $collection->add($partItemChain);

        $chainItems->add(new PartItem(
            new PartItemUuid('11111111-4444-5555-6666-777777777777'),
            $partItemChain,
            new PartItemLabel('Single-speed chain'),
            new PartItemPrice(43.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Efficient and reliable"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $chainItems->add(new PartItem(
            new PartItemUuid('11111111-4444-5555-6666-888888888888'),
            $partItemChain,
            new PartItemLabel('8-speed chain'),
            new PartItemPrice(55.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Optimized for multi-gear setups"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));


        return $collection;
    }

    private function createBikeCompatibilityRules(ObjectManager $manager): ?ArrayCollection
    {
        $collection = new ArrayCollection();

        // Rule: If "Mountain wheels" is selected, then only "Full-suspension" is allowed as Frame Type.
        $ruleExpressionBike1 = json_encode([
            'if' => ['wheels' => 'Mountain wheels'],
            'then' => ['frame_type' => 'Full-suspension']
        ]);
        $collection->add(new CompatibilityRule(
            new CompatibilityRuleUuid('b1b2b3b4-c5d6-1111-2222-333344445555'),
            $this->bikeProduct,
            new RuleExpression($ruleExpressionBike1)
        ));

        // Rule: If "Fat bike wheels" is selected, then the "Red" rim color is not available.
        $ruleExpressionBike2 = json_encode([
            'if' => ['wheels' => 'Fat bike wheels'],
            'then' => ['not_allowed_rim_color' => 'Red']
        ]);
        $collection->add(new CompatibilityRule(
            new CompatibilityRuleUuid('b1b2b3b4-c5d6-1111-2222-333344445556'),
            $this->bikeProduct,
            new RuleExpression($ruleExpressionBike2)
        ));

        return $collection;
    }

    private function createSurfboardPartTypes(ObjectManager $manager): ArrayCollection
    {
        $collection = new ArrayCollection();

        // BOARD SHAPE: Options: "Shortboard", "Fish", "Funboard"
        $boardShapeItems = new ArrayCollection();

        $partTypeBoardShape = new PartType(
            new PartTypeUuid('c1d2e3f4-1111-2222-3333-444455556666'),
            new PartTypeName('Board Shape'),
            $this->surfProduct,
            new PartTypeRequired(true),
            $boardShapeItems,
            PartTypeCreatedAt::create(),
            PartTypeUpdatedAt::create(),
            null
        );

        $collection->add($partTypeBoardShape);

        $boardShapeItems->add(new PartItem(
            new PartItemUuid('22222222-aaaa-1111-aaaa-111111111111'),
            $partTypeBoardShape,
            new PartItemLabel('Shortboard'),
            new PartItemPrice(100.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Versatile and agile"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $boardShapeItems->add(new PartItem(
            new PartItemUuid('22222222-bbbb-1111-bbbb-111111111111'),
            $partTypeBoardShape,
            new PartItemLabel('Fish'),
            new PartItemPrice(90.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Ideal for small waves"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $boardShapeItems->add(new PartItem(
            new PartItemUuid('22222222-cccc-1111-cccc-111111111111'),
            $partTypeBoardShape,
            new PartItemLabel('Funboard'),
            new PartItemPrice(110.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Easy to paddle and stable"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));



        // FIN CONFIGURATION: Options: "Tri-fin", "Twin-fin", "Single-fin"
        $finConfigItems = new ArrayCollection();

        $partTypeFinConfiguration = new PartType(
            new PartTypeUuid('c1d2e3f4-1111-2222-3333-444455556667'),
            new PartTypeName('Fin Configuration'),
            $this->surfProduct,
            new PartTypeRequired(true),
            $finConfigItems,
            PartTypeCreatedAt::create(),
            PartTypeUpdatedAt::create(),
            null
        );

        $collection->add($partTypeFinConfiguration);

        $finConfigItems->add(new PartItem(
            new PartItemUuid('22222222-dddd-1111-dddd-111111111111'),
            $partTypeFinConfiguration,
            new PartItemLabel('Tri-fin'),
            new PartItemPrice(70.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Optimized for performance"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $finConfigItems->add(new PartItem(
            new PartItemUuid('22222222-eeee-1111-eeee-111111111111'),
            $partTypeFinConfiguration,
            new PartItemLabel('Twin-fin'),
            new PartItemPrice(60.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Balanced performance"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $finConfigItems->add(new PartItem(
            new PartItemUuid('22222222-ffff-1111-ffff-111111111111'),
            $partTypeFinConfiguration,
            new PartItemLabel('Single-fin'),
            new PartItemPrice(65.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Classic and reliable"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));


        // DECK COLOR: Options: "Blue", "White", "Black"
        $deckColorItems = new ArrayCollection();

        $partTypeDeckColor = new PartType(
            new PartTypeUuid('c1d2e3f4-1111-2222-3333-444455556668'),
            new PartTypeName('Deck Color'),
            $this->surfProduct,
            new PartTypeRequired(false),
            $deckColorItems,
            PartTypeCreatedAt::create(),
            PartTypeUpdatedAt::create(),
            null
        );

        $collection->add($partTypeDeckColor);

        $deckColorItems->add(new PartItem(
            new PartItemUuid('22222222-1111-2222-3333-444455556600'),
            $partTypeDeckColor,
            new PartItemLabel('Blue'),
            new PartItemPrice(40.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Ocean blue"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $deckColorItems->add(new PartItem(
            new PartItemUuid('22222222-2222-2222-3333-444455556601'),
            $partTypeDeckColor,
            new PartItemLabel('White'),
            new PartItemPrice(35.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Clean white"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));
        $deckColorItems->add(new PartItem(
            new PartItemUuid('22222222-3333-4444-5555-444455556600'),
            $partTypeDeckColor,
            new PartItemLabel('Black'),
            new PartItemPrice(40.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Sleek black"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));


        // ACCESSORY: Leash: Option: "Standard Leash"
        $leashItems = new ArrayCollection();

        $partTypeAccessoryLeash = new PartType(
            new PartTypeUuid('c1d2e3f4-1111-2222-3333-444455556669'),
            new PartTypeName('Accessory: Leash'),
            $this->surfProduct,
            new PartTypeRequired(false),
            $leashItems,
            PartTypeCreatedAt::create(),
            PartTypeUpdatedAt::create(),
            null
        );

        $collection->add($partTypeAccessoryLeash);


        $leashItems->add(new PartItem(
            new PartItemUuid('22222222-7777-8888-9999-000000000001'),
            $partTypeAccessoryLeash,
            new PartItemLabel('Standard Leash'),
            new PartItemPrice(15.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "Durable and reliable"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));


        // ACCESSORY: Wax: Option: "Surf Wax"
        $waxItems = new ArrayCollection();

        $partTypeAccessoryWax = new PartType(
            new PartTypeUuid('c1d2e3f4-1111-2222-3333-444455556670'),
            new PartTypeName('Accessory: Wax'),
            $this->surfProduct,
            new PartTypeRequired(false),
            $waxItems,
            PartTypeCreatedAt::create(),
            PartTypeUpdatedAt::create(),
            null
        );

        $waxItems->add(new PartItem(
            new PartItemUuid('22222222-aaaa-3333-bbbb-444455556677'),
            $partTypeAccessoryWax,
            new PartItemLabel('Surf Wax'),
            new PartItemPrice(10.00),
            PartItemStatus::ACTIVE,
            new PartItemAttributes('{"description": "High grip wax for optimal performance"}'),
            null,
            PartItemCreatedAt::create(),
            PartItemUpdatedAt::create(),
            null
        ));

        return $collection;
    }

    private function createSurfboardCompatibilityRules(ObjectManager $manager): ?ArrayCollection
    {
        $collection = new ArrayCollection();

        // Rule: If Fin Configuration is "Tri-fin", then Board Shape must be "Shortboard".
        $ruleExpressionSurf = json_encode([
            'if' => ['fin_configuration' => 'Tri-fin'],
            'then' => ['board_shape' => 'Shortboard']
        ]);
        $collection->add(new CompatibilityRule(
            new CompatibilityRuleUuid('d1d2d3d4-1111-2222-3333-444455556677'),
            $this->surfProduct,
            new RuleExpression($ruleExpressionSurf)
        ));

        return $collection;
    }
}
