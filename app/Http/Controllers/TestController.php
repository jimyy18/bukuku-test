<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function testOne(Request $request)
    {
        $inputNumber = $request->number;
        $arr = [];
        if ($inputNumber < 1 || $inputNumber >= 1000) {

            return response()->json([
                'message' => 'number min 1, max 1000',
            ]);
        }
        for ($i = 1; $i <= $inputNumber; $i++) {

            if ($i % 3 == 0 && $i % 5 == 0 && $i % 7 == 0) {
                $arr[] = 'FizzBuzz';
            } else if ($i % 3 == 0 && $i % 5 == 0) {
                $arr[] = 'Fizz1';
            } else if ($i % 3 == 0 && $i % 7 == 0) {
                $arr[] = 'Fizz2';
            } else if ($i % 5 == 0 && $i % 7 == 0) {
                $arr[] = 'Fizz3';
            } else if ($i % 3 == 0) {
                $arr[] = 'Buzz1';
            } else if ($i % 5 == 0) {
                $arr[] = 'Buzz2';
            } else if ($i % 7 == 0) {
                $arr[] = 'Buzz3';
            } else {
                $arr[] = $i;
            }
        }

        return response()->json([
            'message' => 'success',
            'result' => $arr
        ]);
    }

    public function testTwo(Request $request)
    {

        $validatedData = $request->validate([
            'array_biner' => 'required|array|min:1|max:600',
            'array_biner.*' => 'required|string|regex:/^[01]+$/|max:100',
            'max_count_zero_number' => 'required|integer|min:1|max:100',
            'max_count_one_number' => 'required|integer|min:1|max:100',
        ]);

        $strs = $validatedData['array_biner'];
        $m = $validatedData['max_count_zero_number'];
        $n = $validatedData['max_count_one_number'];

        $dp = array_fill(0, $m + 1, array_fill(0, $n + 1, 0));

        // Iterasi setiap string dalam array
        foreach ($strs as $str) {
            // Hitung jumlah 0 dan 1 dalam string
            $zeros = substr_count($str, '0');
            $ones = substr_count($str, '1');

            // Update DP array dari belakang ke depan
            for ($i = $m; $i >= $zeros; $i--) {
                for ($j = $n; $j >= $ones; $j--) {
                    $dp[$i][$j] = max($dp[$i][$j], $dp[$i - $zeros][$j - $ones] + 1);
                }
            }
        }
        return response()->json([
            'massage' => 'success',
            'result' => $dp[$m][$n]
        ]);
    }

    public function testThree(Request $request)
    {
        // Validasi input dari request
        $validatedData = $request->validate([
            'number' => 'required|array|min:1',
            'number.*' => 'required|integer|min:0',
            'k' => 'required|integer|min:1',
        ]);

        $nums = $validatedData['number'];
        $k = $validatedData['k'];

        $low = max($nums);
        $high = array_sum($nums);


        while ($low < $high) {
            $mid = (int)(($low + $high) / 2);

            // Periksa apakah mungkin membagi nums menjadi k subarray dengan maxSum = $mid
            $currentSum = 0;
            $requiredSubarrays = 1;

            foreach ($nums as $num) {
                $currentSum += $num;

                // Jika currentSum melebihi mid, mulai subarray baru
                if ($currentSum > $mid) {
                    $requiredSubarrays++;
                    $currentSum = $num;
                    // Jika jumlah subarray yang diperlukan melebihi k, break
                    if ($requiredSubarrays > $k) {
                        break;
                    }
                }
            }

            if ($requiredSubarrays <= $k) {
                $high = $mid;
            } else {
                $low = $mid + 1;
            }
        }

        // Kembalikan hasil dalam format JSON
        return response()->json([
            'message' => 'success',
            'result' => $low
        ]);
    }
}
