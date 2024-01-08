<?php

namespace Tests\Feature;

use App\Models\AffiliateCode;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AffiliateCodeControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function visitAffiliateUrl(string $affiliateCode): TestResponse
    {
        return $this
            ->get(
                route('affiliate-code', ['affiliate' => $affiliateCode])
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

        $this
            ->followRedirects($response)
            ->assertSeeText(
                vsprintf('Your friend %s has invited you', [$affiliate->owner->name])
            );
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
}
