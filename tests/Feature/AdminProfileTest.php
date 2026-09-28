<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_profile_page_is_available_to_admins_and_hidden_from_regular_users(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('admin.profile.index'))->assertOk();

        $user = User::factory()->create();
        $this->actingAs($user)->get(route('admin.profile.index'))->assertForbidden();
    }

    public function test_admin_can_update_their_name_and_email(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->patch(route('admin.profile.update'), [
            'name' => 'Updated Admin',
            'email' => 'updated-admin@example.com',
        ])->assertRedirect(route('admin.profile.index'));

        $this->assertSame('Updated Admin', $admin->fresh()->name);
        $this->assertSame('updated-admin@example.com', $admin->fresh()->email);
        $this->assertNull($admin->fresh()->email_verified_at);
    }

    public function test_admin_can_change_password_after_confirming_the_current_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->put(route('admin.profile.password.update'), [
            'current_password' => 'password',
            'password' => 'New-Secure-Password-123!',
            'password_confirmation' => 'New-Secure-Password-123!',
        ])->assertRedirect(route('admin.profile.index'));

        $this->assertTrue(Hash::check('New-Secure-Password-123!', $admin->fresh()->password));
    }
}
