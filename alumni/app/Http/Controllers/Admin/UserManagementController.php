<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = User::with('profile')->where('role', 'alumni');

        if (in_array($status, ['pending', 'approved', 'blocked'], true)) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users', 'status', 'search'));
    }

    public function approve(User $user): RedirectResponse
    {
        abort_if($user->isAdmin(), 403);
        $user->update(['status' => 'approved']);

        return back()->with('status', "Approved {$user->email}");
    }

    public function reject(User $user): RedirectResponse
    {
        abort_if($user->isAdmin(), 403);
        $this->deleteVerificationDocument($user);
        $user->delete();

        return back()->with('status', "Rejected registration for {$user->email}");
    }

    public function block(User $user): RedirectResponse
    {
        abort_if($user->isAdmin(), 403);
        $user->update(['status' => 'blocked']);

        return back()->with('status', "Blocked {$user->email}");
    }

    public function unblock(User $user): RedirectResponse
    {
        abort_if($user->isAdmin(), 403);
        $user->update(['status' => 'approved']);

        return back()->with('status', "Unblocked {$user->email}");
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->isAdmin(), 403);
        $email = $user->email;
        $this->deleteVerificationDocument($user);
        $user->delete();

        return back()->with('status', "Deleted {$email}");
    }

    private function deleteVerificationDocument(User $user): void
    {
        if (! $user->verification_document_path) {
            return;
        }

        $relative = ltrim(parse_url($user->verification_document_path, PHP_URL_PATH) ?? '', '/');
        $relative = preg_replace('#^storage/#', '', $relative);
        Storage::disk('public')->delete($relative);
    }
}
