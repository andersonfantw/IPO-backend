<?php
namespace App\Traits;

trait Algorithm
{
    public function LCSubStr($X, $Y, $m, $n): int
    {
        // Create a table to store lengths of
        // longest common suffixes of substrings.
        // Notethat LCSuff[i][j] contains length
        // of longest common suffix of X[0..i-1]
        // and Y[0..j-1]. The first row and
        // first column entries have no logical
        // meaning, they are used only for
        // simplicity of program
        $LCSuff = array_fill(0, $m + 1,
            array_fill(0, $n + 1, null));
        $result = 0; // To store length of the
        // longest common substring

        // Following steps build LCSuff[m+1][n+1]
        // in bottom up fashion.
        for ($i = 0; $i <= $m; $i++) {
            for ($j = 0; $j <= $n; $j++) {
                if ($i == 0 || $j == 0) {
                    $LCSuff[$i][$j] = 0;
                } else if ($X[$i - 1] == $Y[$j - 1]) {
                    $LCSuff[$i][$j] = $LCSuff[$i - 1][$j - 1] + 1;
                    $result = max($result,
                        $LCSuff[$i][$j]);
                } else {
                    $LCSuff[$i][$j] = 0;
                }
            }
        }
        return $result;
    }

    public function LongestCommonSubstring($str1, $str2, &$subStr): int
    {
        $subStr = "";

        if ($str1 == "" || $str2 == "") {
            return 0;
        }

        $num = array();
        $maxlen = 0;
        $lastSubsBegin = 0;
        $subStrBuilder = "";
        $str1Len = strlen($str1);
        $str2Len = strlen($str2);

        for ($i = 0; $i < $str1Len; $i++) {
            for ($j = 0; $j < $str2Len; $j++) {
                if ($str1[$i] != $str2[$j]) {
                    $num[$i][$j] = 0;
                } else {
                    if (($i == 0) || ($j == 0)) {
                        $num[$i][$j] = 1;
                    } else {
                        $num[$i][$j] = 1 + $num[$i - 1][$j - 1];
                    }

                    if ($num[$i][$j] > $maxlen) {
                        $maxlen = $num[$i][$j];

                        $thisSubsBegin = $i - $num[$i][$j] + 1;

                        if ($lastSubsBegin == $thisSubsBegin) {
                            $subStrBuilder .= $str1[$i];
                        } else {
                            $lastSubsBegin = $thisSubsBegin;
                            $subStrBuilder = "";
                            $subStrBuilder .= substr($str1, $lastSubsBegin, ($i + 1) - $lastSubsBegin);
                        }
                    }
                }
            }
        }

        $subStr = $subStrBuilder;

        return $maxlen;
    }
}
