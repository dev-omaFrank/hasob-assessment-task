# Backend-assessment-test
This is the repository for working on the Hasob Pre-assessment test for Php/Laravel developers job applicants.

After setting up the project, I went ahead to access some pages and encountered some errors. A quick look at the laravel logs file showed me the causes, the rest of this readme will identify the errors i faced and the steps I took to resolve them.

PART A: TESTING & BUG FIXES
===========================

1. BUG IDENTIFICATION & FIXES
------------------------------
File: Offer.php (Model)
Issues Found:
- Missing relationships: subscriptions() and bids() methods were absent
- $fillable array had display_ordinal, wf_status, wf_meta_data commented out
Fixes Applied:
- Added hasMany relationships for subscriptions and bids
- Uncommented the three fields in $fillable array

File: CreateOfferRequest.php / UpdateOfferRequest.php (Form Requests)
Issues Found:
- offer_title was validated as 'email' instead of 'string'
- AppBaseFormRequest was imported from wrong namespace (DMO\SavingsBond\Requests instead of Hasob\FoundationCore\Requests)
- Date validation was incompatible with frontend format
Fixes Applied:
- Changed offer_title validation to 'required|string|max:255'
- Fixed import to use Hasob\FoundationCore\Requests\AppBaseFormRequest
- Added prepareForValidation() to convert date formats

File: OfferCreatedListener.php / OfferUpdatedListener.php / OfferDeletedListener.php (Event Listeners)
Issues Found:
- Imported Models\OfferCreated instead of Events\OfferCreated in all three listener files
Fixes Applied:
- Changed all imports to correct Events namespace

File: index.blade.php (Listing Page)
Issues Found:
- Page title said "Edit Offer" instead of "Offers"
Fixes Applied:
- Changed title to "Offers"

File: TestCase.php (Base Test Class)
Issues Found:
- Used App\Models\User which didnt exist in the project
- Used Organization::find($test_dept_id) instead of Department::find()
- Some variables were not assigned to $this (test_org, test_dept, test_user)
Fixes Applied:
- Changed to Hasob\FoundationCore\Models\User
- Fixed Department lookup
- Added $this-> prefix for test variables

File: OfferFactory.php / SubscriptionFactory.php / BidFactory.php (Factories)
Issues Found:
- organization_id appeared twice (duplicate key)
- Numeric fields used faker->word instead of numbers
- Organization::first() failed in fresh test DB
- Wrong namespace was used (Database\Factories instead of DMO\SavingsBond\Database\Factories)
Fixes Applied:
- Removed duplicate organization_id
- Changed numeric fields to randomFloat/randomDigitNotNull
- Removed hardcoded Organization::first()
- Moved to portal's database/factories directory with correct namespace

File: Bid.php / Subscription.php (Models)
Issues Found:
- offer() relationship used hasOne with wrong foreign key parameters
Fixes Applied:
- Changed to belongsTo with correct foreign key


2. TEST FILES CREATED
---------------------

Feature Tests:
- tests/Feature/OfferCrudTest.php (6 tests)
  * test_can_create_offer
  * test_can_retrieve_single_offer
  * test_can_retrieve_multiple_offers
  * test_can_update_offer
  * test_can_delete_offer
  * test_factory_creates_valid_offer

Unit Tests:
- tests/Unit/OfferRelationshipTest.php (6 tests)
  * test_offer_has_many_subscriptions
  * test_offer_has_many_bids
  * test_subscription_belongs_to_offer
  * test_bid_belongs_to_offer
  * test_offer_has_empty_subscriptions_collection
  * test_offer_has_empty_bids_collection

- tests/Unit/OfferEventTest.php (10 tests)
  * test_offer_created_event_exists
  * test_offer_updated_event_exists
  * test_offer_deleted_event_exists
  * test_offer_created_event_is_dispatched
  * test_offer_updated_event_is_dispatched
  * test_offer_deleted_event_is_dispatched
  * test_offer_created_event_contains_offer_instance
  * test_offer_updated_event_contains_offer_instance
  * test_offer_created_listener_handles_event
  * test_events_are_mapped_in_service_provider

Final Result: 22/22 tests passing


PART B: USER INTERFACE IMPROVEMENTS
===================================

1. LISTING PAGE (/sb/offers)
-----------------------------
Status: Already functional
Components:
- Card view layout (card_view_index.blade.php)
- Individual offer cards (card_view_item.blade.php)
- Action buttons: View Details, Edit, Delete
- "New Offer" button triggers create modal

2. CREATE MODAL
---------------
Status: Fixed and working
Issues Faced:
- 401 Unauthorized error (modal used API routes instead of web routes)
- AppBaseFormRequest class was not found (wrong namespace)
- Date fields were causing "Incorrect datetime value" SQL errors
- datetime-local inputs were not submitting values (empty strings in payload)
- Missing name attributes on date inputs
- jQuery .val() was incompatible with datetime-local inputs
- Duplicate IDs between fields.blade.php and show_fields.blade.php

Steps Taken:
1. Changed modal to use web routes (sb.offers.*) instead of API routes
2. Fixed AppBaseFormRequest import to Hasob\FoundationCore\Requests
3. Switched from datetime-local to type="text" inputs
4. Added name attributes to all date inputs
5. Used native DOM API (document.getElementById) instead of jQuery .val()
6. Added JavaScript validation: regex /^\d{4}-\d{2}-\d{2}$/
7. Added formatDateForDisplay() helper for edit modal
8. Backend: Added prepareForValidation() to convert DD-MM-YYYY to YYYY-MM-DD but eventually changed frontend to accept date in YYYY-MM-DD format for data concistency

Final Date Format: YYYY-MM-DD (e.g., 25-12-2025)

3. EDIT MODAL
-------------
Status: Fixed and working
Same modal reused with:
- AJAX fetch to populate form fields
- formatDateForDisplay() converts DB format (YYYY-MM-DD) to display format (DD-MM-YYYY) but was changed to maintain data concistency
- JavaScript validation before submission

4. DETAIL PAGE (/sb/offers/{id})
--------------------------------
Status: Fixed and enhanced
Issues Found:
- Wrong route name: route('offers.index') instead of route('sb.offers.index')
- Duplicate page_title_subtext section
- Missing related records (subscriptions and bids)

Fixes Applied:
- Fixed route name to sb.offers.index
- Removed duplicate subtext section
- Controller: Added ->with(['subscriptions', 'bids']) eager loading
- Added subscriptions table with investor info, units, price, status, broker
- Added bids table with units, price, total, status
- Added empty state messages when no records exist


TECHNICAL ARCHITECTURE
======================

Project Structure:
- dmo-savings-bond-portal/ (Laravel application)
- dmo-savings-bond-module/ (Package/module with models, controllers, views)
- hasob-foundation-core-bs-5/ (Foundation package with User, Organization, etc.)

Key Technologies:
- Laravel 10.x
- PHP 8.x
- Bootstrap 5
- jQuery + AJAX
- SweetAlert for confirmations
- DataTables for listing
- PHPUnit for testing

Database Tables:
- sb_offers (main entity)
- sb_subscriptions (related to offers)
- sb_bids (related to offers)
- sb_brokers (referenced by subscriptions)
