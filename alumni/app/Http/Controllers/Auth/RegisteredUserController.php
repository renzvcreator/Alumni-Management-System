<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'graduation_year' => ['nullable', 'integer', 'min:1950', 'max:'.(date('Y') + 5)],
            'current_job' => ['nullable', 'string', 'max:150'],
            'industry' => ['nullable', 'string', 'max:100'],
            'contact_number' => ['nullable', 'string', 'max:30'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'verification_document' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,pdf', 'max:4096'],
            'privacy' => ['accepted'],
        ], [
            'privacy.accepted' => 'You must agree to the Privacy Policy to register.',
            'verification_document.required' => 'Please upload a verification document (Certificate of Completion, School ID, etc.).',
            'verification_document.mimes' => 'The verification document must be an image (JPG/PNG/GIF) or a PDF.',
            'verification_document.max' => 'The verification document may not be larger than 4MB.',
        ]);

        $documentPath = Storage::url(
            $request->file('verification_document')->store('verification', 'public')
        );

        $user = DB::transaction(function () use ($validated, $documentPath) {
            $user = User::create([
                'name' => trim($validated['first_name'].' '.$validated['last_name']),
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'alumni',
                'status' => 'pending',
                'verification_document_path' => $documentPath,
            ]);

            Profile::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'graduation_year' => $validated['graduation_year'] ?? null,
                'current_job' => $validated['current_job'] ?? null,
                'industry' => $validated['industry'] ?? null,
                'contact_number' => $validated['contact_number'] ?? null,
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('pending');
    }
}
