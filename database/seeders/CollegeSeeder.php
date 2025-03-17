<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\College;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // State Universities
        $stateUniversities = [
            ['college_name' => 'Cotton University'],
            ['college_name' => 'Rabindranath Tagore University'],
            ['college_name' => 'Madhabdev University'],
            ['college_name' => 'Bhattadev University'],
            ['college_name' => 'Gurucharan University'],
            ['college_name' => 'Dibrugarh University'],
            ['college_name' => 'Bodoland University'],
            ['college_name' => 'KK Handique State Open University'],
            ['college_name' => 'Kumar Bhaskar Varma Sanskrit And Ancient Studies University'],
            ['college_name' => 'Majuli University of Culture'],
            ['college_name' => 'Assam Women\'s University'],
            ['college_name' => 'Birangana Sati Sadhani Rajyik Vishwavidyalaya'],
            ['college_name' => 'Assam Science and Technology University'],
            ['college_name' => 'Assam Rajiv Gandhi University of Cooperative Management (ARGUCOM)'],
            ['college_name' => 'Assam Agriculture University'],
            ['college_name' => 'Srimanta Sankaradeva University of Health Sciences'],
            ['college_name' => 'SRI SRI ANIRUDDHADEVA SPORTS UNIVERSITY'],
            ['college_name' => 'Assam Skill University'],
        ];

        // Private Universities
        $privateUniversities = [
            ['college_name' => 'Mahapurusha Srimanta Sankadev University'],
            ['college_name' => 'Assam Don Bosco University'],
            ['college_name' => 'Assam Down Town University'],
            ['college_name' => 'Krishna Kanta Handique University'],
            ['college_name' => 'Kaziranga University'],
            ['college_name' => 'Assam Royal Global University'],
        ];

        // Central Universities
        $centralUniversities = [
            ['college_name' => 'Assam University'],
            ['college_name' => 'Tezpur University'],
            ['college_name' => 'National Law University & Judicial Academy'],
            ['college_name' => 'Central Institute Of Technology'],
        ];

        // CFTI/Institutes of National Importance
        $nationalInstitutes = [
            ['college_name' => 'INDIAN INSTITUTE OF TECHNOLOGY GUWAHATI'],
            ['college_name' => 'Institute of Advanced Science and Technology'],
            ['college_name' => 'INDIAN INSTITUTE OF INFORMATION TECHNOLOGY GUWAHATI'],
            ['college_name' => 'Centre of Plasma Physics'],
            ['college_name' => 'NATIONAL INSTITUTE OF TECHNOLOGY'],
            ['college_name' => 'INDIAN STATISTICAL INSTITUTE'],
            ['college_name' => 'National Institute of Pharmaceutical Education & Research'],
            ['college_name' => 'Central Inland Fisheries Research Centre'],
            ['college_name' => 'Tochklai Tea Research Institute'],
            ['college_name' => 'Rain Forest Research Institute'],
            ['college_name' => 'North East Institute of Science & Technology'],
            ['college_name' => 'Tukai Institute of Social Science'],
            ['college_name' => 'Green Harit Das Institute of Social Change & Development'],
            ['college_name' => 'Lakhimpur Bali Institute of Physical Education'],
        ];
        
        // Lists for random data generation
        $states = [
            'Assam', 'Arunachal Pradesh', 'Manipur', 'Meghalaya', 
            'Mizoram', 'Nagaland', 'Tripura', 'Sikkim',
            'West Bengal', 'Bihar', 'Jharkhand', 'Odisha',
            'Uttar Pradesh', 'Uttarakhand', 'Haryana', 'Punjab',
            'Himachal Pradesh', 'Rajasthan', 'Gujarat', 'Maharashtra',
            'Madhya Pradesh', 'Chhattisgarh', 'Andhra Pradesh', 'Karnataka',
            'Kerala', 'Tamil Nadu', 'Telangana'
        ];
        
        $districts = [
            'Guwahati', 'Dibrugarh', 'Jorhat', 'Silchar', 'Tinsukia', 'Nagaon',
            'Tezpur', 'Nalbari', 'Barpeta', 'Dhubri', 'Goalpara', 'Kokrajhar',
            'Baksa', 'Chirang', 'Udalguri', 'Sonitpur', 'Biswanath', 'Darrang',
            'Morigaon', 'Kamrup', 'Kamrup Metro', 'Nalbari', 'Golaghat', 'Majuli',
            'Lakhimpur', 'Dhemaji', 'Charaideo', 'Sivasagar', 'Dibrugarh'
        ];
        
        // Get type and phase options from College model
        $types = array_keys(College::getTypeOptions());
        $phases = array_keys(College::getPhaseOptions());
        
        // Set default state and district for all colleges
        $allColleges = array_merge($stateUniversities, $privateUniversities, $centralUniversities, $nationalInstitutes);
        
        foreach ($allColleges as $college) {
            // Add random state, district, type, and phase to each college
            $collegeData = array_merge($college, [
                'state' => $states[array_rand($states)],
                'district' => $districts[array_rand($districts)],
                'type' => $types[array_rand($types)],
                'phase' => $phases[array_rand($phases)],
            ]);
            
            DB::table('colleges')->insert($collegeData);
        }
    }
}
