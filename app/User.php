<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
        return '#'; //jer nemamo jos uvijek rutu
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getAvatarAttribute()
    {
        //gravatar
        $email = $this->email;
        $size = 40;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable'); //default columns votable_id votable_type
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();
        if ($voteQuestions->where('votable_id', $question->id)->exists()) {
            $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
        } else {
            $voteQuestions->attach($question, ['vote' => $vote]);
        }

        $question->load('votes'); //prvo refreshuje relationship
        $downVotes = (int)$question->downVotes()->sum('vote'); //iz nekog razloga moze da vrati string, pa kastujemo int
        $upVotes = (int)$question->upVotes()->sum('vote');

        $question->votes_count = $upVotes + $downVotes;
        $question->save();
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();
        if ($voteAnswers->where('votable_id', $answer->id)->exists()) {
            $voteAnswers->updateExistingPivot($answer, ['vote' => $vote]);
        } else {
            $voteAnswers->attach($answer, ['vote' => $vote]);
        }

        $answer->load('votes'); //prvo refreshuje relationship
        $downVotes = (int)$answer->downVotes()->sum('vote'); //iz nekog razloga moze da vrati string, pa kastujemo int
        $upVotes = (int)$answer->upVotes()->sum('vote');

        $answer->votes_count = $upVotes + $downVotes;
        $answer->save();
    }
}
