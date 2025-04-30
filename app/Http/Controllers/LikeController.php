<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Drawing;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Like or dislike a drawing.
     */
    public function toggleLike(Request $request, $drawing_id)
    {
        $user_id = Auth::id();

        // Check if user already liked/disliked this drawing
        $existingLike = Like::where('drawing_id', $drawing_id)
                            ->where('user_id', $user_id)
                            ->first();

        if ($existingLike) {
            // If same action, remove the like/dislike
            if ($existingLike->rating == $request->rating) {
                $existingLike->delete();
                return back()->with('success', 'Removed your reaction!');
            }

            // Otherwise, update the rating (switch between like & dislike)
            $existingLike->update(['rating' => $request->rating]);
            return back()->with('success', 'Reaction updated!');
        }

        // If no previous reaction, create a new like/dislike
        Like::create([
            'drawing_id' => $drawing_id,
            'user_id' => $user_id,
            'rating' => $request->rating, // 1 = Like, -1 = Dislike
            
        ]);

        return back()->with('success', 'Reaction added!');
    }
}
