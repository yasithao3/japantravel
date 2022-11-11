<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $leavTypes = [
            [
                'name' => "Paid Leave",
            ],
            [
                'name' => "Sick Leave",
            ]
        ];
        static $order = 0;
        $increment = $order++;
        return [
            'name' => $leavTypes[$increment]['name'],
        ];
    }
}
