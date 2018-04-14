<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public static function getDistinctQuestions()
    {
        $result = [];
        $questions = DB::table('questions')->select('question')->groupBy('question')->get();
        foreach ($questions as $question) {
            $result[] = $question->question;
        }

        return json_encode($result);
    }
}
