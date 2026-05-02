<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use DMO\SavingsBond\Models\Offer;
use DMO\SavingsBond\Models\Subscription;
use DMO\SavingsBond\Models\Bid;
use DMO\SavingsBond\Models\Broker;

class OfferRelationshipTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_offer_has_many_subscriptions()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $broker = Broker::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        Subscription::factory()->count(3)->create([
            'organization_id' => $this->test_org->id,
            'offer_id' => $offer->id,
            'user_id' => $this->test_user->id,
            'broker_id' => $broker->id,
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $offer->subscriptions());
        $this->assertCount(3, $offer->subscriptions);
        $this->assertTrue($offer->subscriptions->every(function ($subscription) use ($offer) {
            return $subscription->offer_id === $offer->id;
        }));
    }

    public function test_offer_has_many_bids()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        Bid::factory()->count(2)->create([
            'organization_id' => $this->test_org->id,
            'offer_id' => $offer->id,
            'user_id' => $this->test_user->id,
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $offer->bids());
        $this->assertCount(2, $offer->bids);
        $this->assertTrue($offer->bids->every(function ($bid) use ($offer) {
            return $bid->offer_id === $offer->id;
        }));
    }

    public function test_subscription_belongs_to_offer()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $broker = Broker::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $subscription = Subscription::factory()->create([
            'organization_id' => $this->test_org->id,
            'offer_id' => $offer->id,
            'user_id' => $this->test_user->id,
            'broker_id' => $broker->id,
        ]);

        // Fixed: Subscription model now uses belongsTo
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $subscription->offer());
        $this->assertInstanceOf(Offer::class, $subscription->offer);
        $this->assertEquals($offer->id, $subscription->offer->id);
    }

    public function test_bid_belongs_to_offer()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $bid = Bid::factory()->create([
            'organization_id' => $this->test_org->id,
            'offer_id' => $offer->id,
            'user_id' => $this->test_user->id,
        ]);

        // Fixed: Bid model now uses belongsTo
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class, $bid->offer());
        $this->assertInstanceOf(Offer::class, $bid->offer);
        $this->assertEquals($offer->id, $bid->offer->id);
    }

    public function test_offer_returns_empty_subscriptions_when_none_exist()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $this->assertCount(0, $offer->subscriptions);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $offer->subscriptions);
    }

    public function test_offer_returns_empty_bids_when_none_exist()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $this->assertCount(0, $offer->bids);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $offer->bids);
    }
}
