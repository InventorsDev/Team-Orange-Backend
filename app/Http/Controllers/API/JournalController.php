<?php

namespace App\Http\Controllers\API;

use App\Models\Journal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateJournalRequest;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $journals = $user->journals;

        return $this->successResponse('User journals retreived successfully', $journals);
    }


    public function store(CreateJournalRequest $request)
    {

        $journal = Journal::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return $this->createdResponse('Journal Created successfully', $journal);
    }
}
