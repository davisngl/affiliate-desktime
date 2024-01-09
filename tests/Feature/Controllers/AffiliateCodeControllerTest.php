<?php

namespace Tests\Feature\Controllers;

use App\Events\AffiliateRegistered;
use App\Listeners\ClearAffiliateCookies;
use App\Listeners\CreateAffiliateLinks;
use App\Listeners\MarkUserAsAffiliate;
use App\Models\AffiliateCode;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AffiliateCodeControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function visitAffiliateUrl(string $affiliateCode): TestResponse
    {
        return $this
            ->get(
                route('affiliate-code.show', ['affiliate' => $affiliateCode])
            );
    }

    /** @test */
    public function it_successfully_redirects_to_register_page_with_cookie_set_for_affiliate()
    {
        $affiliate = AffiliateCode::factory()->create(['code' => 'aff_code']);

        $response = $this
            ->visitAffiliateUrl($affiliate->code)
            ->assertRedirect(route('register', ['via' => $affiliate->code]))
            ->assertCookie(
                cookieName: 'affiliate',
                value: $affiliate->asCookiePayload(encoded: true),
                encrypted: false
            );

        // Requires Dusk or equivalent to see JS load the cookie data in template,
        // server-side rendered template will not have data we are displaying with JS.
        $this
            ->followRedirects($response)
            ->assertSeeText('has invited you to join!');
    }

    /** @test */
    public function it_does_not_set_affiliate_cookie_if_user_clicks_on_invalid_referral_link()
    {
        AffiliateCode::factory()->create(['code' => 'aff_code']);

        $this
            ->visitAffiliateUrl(':does_not_exist:')
            ->assertRedirect(route('register'))
            ->assertCookieMissing('affiliate');
    }

    /** @test */
    public function it_marks_user_as_referred_by_someone_else_after_successful_affiliate_registration()
    {
        Event::fake(AffiliateRegistered::class);

        $referrer = User::factory()->create();
        $affiliate = AffiliateCode::factory()
            ->create([
                'user_id' => $referrer->id,
                'code'    => 'aff_code',
            ]);

        $this->assertInstanceOf(User::class, $affiliate->referrer);

        $this
            ->from(route('register'))
            ->withUnencryptedCookie('affiliate', $affiliate->asCookiePayload(encoded: true))
            ->post(route('register'), [
                'name'                  => ':full_name:',
                'email'                 => $email = 'test@example.com',
                'password'              => $password = 'incredible_password1',
                'password_confirmation' => $password,
            ])
            ->assertSessionHas(
                'successful_affiliate_registration',
                vsprintf('You have been successfully registered as one of %s affiliates!', [$referrer->name])
            )
            ->assertCookieMissing('affiliate');

        Event::assertDispatched(AffiliateRegistered::class);

        $event = new AffiliateRegistered($referrer, User::whereEmail($email)->first());

        (new MarkUserAsAffiliate)->handle($event);
        (new ClearAffiliateCookies)->handle($event);
        (new CreateAffiliateLinks)->handle($event);

        $this->assertEquals(1, User::where('referrer_id', $referrer->id)->count());
        $this->assertCount(3, User::where('referrer_id', $referrer->id)->first()->affiliateCodes);
    }
}
