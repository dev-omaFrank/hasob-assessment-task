<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use DMO\SavingsBond\Models\Offer;

class OfferCrudTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_offer_can_be_created()
    {
        $offerData = [
            'organization_id' => $this->test_org->id,
            'status' => 'active',
            'offer_title' => 'Test Bond Offer',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 100,
            'interest_rate_pct' => 12.50,
            'offer_start_date' => now()->addDay(),
            'offer_end_date' => now()->addMonth(),
            'offer_settlement_date' => now()->addMonths(2),
            'offer_maturity_date' => now()->addYears(2),
            'tenor_years' => 2,
        ];

        $offer = Offer::create($offerData);

        $this->assertDatabaseHas('sb_offers', [
            'id' => $offer->id,
            'offer_title' => 'Test Bond Offer',
            'price_per_unit' => 1000.00,
        ]);

        $this->assertInstanceOf(Offer::class, $offer);
        $this->assertEquals('Test Bond Offer', $offer->offer_title);
    }

    public function test_offer_can_be_retrieved()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
            'offer_title' => 'Retrievable Offer',
        ]);

        $retrievedOffer = Offer::find($offer->id);

        $this->assertNotNull($retrievedOffer);
        $this->assertEquals('Retrievable Offer', $retrievedOffer->offer_title);
        $this->assertEquals($offer->id, $retrievedOffer->id);
    }

    public function test_multiple_offers_can_be_retrieved()
    {
        Offer::factory()->count(5)->create([
            'organization_id' => $this->test_org->id,
        ]);

        $offers = Offer::all();

        $this->assertCount(5, $offers);
    }

    public function test_offer_can_be_updated()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
            'offer_title' => 'Original Title',
            'price_per_unit' => 1000.00,
        ]);

        $offer->update([
            'offer_title' => 'Updated Title',
            'price_per_unit' => 1500.00,
        ]);

        $updatedOffer = Offer::find($offer->id);

        $this->assertEquals('Updated Title', $updatedOffer->offer_title);
        $this->assertEquals(1500.00, $updatedOffer->price_per_unit);
        $this->assertDatabaseHas('sb_offers', [
            'id' => $offer->id,
            'offer_title' => 'Updated Title',
        ]);
    }

    public function test_offer_can_be_deleted()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $offerId = $offer->id;
        $offer->delete();

        $this->assertSoftDeleted('sb_offers', [
            'id' => $offerId,
        ]);

        $this->assertNull(Offer::find($offerId));
    }

    public function test_offer_factory_creates_valid_offer()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $this->assertNotNull($offer->id);
        $this->assertNotNull($offer->offer_title);
        $this->assertDatabaseHas('sb_offers', [
            'id' => $offer->id,
        ]);
    }
}
