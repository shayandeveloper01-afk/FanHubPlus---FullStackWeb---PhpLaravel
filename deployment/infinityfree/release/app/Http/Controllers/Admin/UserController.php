<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\LogsAdminActivity;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    use LogsAdminActivity;
    public function index(Request $request): View
    {
        $users = User::withTrashed()
            ->when($request->search, fn($q, $s) => $q->where(fn ($search) => $search
                ->where('name', 'like', "%$s%")
                ->orWhere('email', 'like', "%$s%")))
            ->when($request->filter === 'admin', fn($q) => $q->where(fn ($admin) => $admin
                ->where('is_admin', true)->orWhere('role', 'admin')))
            ->when($request->filter === 'banned',  fn($q) => $q->whereNotNull('banned_at'))
            ->when($request->filter === 'deleted', fn($q) => $q->onlyTrashed())
            ->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(int $id): View
    {
        $user = User::withTrashed()->findOrFail($id);
        $ratings = $user->ratings()->with('content:id,title')->latest()->get();
        $feedbackMessages = Feedback::where('user_id', $user->id)->latest()->limit(20)->get();
        $firstSiteRecord = collect(['users', 'contents', 'categories', 'articles', 'feedback'])
            ->map(fn (string $table) => DB::table($table)->min('created_at'))
            ->filter()
            ->min();
        $firstSiteRecordAt = $firstSiteRecord ? Carbon::parse($firstSiteRecord) : null;

        return view('admin.users.show', compact('user', 'ratings', 'feedbackMessages', 'firstSiteRecordAt'));
    }

    public function promote(User $user): RedirectResponse
    {
        $user->update(['is_admin' => true, 'role' => 'admin']);
        $this->auditLog('user.promote', 'User', $user->id, "Promoted {$user->name} to admin");
        return back()->with('success', "{$user->name} promoted to admin.");
    }

    public function demote(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot demote yourself.');
        }
        $user->update(['is_admin' => false, 'role' => 'user']);
        $this->auditLog('user.demote', 'User', $user->id, "Demoted {$user->name}");
        return back()->with('success', "{$user->name} demoted.");
    }

    public function ban(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot ban yourself.');
        }
        if ($user->is_admin || $user->role === 'admin') {
            return back()->with('error', 'Cannot ban another admin.');
        }
        $user->update(['banned_at' => now()]);
        $this->auditLog('user.ban', 'User', $user->id, "Banned {$user->name}");
        return back()->with('success', "{$user->name} has been suspended.");
    }

    public function unban(User $user): RedirectResponse
    {
        $user->update(['banned_at' => null]);
        $this->auditLog('user.unban', 'User', $user->id, "Unbanned {$user->name}");
        return back()->with('success', "{$user->name} suspension lifted.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }
        if ($user->is_admin || $user->role === 'admin') {
            return back()->with('error', 'Demote the administrator before deleting this account.');
        }
        $this->auditLog('user.delete', 'User', $user->id, "Soft-deleted {$user->name}");
        $user->delete();
        return back()->with('success', "{$user->name} soft-deleted.");
    }

    public function restore(int $id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return back()->with('success', "User restored.");
    }
}
