<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GenerateCaptcha
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Only generate if not already in session
        if (!session()->has('captcha_expression') || !session()->has('captcha_answer')) {
            $this->generateMathCaptcha();
        }

        return $next($request);
    }

    /**
     * Generate a random math CAPTCHA
     */
    private function generateMathCaptcha()
    {
        $num1 = rand(5, 50);
        $num2 = rand(2, 30);
        $operator = ['+', '-', '*'][array_rand([0, 1, 2])];

        // Calculate answer
        switch ($operator) {
            case '+':
                $answer = $num1 + $num2;
                break;
            case '-':
                $answer = $num1 - $num2;
                break;
            case '*':
                $answer = $num1 * $num2;
                break;
        }

        $expression = "$num1 $operator $num2";

        // Store in session
        session(['captcha_expression' => $expression]);
        session(['captcha_answer' => $answer]);
    }
}