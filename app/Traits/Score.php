<?php
namespace App\Traits;

use App\Client;

trait Score
{
    public function getScoreByAge(int $age)
    {
        if ($age >= 18 && $age <= 25) {
            return 5;
        } elseif ($age >= 26 && $age <= 35) {
            return 4;
        } elseif ($age >= 36 && $age <= 50) {
            return 3;
        } elseif ($age >= 51 && $age <= 65) {
            return 2;
        } elseif ($age > 65) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getScoreByAnswer(String $answer)
    {
        $letter = strtoupper(substr($answer, 0, 1));
        if ($letter == 'A') {
            return 5;
        } elseif ($letter == 'B') {
            return 4;
        } elseif ($letter == 'C') {
            return 3;
        } elseif ($letter == 'D') {
            return 2;
        } elseif ($letter == 'E' || $letter == '是') {
            return 1;
        } elseif ($letter == '否') {
            return 0;
        } else {
            return 0;
        }
    }

    public function getScoreByInvestedProducts(String $answer)
    {
        $Score = 0;
        $InvestedProducts = json_decode($answer, true);
        foreach ($InvestedProducts as $InvestedProduct) {
            $Score++;
        }
        return $Score;
    }

    public function getMaxInvestmentExperience(Client $Client)
    {
        $MaxInvestmentExperience = min($Client->ClientInvestmentExperience->stock,
            $Client->ClientInvestmentExperience->derivative_warrants,
            $Client->ClientInvestmentExperience->cbbc,
            $Client->ClientInvestmentExperience->futures_and_options,
            $Client->ClientInvestmentExperience->bonds_funds);
        return $MaxInvestmentExperience;
    }

    public function calculateClientScore(Client $Client)
    {
        $ClientScore = [];
        $birthday = \Carbon\Carbon::parse($Client->IDCard->birthday);
        $age = \Carbon\Carbon::now()->diffInYears($birthday);
        $score = $this->getScoreByAge($age);
        $ClientScore[] = ['score' => $score, 'question_text' => '你現時的歲數是', 'answer' => $age];
        $score = $this->getScoreByAnswer($Client->education_level);
        $ClientScore[] = ['score' => $score, 'question_text' => '你的教育程度是', 'answer' => $Client->education_level];
        $MaxInvestmentExperience = $this->getMaxInvestmentExperience($Client);
        $score = $this->getScoreByAnswer($MaxInvestmentExperience);
        $ClientScore[] = ['score' => $score, 'question_text' => '你有多少年投資經驗(不包括儲蓄、定期儲蓄及外幣儲蓄)', 'answer' => $MaxInvestmentExperience];
        $score = $this->getScoreByInvestedProducts($Client->ViewClientQuestionnaire->a1);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q1, 'answer' => $Client->ViewClientQuestionnaire->a1];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a2);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q2, 'answer' => $Client->ViewClientQuestionnaire->a2];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a3);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q3, 'answer' => $Client->ViewClientQuestionnaire->a3];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a4);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q4, 'answer' => $Client->ViewClientQuestionnaire->a4];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a5);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q5, 'answer' => $Client->ViewClientQuestionnaire->a5];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a6);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q6, 'answer' => $Client->ViewClientQuestionnaire->a6];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a7);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q7, 'answer' => $Client->ViewClientQuestionnaire->a7];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a8);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q8, 'answer' => $Client->ViewClientQuestionnaire->a8];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a9);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q9, 'answer' => $Client->ViewClientQuestionnaire->a9];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a10);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q10, 'answer' => $Client->ViewClientQuestionnaire->a10];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a11);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q11, 'answer' => $Client->ViewClientQuestionnaire->a11];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a12);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q12, 'answer' => $Client->ViewClientQuestionnaire->a12];
        $score = $this->getScoreByAnswer($Client->ViewClientQuestionnaire->a13);
        $ClientScore[] = ['score' => $score, 'question_text' => $Client->ViewClientQuestionnaire->q13, 'answer' => $Client->ViewClientQuestionnaire->a13];
        return $ClientScore;
    }

    public function 投資者特徵(int $score)
    {
        if ($score <= 19) {
            return "保守型";
        } else if ($score >= 20 && $score <= 29) {
            return "穩健型";
        } else if ($score >= 30 && $score <= 39) {
            return "平衡型";
        } else if ($score >= 40 && $score <= 49) {
            return "增長型";
        } else if ($score >= 50) {
            return "進取型";
        }
    }

    public function 風險承受程度(int $score)
    {
        if ($score <= 19) {
            return "低";
        } else if ($score >= 20 && $score <= 29) {
            return "低至中";
        } else if ($score >= 30 && $score <= 39) {
            return "中";
        } else if ($score >= 40 && $score <= 49) {
            return "中至高";
        } else if ($score >= 50) {
            return "高";
        }
    }

    public function getLevel(int $score)
    {
        if ($score <= 19) {
            return 1;
        } else if ($score >= 20 && $score <= 29) {
            return 2;
        } else if ($score >= 30 && $score <= 39) {
            return 3;
        } else if ($score >= 40 && $score <= 49) {
            return 4;
        } else if ($score >= 50) {
            return 5;
        }
    }
}
