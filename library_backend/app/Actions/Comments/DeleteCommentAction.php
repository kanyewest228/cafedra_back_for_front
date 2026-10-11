<?php

namespace App\Actions\Comments;

use App\Models\Comment;

class DeleteCommentAction
{
    /**
     * Delete a comment and its child replies.
     */
    public function execute(Comment $comment): void
    {
        $comment->delete();
    }
}
