<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseContent;
use App\Models\CourseContentComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CourseContentCommentController extends Controller
{
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add comments.');
        }

        // Simple validation
        $validated = $request->validate([
            'comment' => 'required|string|min:3|max:1000',
            'course_content_id' => 'required|integer|exists:course_contents,id'
        ], [
            'comment.required' => 'Comment is required.',
            'comment.min' => 'Comment must be at least 3 characters long.',
            'comment.max' => 'Comment cannot exceed 1000 characters.',
            'course_content_id.exists' => 'Selected course content does not exist.'
        ]);

        try {
            // Create the comment
            CourseContentComment::create([
                'user_id' => Auth::id(),
                'course_content_id' => $validated['course_content_id'],
                'comment' => trim($validated['comment']),
            ]);

            return redirect()->back()->with('success', 'Your comment has been added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sorry, we couldn\'t save your comment. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        $comment = CourseContentComment::findOrFail($id);

        // Ensure user can only edit their own comments
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'You can only edit your own comments.');
        }

        // Check if comment is not too old (e.g., 30 minutes)
        if ($comment->created_at->diffInMinutes(now()) > 30) {
            return redirect()->back()->with('error', 'Comments can only be edited within 30 minutes of posting.');
        }

        $validated = $request->validate([
            'comment' => [
                'required',
                'string',
                'min:3',
                'max:1000',
                'regex:/^[\s\S]*\S[\s\S]*$/'
            ]
        ]);

        try {
            $comment->update([
                'comment' => trim($validated['comment']),
                'updated_at' => now()
            ]);

            return redirect()->back()->with('success', 'Comment updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to update comment', [
                'comment_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Failed to update comment. Please try again.');
        }
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $comment = CourseContentComment::findOrFail($id);
        // Ensure user can only delete their own comments or is admin
        if ($comment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'You can only delete your own comments.');
        }

        try {
            $comment->delete();

            \Log::info('Comment deleted', [
                'comment_id' => $comment->id,
                'deleted_by' => Auth::id()
            ]);

            return redirect()->back()->with('success', 'Comment deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to delete comment', [
                'comment_id' => $comment->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Failed to delete comment. Please try again.');
        }
    }
}
