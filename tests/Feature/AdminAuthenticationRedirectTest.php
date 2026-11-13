<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminAuthenticationRedirectTest extends TestCase
{
    public function test_guest_is_redirected_to_admin_login_when_opening_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }
}
