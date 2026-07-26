<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdatePhotoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) : JsonResponse
    {
        $request->validate([
            'profile_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $user = $request->user();

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }
        
        $extension = $request->file('profile_image')->extension();

        $path = $request->file('profile_image')->storeAs(
            "profile_images/{$user->id}",
            "profile.$extension",
            "public"
        );

        $user->update([
            'profile_image' => $path,
        ]);

        return response()->json(['message' => 'Profile Image Updated Successfully']);
    
    }
}
