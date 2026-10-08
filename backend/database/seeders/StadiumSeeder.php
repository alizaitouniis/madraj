<?php

namespace Database\Seeders;

use App\Enums\ZoneShape;
use App\Models\Stadium;
use Illuminate\Database\Seeder;

/**
 * The stadium and its four default zones (Figma: Stadium info 6:74, Stadium builder 33:132).
 * Street address, parking prices and the accessibility phone are still unknown, so they stay null.
 */
class StadiumSeeder extends Seeder
{
    public function run(): void
    {
        $stadium = Stadium::create([
            'name' => 'ملعب الأرز',
            'city' => 'بيروت',
            'opens_minutes_before' => 120,
            'parking' => [
                ['name' => 'P1', 'description' => 'بجانب الملعب', 'price' => null],
                ['name' => 'P2', 'description' => '5 دقائق سيراً', 'price' => null],
            ],
            'parking_note' => 'تمتلئ المواقف قبل ساعة من الانطلاق.',
            'allowed_items' => ['حقائب صغيرة', 'أعلام الفريق', 'الهواتف والشواحن'],
            'forbidden_items' => ['الشهب والألعاب النارية', 'الزجاجات', 'المظلات الكبيرة'],
            'entry_note' => 'أحضر بطاقة هويتك. يجب أن يطابق اسمك التذكرة.',
            'accessibility_note' => 'أماكن للكراسي المتحركة في المدرج الرئيسي. اتصل بنا للحجز.',
        ]);

        // Positions match the builder frame; the pitch is fixed (config madraj.stadium_canvas).
        $zones = [
            ['name' => 'المدرج الرئيسي', 'description' => 'مسقوف، على طول خط المنتصف', 'capacity' => 600, 'colour' => '#12452F', 'x' => 140, 'y' => 155, 'width' => 300, 'height' => 52],
            ['name' => 'الدرجة الأولى', 'description' => 'الجهة المقابلة، على طول خط المنتصف', 'capacity' => 900, 'colour' => '#5E9C7A', 'x' => 140, 'y' => 421, 'width' => 300, 'height' => 52],
            ['name' => 'المدرج الشمالي', 'description' => 'خلف المرمى الشمالي', 'capacity' => 540, 'colour' => '#B9CFC1', 'x' => 452, 'y' => 219, 'width' => 52, 'height' => 190],
            ['name' => 'المدرج الجنوبي', 'description' => 'خلف المرمى الجنوبي', 'capacity' => 540, 'colour' => '#B9CFC1', 'x' => 76, 'y' => 219, 'width' => 52, 'height' => 190],
        ];

        foreach ($zones as $sort => $zone) {
            $stadium->zones()->create($zone + ['shape' => ZoneShape::Straight, 'rotation' => 0, 'sort' => $sort]);
        }
    }
}
