<?php

// Example usage of Litepie Hashids package

// 1. Basic encoding and decoding
echo "=== Basic Usage ===\n";
$id = 123;
$encoded = hashids_encode($id);
echo "Original ID: {$id}\n";
echo "Encoded: {$encoded}\n";
echo "Decoded: " . hashids_decode($encoded) . "\n\n";

// 2. Multiple values
echo "=== Multiple Values ===\n";
$ids = [123, 456, 789];
$encoded = hashids_encode($ids);
echo "Original IDs: " . implode(', ', $ids) . "\n";
echo "Encoded: {$encoded}\n";
echo "Decoded: " . implode(', ', hashids_decode($encoded)) . "\n\n";

// 3. Using facade
echo "=== Using Facade ===\n";
use Litepie\Hashids\Facades\Hashids;

$encoded = Hashids::encode(456);
echo "Facade encoded: {$encoded}\n";
echo "Facade decoded: " . implode(', ', Hashids::decode($encoded)) . "\n\n";

// 4. Model usage example
echo "=== Model Usage Example ===\n";

/*
// In your Eloquent model:
class User extends Model
{
    use \Litepie\Hashids\Traits\Hashids;
}

// Usage:
$user = User::find(1);
echo $user->eid; // encoded ID

// Route model binding:
Route::get('/users/{user}', function (User $user) {
    return $user;
});

// URL: /users/Mj3 (instead of /users/1)

// Find by encoded ID:
$user = User::findOrFail('Mj3');

// Signed IDs:
$signedId = $user->getSignedId('+1 hour');
$user = User::findBySignedId($signedId);
*/

echo "Model trait provides:\n";
echo "- getRouteKey() - returns encoded ID for route model binding\n";
echo "- eid attribute - encoded ID accessor\n";
echo "- findOrFail(\$hashid) - find by encoded ID\n";
echo "- findOrNew(\$hashid) - find or create new by encoded ID\n";
echo "- getSignedId(\$expiry) - get signed ID with expiration\n";
echo "- findBySignedId(\$signedId) - find by signed encoded ID\n\n";

// 5. Configuration examples
echo "=== Configuration ===\n";
echo "Set in config/hashids.php or .env:\n";
echo "HASHIDS_SALT=your-custom-salt\n";
echo "HASHIDS_LENGTH=10\n";
echo "HASHIDS_ALPHABET=abcdefghijklmnopqrstuvwxyz1234567890\n\n";

echo "Package installation complete!\n";
echo "Don't forget to:\n";
echo "1. Run: composer install\n";
echo "2. Publish config: php artisan vendor:publish --provider=\"Litepie\\Hashids\\HashidsServiceProvider\"\n";
echo "3. Configure your .env file\n";
echo "4. Add the trait to your models\n";
