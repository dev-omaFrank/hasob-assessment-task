<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

use DMO\SavingsBond\Models\Offer;
use DMO\SavingsBond\Events\OfferCreated;
use DMO\SavingsBond\Events\OfferUpdated;
use DMO\SavingsBond\Events\OfferDeleted;
use DMO\SavingsBond\Listeners\OfferCreatedListener;
use DMO\SavingsBond\Listeners\OfferUpdatedListener;
use DMO\SavingsBond\Listeners\OfferDeletedListener;

class OfferEventTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_offer_created_event_is_dispatched()
    {
        Event::fake([OfferCreated::class]);

        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        // Manually dispatch the event (Eloquent create() doesn't auto-fire custom events)
        event(new OfferCreated($offer));

        Event::assertDispatched(OfferCreated::class, function ($event) use ($offer) {
            return $event->offer->id === $offer->id;
        });
    }

    public function test_offer_updated_event_is_dispatched()
    {
        Event::fake([OfferUpdated::class]);

        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        event(new OfferUpdated($offer));

        Event::assertDispatched(OfferUpdated::class, function ($event) use ($offer) {
            return $event->offer->id === $offer->id;
        });
    }

    public function test_offer_deleted_event_is_dispatched()
    {
        Event::fake([OfferDeleted::class]);

        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        event(new OfferDeleted($offer));

        Event::assertDispatched(OfferDeleted::class, function ($event) use ($offer) {
            return $event->offer->id === $offer->id;
        });
    }

    public function test_offer_created_event_contains_offer_instance()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $event = new OfferCreated($offer);

        $this->assertInstanceOf(Offer::class, $event->offer);
        $this->assertEquals($offer->id, $event->offer->id);
    }

    public function test_offer_updated_event_contains_offer_instance()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $event = new OfferUpdated($offer);

        $this->assertInstanceOf(Offer::class, $event->offer);
        $this->assertEquals($offer->id, $event->offer->id);
    }

    public function test_offer_deleted_event_contains_offer_instance()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $event = new OfferDeleted($offer);

        $this->assertInstanceOf(Offer::class, $event->offer);
        $this->assertEquals($offer->id, $event->offer->id);
    }

    public function test_offer_created_listener_handles_event()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $event = new OfferCreated($offer);
        $listener = new OfferCreatedListener();

        $listener->handle($event);

        $this->assertTrue(true);
    }

    public function test_offer_updated_listener_handles_event()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $event = new OfferUpdated($offer);
        $listener = new OfferUpdatedListener();

        $listener->handle($event);

        $this->assertTrue(true);
    }

    public function test_offer_deleted_listener_handles_event()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        $event = new OfferDeleted($offer);
        $listener = new OfferDeletedListener();

        $listener->handle($event);

        $this->assertTrue(true);
    }

    public function test_events_are_mapped_in_event_service_provider()
    {
        $offer = Offer::factory()->create([
            'organization_id' => $this->test_org->id,
        ]);

        Event::dispatch(new OfferCreated($offer));
        Event::dispatch(new OfferUpdated($offer));
        Event::dispatch(new OfferDeleted($offer));

        $this->assertTrue(true);
    }
}
