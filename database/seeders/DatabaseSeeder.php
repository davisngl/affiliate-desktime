<?php

namespace Database\Seeders;

use App\Models\AffiliateCode;
use App\Models\ClickEvent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => Hash::make('admin'),
        ]);

        $url1 = $user->createAffiliateUrl();
        $url2 = $user->createAffiliateUrl();
        $url3 = $user->createAffiliateUrl();

        collect([$url1, $url2, $url3])
            ->each(function (AffiliateCode $code) {
                $clicks = ClickEvent::factory(random_int(5, 30))
                    ->state(new Sequence(
                        ['clicked_at'        => now()->subDays(random_int(0, 7))],
                        ['clicked_at'        => now()->subDays(random_int(0, 7))],
                        ['clicked_at'        => now()->subDays(random_int(0, 7))],
                        ['clicked_at'        => now()->subDays(random_int(0, 7))],
                        ['clicked_at'        => now()->subDays(random_int(0, 7))]
                    ))
                    ->create([
                        'affiliate_code_id' => $code->id,
                    ]);

                $code->clickEvents()->saveMany($clicks);
            });
    }
}
