<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BMIController extends Controller
{
    //
    public function showForm()
    {
        return view('bmi.form');
    }
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'age' => 'required|numeric|min:20|max:120',
            'gender' => 'required|string|in:male,female,other',
            'height_feet' => 'required|numeric|min:0',
            'height_inches' => 'required|numeric|min:0|max:11',
            'weight' => 'required|numeric|min:0',
        ]);

        $age = $validated['age'];
        $gender = $validated['gender'];
        $heightFeet = $validated['height_feet'];
        $heightInches = $validated['height_inches'];
        $weight = $validated['weight'];

        // Convert height to total inches
        $height = ($heightFeet * 12) + $heightInches;

        // Calculate BMI for weight in pounds and height in inches
        $bmi = ($weight * 703) / ($height ** 2);

        // Determine BMI category
        $category = $this->determineBMICategory($bmi);

        // Return JSON response
        return response()->json([
            'bmi' => round($bmi, 2),
            'category' => $category,
            'age' => $age,
            'gender' => $gender,
        ]);
    }

    private function determineBMICategory($bmi)
    {
        if ($bmi < 18.5) {
            return 'Underweight';
        } elseif ($bmi < 24.9) {
            return 'Normal weight';
        } elseif ($bmi < 29.9) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }
}
