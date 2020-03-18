<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Question $question)
    {
        return $question->answers()->with('user')->simplePaginate(3);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $answer = $question->answers()->create([
            'body' => $request->body,
            'user_id' => Auth::id()
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been submitted successfully',
//                'answer' => $answer potreban nam je i user info
                'answer' => $answer->load('user')
            ]);
        }

        return back()->with('success', 'Your answer has been submitted successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @param \App\Answer $answer
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        return view('answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Question $question
     * @param \App\Answer $answer
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required'
        ]));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been updated',
                'body_html' => $answer->body_html
            ]);
        }

        return redirect()->route('questions.show', $question->slug)->with('successs', 'Your answer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Answer deleted'
            ]);
        }

        return back()->with('success', 'Answer deleted');
    }
}
