<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Drawing;
use App\Models\User;
class CommentController extends Controller
{
    /**
     * Store a new comment.
     */
    public function store(Request $request, $drawing_id)
    {
        $request->validate([
            'text' => 'required|string|max:500',
        ]);

        Comment::create([
            'text' => $request->text,
            'drawing_id' => $drawing_id,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $comment->delete();
        return back()->with('success', 'Comment deleted successfully!');
    }
    
}
