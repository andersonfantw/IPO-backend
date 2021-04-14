<?php
namespace App\Traits;

trait Score
{
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
