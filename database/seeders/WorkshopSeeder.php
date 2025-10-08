<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles=[
            'کارگاه برنامه نویسی',
            'کارگاه رباتیک',
            'کارگاه طراحی وب',
            'کارگاه هوش مصنوعی',
            'کارگاه پایگاه داده',
            'کارگاه شبکه',
            'کارگاه امنیت اطلاعات',
            'کارگاه موبایل اپلیکیشن'
        ];
        $title=$titles[array_rand($titles)];


        $teachers=User::where('role','teacher')->get();
        if($teachers->isEmpty()){
            $this->command->info('هیچ استادی پیدا نشد. لطفاً اول استاد بسازید!');
            return;
        }
        foreach($teachers as $teacher){
            for($i=0;$i<3;$i++){
                if (empty($availableTitles)) {
                    $availableTitles = $titles; // اگر تموم شد، دوباره پر می‌کنیم
                }

                $key = array_rand($availableTitles);
                $title = $availableTitles[$key];

                // عنوان استفاده شده را حذف می‌کنیم
                unset($availableTitles[$key]);
                Workshop::factory()->create([
                    'teacher_id'=>$teacher->id,
                    'title'=>$title,
                    'description' => 'این یک کارگاه آموزشی برای ' . $title . ' است.',
                    'status' => ['active','inactive'][rand(0,1)]
                ]);

            }
        }
        $this->command->info('Workshopها با موفقیت ساخته شدند.');

    }
}
