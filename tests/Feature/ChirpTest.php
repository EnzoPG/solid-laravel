<?php

use App\Models\User;
use App\Models\Chirp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, get, post, put, delete};

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

function createChirp() {
    return Chirp::factory()->create();
}

function getChirp(Chirp $chirp) {
    $chirpId = $chirp->id;
    return Chirp::find($chirpId);
}

it('allows authenticated users to create chirps', function () {
    actingAs($this->user);

    $response = post('/chirps', [
        'message' => 'New Post from Pest!',
    ]);

    $response->assertStatus(302);
    expect(Chirp::where('message', 'New Post from Pest!')->exists())->toBeTrue();
});

it('allows authenticated users to read a chirp', function () {
    actingAs($this->user);
    $chirp = createChirp();

    $response = get("/chirps/{$chirp->id}/edit");

    $response->assertStatus(200);
    $response->assertSee($chirp->message);
});

it('allows authenticated users to update a chirp', function () {
    actingAs($this->user);
    $chirp = createChirp();

    $response = put("/chirps/{$chirp->id}", [
        'message' => 'Updated Message',
    ]);

    $response->assertStatus(302);
    expect(getChirp($chirp)->message)->toBe('Updated Message');
});

it('allows authenticated users to delete a chirp', function () {
    actingAs($this->user);
    $chirp = createChirp();

    $response = delete("/chirps/{$chirp->id}");

    $response->assertStatus(302);
    expect(getChirp($chirp))->toBeNull();
});

it('prevents guests from creating chirps', function () {
    $response = post('/chirps', [
        'message' => 'Not allowed!',
    ]);

    $response->assertRedirect('/login');
});
