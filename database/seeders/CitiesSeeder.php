<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // Cairo
            '15 May', 'Al Azbakeyah', 'Al Basatin', 'Tebin', 'El-Khalifa', 'El darrasa',
            'Aldarb Alahmar', 'Zawya al-Hamra', 'El-Zaytoun', 'Sahel', 'El Salam',
            'Sayeda Zeinab', 'El Sharabeya', 'Shorouk', 'El Daher', 'Ataba', 'New Cairo',
            'El Marg', 'Ezbet el Nakhl', 'Matareya', 'Maadi', 'Maasara', 'Mokattam',
            'Manyal', 'Mosky', 'Nozha', 'Waily', 'Bab al-Shereia', 'Bolaq', 'Garden City',
            'Hadayek El-Kobba', 'Helwan', 'Dar Al Salam', 'Shubra', 'Tura', 'Abdeen',
            'Abaseya', 'Ain Shams', 'Nasr City', 'New Heliopolis', 'Masr Al Qadima',
            'Mansheya Nasir', 'Badr City', 'Obour City', 'Cairo Downtown', 'Zamalek',
            'Kasr El Nile', 'Rehab', 'Katameya', 'Madinty', 'Rod Alfarag', 'Sheraton',
            'El-Gamaleya', '10th of Ramadan City', 'Helmeyat Alzaytoun', 'New Nozha',
            'Capital New',

            // Giza
            'Giza', 'Sixth of October', 'Cheikh Zayed', 'Hawamdiyah', 'Al Badrasheen',
            'Saf', 'Atfih', 'Al Ayat', 'Al-Bawaiti', 'ManshiyetAl Qanater', 'Oaseem',
            'Kerdasa', 'Abu Nomros', 'Kafr Ghati', 'Manshiyet Al Bakari', 'Dokki',
            'Agouza', 'Haram', 'Warraq', 'Imbaba', 'Boulaq Dakrour', 'Al Wahat Al Baharia',
            'Omraneya', 'Moneeb', 'Bin Alsarayat', 'Kit Kat', 'Mohandessin', 'Faisal',
            'Abu Rawash', 'Hadayek Alahram', 'Haraneya', 'Hadayek October', 'Saft Allaban',
            'Smart Village', 'Ard Ellwaa',

            // Alexandria
            'Abu Qir', 'Al Ibrahimeyah', 'Azarita', 'Anfoushi', 'Dekheila', 'El Soyof',
            'Ameria', 'El Labban', 'Al Mafrouza', 'El Montaza', 'Mansheya', 'Naseria',
            'Ambrozo', 'Bab Sharq', 'Bourj Alarab', 'Stanley', 'Smouha', 'Sidi Bishr',
            'Shads', 'Gheet Alenab', 'Fleming', 'Victoria', 'Camp Shizar', 'Karmooz',
            'Mahta Alraml', 'Mina El-Basal', 'Asafra', 'Agamy', 'Bakos', 'Boulkly',
            'Cleopatra', 'Glim', 'Al Mamurah', 'Al Mandara', 'Moharam Bek', 'Elshatby',
            'Sidi Gaber', 'North Coast/sahel', 'Alhadra', 'Alattarin', 'Sidi Kerir',
            'Elgomrok', 'Al Max', 'Marina',

            // Dakahlia
            'Mansoura', 'Talkha', 'Mitt Ghamr', 'Dekernes', 'Aga', 'Menia El Nasr',
            'Sinbillawin', 'El Kurdi', 'Bani Ubaid', 'Al Manzala', 'tami al\'amdid',
            'aljamalia', 'Sherbin', 'Mataria', 'Belqas', 'Meet Salsil', 'Gamasa',
            'Mahalat Damana', 'Nabroh',

            // Red Sea
            'Hurghada', 'Ras Ghareb', 'Safaga', 'El Qusiar', 'Marsa Alam', 'Shalatin',
            'Halaib', 'Aldahar',

            // Beheira
            'Damanhour', 'Kafr El Dawar', 'Rashid', 'Edco', 'Abu al-Matamir', 'Abu Homs',
            'Delengat', 'Mahmoudiyah', 'Rahmaniyah', 'Itai Baroud', 'Housh Eissa',
            'Shubrakhit', 'Kom Hamada', 'Badr', 'Wadi Natrun', 'New Nubaria',
            'Alnoubareya',

            // Fayoum
            'Fayoum', 'Fayoum El Gedida', 'Tamiya', 'Snores', 'Etsa', 'Epschway',
            'Yusuf El Sediaq', 'Hadqa', 'Atsa', 'Algamaa', 'Sayala',

            // Gharbia
            'Tanta', 'Al Mahalla Al Kobra', 'Kafr El Zayat', 'Zefta', 'El Santa',
            'Qutour', 'Basion', 'Samannoud',

            // Ismailia
            'Ismailia', 'Fayed', 'Qantara Sharq', 'Qantara Gharb', 'El Tal El Kabier',
            'Abu Sawir', 'Kasasien El Gedida', 'Nefesha', 'Sheikh Zayed',

            // Monufya
            'Shbeen El Koom', 'Sadat City', 'Menouf', 'Sars El-Layan', 'Ashmon', 'Al Bagor',
            'Quesna', 'Berkat El Saba', 'Tala', 'Al Shohada',

            // Minya
            'Minya', 'Minya El Gedida', 'El Adwa', 'Magagha', 'Bani Mazar', 'Mattay',
            'Samalut', 'Madinat El Fekria', 'Meloy', 'Deir Mawas', 'Abu Qurqas', 'Ard Sultan',

            // Qalubia
            'Banha', 'Qalyub', 'Shubra Al Khaimah', 'Al Qanater Charity', 'Khanka',
            'Kafr Shukr', 'Tukh', 'Qaha', 'Obour', 'Khosous', 'Shibin Al Qanater', 'Mostorod',

            // New Valley
            'El Kharga', 'Paris', 'Mout', 'Farafra', 'Balat', 'Dakhla',

            // South Sinai
            'Suez', 'Alganayen', 'Ataqah', 'Ain Sokhna', 'Faysal',

            // Aswan
            'Aswan', 'Aswan El Gedida', 'Drau', 'Kom Ombo', 'Nasr Al Nuba', 'Kalabsha',
            'Edfu', 'Al-Radisiyah', 'Al Basilia', 'Al Sibaeia', 'Abo Simbl Al Siyahia',
            'Marsa Alam',

            // Assiut
            'Assiut', 'Assiut El Gedida', 'Dayrout', 'Manfalut', 'Qusiya', 'Abnoub',
            'Abu Tig', 'El Ghanaim', 'Sahel Selim', 'El Badari', 'Sidfa',

            // Bani Sweif
            'Bani Sweif', 'Beni Suef El Gedida', 'Al Wasta', 'Naser', 'Ehnasia', 'beba',
            'Fashn', 'Somasta', 'Alabbaseri', 'Mokbel',

            // PorSaid
            'PorSaid', 'Port Fouad', 'Alarab', 'Zohour', 'Alsharq', 'Aldawahi', 'Almanakh',
            'Mubarak',

            // Damietta
            'Damietta', 'New Damietta', 'Ras El Bar', 'Faraskour', 'Zarqa', 'alsaru',
            'alruwda', 'Kafr El-Batikh', 'Azbet Al Burg', 'Meet Abou Ghalib', 'Kafr Saad',

            // Sharqia
            'Zagazig', 'Al Ashr Men Ramadan', 'Minya Al Qamh', 'Belbeis', 'Mashtoul El Souq',
            'Qenaiat', 'Abu Hammad', 'El Qurain', 'Hehia', 'Abu Kabir', 'Faccus',
            'El Salihia El Gedida', 'Al Ibrahimiyah', 'Deirb Negm', 'Kafr Saqr',
            'Awlad Saqr', 'Husseiniya', 'san alhajar alqablia'
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name' => $city,
            ]);
        }
    }
}
