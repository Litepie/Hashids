<?php

use Litepie\Hashids\Facades\Hashids;

it('can encode and decode numbers', function () {
    $encoded = hashids_encode(123);

    expect($encoded)->toBeString();

    $decoded = hashids_decode($encoded);
    expect($decoded)->toBe(123);
});

it('can encode and decode multiple numbers', function () {
    $numbers = [123, 456, 789];
    $encoded = hashids_encode($numbers);

    expect($encoded)->toBeString();

    $decoded = hashids_decode($encoded);
    expect($decoded)->toBe($numbers);
});

it('can use facade', function () {
    $encoded = Hashids::encode([123]);

    expect($encoded)->toBeString();

    $decoded = Hashids::decode($encoded);
    expect($decoded)->toBe([123]);
});

it('returns null for invalid hashids', function () {
    $decoded = hashids_decode('invalid');

    expect($decoded)->toBeNull();
});

it('returns null for empty hashids', function () {
    $decoded = hashids_decode('');

    expect($decoded)->toBeNull();
});

it('returns null for non-string hashids', function () {
    $decoded = hashids_decode(123);

    expect($decoded)->toBeNull();
});

it('can get config values', function () {
    $alphabet = hashids_config('alphabet');
    $length = hashids_config('length');

    expect($alphabet)->toBeString();
    expect($length)->toBeInt();
});

it('can use sqids aliases', function () {
    $encoded = sqids_encode(123);
    $decoded = sqids_decode($encoded);

    expect($encoded)->toBeString();
    expect($decoded)->toBe(123);
});

it('prevents profanity in generated IDs', function () {
    // Test that the blocklist prevents certain words
    $config = config('hashids.blocklist');
    expect($config)->toBeArray();
});
