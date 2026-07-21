<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = User::where('role', 'author')
            ->withCount('posts')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.authors.index', compact('authors'));
    }

    public function destroy(User $author)
    {
        abort_unless($author->isAuthor(), 404);

        $author->delete();

        return redirect()->route('admin.authors.index')->with('status', 'Author account deleted.');
    }
}
