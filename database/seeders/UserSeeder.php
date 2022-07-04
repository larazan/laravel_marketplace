<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            // [
            //     'first_name' => 'admin',
            //     'last_name' => 'mimin',
            //     'email' => 'mimin@mail.com',
            //     'password' => Hash::make('password'),
            //     'phone' => '08888888888888',
            //     'address1' => 'Wisma Tengger Kandangan Benowo Surabaya Barat',
            //     'isAdmin' => 1 // 1 => admin, 0 => user
            // ],
            // [
            //     'first_name' => 'momon',
            //     'last_name' => 'jose',
            //     'email' => 'momon@mail.com',
            //     'password' => Hash::make('pass1234'),
            //     'phone' => '0889999999999',
            //     'address1' => 'Manukan Tama Tandes Surabaya Barat',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Jane',
            //     'last_name' => 'Farida',
            //     'email' => 'jane_farida@mail.com',
            //     'password' => Hash::make('3ea2a6d1'),
            //     'phone' => '024 1125 4899',
            //     'address1' => 'Gg. Salam No. 809, Payakumbuh 96147, SulBar',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Ian',
            //     'last_name' => 'Nababan',
            //     'email' => 'ian_nababan@mail.com',
            //     'password' => Hash::make('b15e46b3'),
            //     'phone' => '0742 6044 1863',
            //     'address1' => 'Kpg. Cihampelas No. 894, Solok 47325, KalTeng',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Devi',
            //     'last_name' => 'Wulandari',
            //     'email' => 'devi_wulandari@mail.com',
            //     'password' => Hash::make('bd42b63b'),
            //     'phone' => '(+62) 712 4540 379',
            //     'address1' => 'Kpg. Bakau No. 179, Makassar 68954, Banten',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Ayu',
            //     'last_name' => 'Kuswandari',
            //     'email' => 'ayu_kuswandari@mail.com',
            //     'password' => Hash::make('5f783089'),
            //     'phone' => '(+62) 23 9741 4806',
            //     'address1' => 'Gg. Suniaraja No. 43, Jambi 91393, JaTeng',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Anom ',
            //     'last_name' => 'Megantara',
            //     'email' => 'anom_megantara@mail.com',
            //     'password' => Hash::make('b57645e4'),
            //     'phone' => '0653 8787 923',
            //     'address1' => 'Manukan',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Nadine ',
            //     'last_name' => 'Wahyuni',
            //     'email' => 'nadine_wahyuni@mail.com',
            //     'password' => Hash::make('c6b6d8fa'),
            //     'phone' => '0260 1373 3869',
            //     'address1' => 'Jln. Suryo No. 166, Bandar Lampung 93171, DKI',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Eka ',
            //     'last_name' => 'Aryani',
            //     'email' => 'eka_aryani@mail.com',
            //     'password' => Hash::make('a58e829d'),
            //     'phone' => '(+62) 423 7301 3760',
            //     'address1' => 'Jln. Setia Budi No. 259, Subulussalam 78192, KepR',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Dodo ',
            //     'last_name' => 'Dabukke',
            //     'email' => 'dodo_dabukke@mail.com',
            //     'password' => Hash::make('db17ed8d'),
            //     'phone' => '(+62) 423 3659 7998',
            //     'address1' => 'Ds. Cikapayang No. 392, Tangerang Selatan 93552, Aceh',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Clara',
            //     'last_name' => 'Pudjiastuti',
            //     'email' => 'clara_pudjiastuti@mail.com',
            //     'password' => Hash::make('02e324ce'),
            //     'phone' => '0211 7912 3063',
            //     'address1' => 'Jln. Ters. Kiaracondong No. 251, Administrasi Jakarta Utara 70989, Aceh',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Kani',
            //     'last_name' => 'Wijayanti',
            //     'email' => 'kani_wijayanti@mail.com',
            //     'password' => Hash::make('fc34d05b'),
            //     'phone' => '(+62) 305 5006 7893',
            //     'address1' => 'Gg. Sumpah Pemuda No. 118, Sawahlunto 32059, DKI',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Samiah',
            //     'last_name' => 'Wahyuni',
            //     'email' => 'samiah_wahyuni@mail.com',
            //     'password' => Hash::make('7da55436'),
            //     'phone' => '0254 4590 5349',
            //     'address1' => 'Gg. Salak No. 328, Tidore Kepulauan 67073, NTB',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Eko',
            //     'last_name' => 'Najmudin',
            //     'email' => 'eko_najmudin@mail.com',
            //     'password' => Hash::make('a81fc220'),
            //     'phone' => '0752 1773 219',
            //     'address1' => 'Ds. Flora No. 109, Yogyakarta 21452, SumSel',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Kemba',
            //     'last_name' => 'Nugroho',
            //     'email' => 'kemba_nugroho@mail.com',
            //     'password' => Hash::make('cd760217'),
            //     'phone' => '(+62) 219 1298 883',
            //     'address1' => 'Dk. Tambun No. 529, Bitung 11847, NTT',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Opung',
            //     'last_name' => 'Januar',
            //     'email' => 'opung_januar@mail.com',
            //     'password' => Hash::make('038e5afd'),
            //     'phone' => '(+62) 813 5325 282',
            //     'address1' => 'Ds. B.Agam Dlm No. 201, Cirebon 33887, SulSel',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Najwa',
            //     'last_name' => 'Rahmawati',
            //     'email' => 'najwa_rahmawati@mail.com',
            //     'password' => Hash::make('a5460a11'),
            //     'phone' => '0804 2741 421',
            //     'address1' => 'Jln. Panjaitan No. 521, Medan 93837, KalUt',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Gawati',
            //     'last_name' => 'Astuti',
            //     'email' => 'gawati_astuti@mail.com',
            //     'password' => Hash::make('f669d05b'),
            //     'phone' => '(+62) 803 407 590',
            //     'address1' => 'Kpg. Padang No. 254, Bontang 41358, KalBar',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Bagya',
            //     'last_name' => 'Kusumo',
            //     'email' => 'bagya_kusumo@mail.com',
            //     'password' => Hash::make('7b86f394'),
            //     'phone' => '(+62) 410 8847 7207',
            //     'address1' => 'Jln. Haji No. 721, Tegal 88984, Jambi',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Sakura',
            //     'last_name' => 'Wastuti',
            //     'email' => 'sakura_wastuti@mail.com',
            //     'password' => Hash::make('01ce4c53'),
            //     'phone' => '0303 2751 5475',
            //     'address1' => 'Psr. Sampangan No. 257, Gunungsitoli 95560, Lampung',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Sari',
            //     'last_name' => 'Rahimah',
            //     'email' => 'sari_rahimah@mail.com',
            //     'password' => Hash::make('37635b7c'),
            //     'phone' => '0862 9984 1681',
            //     'address1' => 'Psr. Babadan No. 202, Padangpanjang 48655, SulBar',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Chandra',
            //     'last_name' => 'Suwarno',
            //     'email' => 'chandra_suwarno@mail.com',
            //     'password' => Hash::make('4d363e82'),
            //     'phone' => '(+62) 488 8848 409',
            //     'address1' => 'Ds. Surapati No. 471, Pagar Alam 30406, SumUt',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Gasti',
            //     'last_name' => 'Handayani',
            //     'email' => 'gasti_handayani@mail.com',
            //     'password' => Hash::make('f7fb1f64'),
            //     'phone' => '(+62) 474 9649 771',
            //     'address1' => 'Dk. Banal No. 582, Bandung 56534, SulTra',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Hadi',
            //     'last_name' => 'Habibi',
            //     'email' => 'hadi_habibi@mail.com',
            //     'password' => Hash::make('0cff2ade'),
            //     'phone' => '0719 8000 2014',
            //     'address1' => 'Dk. Gremet No. 630, Jayapura 82455, KalTim',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Jane',
            //     'last_name' => 'Palastri',
            //     'email' => 'jane_palastri@mail.com',
            //     'password' => Hash::make('87346afa'),
            //     'phone' => '(+62) 377 1085 468',
            //     'address1' => 'Jln. Bank Dagang Negara No. 520, Surabaya 41896, MalUt',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Gawati',
            //     'last_name' => 'Pudjiastuti',
            //     'email' => 'gawati_pudjiastuti@mail.com',
            //     'password' => Hash::make('16765341'),
            //     'phone' => '0669 4277 072',
            //     'address1' => 'Psr. Suprapto No. 387, Tangerang Selatan 69349, JaBar',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Ajiman',
            //     'last_name' => 'Nashiruddin',
            //     'email' => 'ajiman_nashiruddin@mail.com',
            //     'password' => Hash::make('5aa58811'),
            //     'phone' => '0765 7635 1622',
            //     'address1' => 'Dk. Jagakarsa No. 837, Medan 96444, KalBar',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Nova',
            //     'last_name' => 'Wahyuni',
            //     'email' => 'nova_wahyuni@mail.com',
            //     'password' => Hash::make('10400b05'),
            //     'phone' => '0280 5356 005',
            //     'address1' => 'Gg. Bakau No. 917, Kotamobagu 42964, BaBel',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Enteng',
            //     'last_name' => 'Pradana',
            //     'email' => 'enteng_pradana@mail.com',
            //     'password' => Hash::make('676dd723'),
            //     'phone' => '024 9252 3294',
            //     'address1' => 'Psr. Cihampelas No. 598, Padangsidempuan 63954, SulTeng',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Jarwa',
            //     'last_name' => 'Saragih',
            //     'email' => 'jarwa_saragih@mail.com',
            //     'password' => Hash::make('706acde5'),
            //     'phone' => '(+62) 675 6180 0115',
            //     'address1' => 'Psr. Basoka No. 571, Binjai 68470, Riau',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Kamila',
            //     'last_name' => 'Andriani',
            //     'email' => 'kamila_andriani@mail.com',
            //     'password' => Hash::make('f0162b68'),
            //     'phone' => '0371 0071 7331',
            //     'address1' => 'Psr. Kalimantan No. 627, Kendari 51938, MalUt',
            //     'isAdmin' => 0 
            // ],
            // [
            //     'first_name' => 'Lanjar',
            //     'last_name' => 'Suryono',
            //     'email' => 'lanjar_suryono@mail.com',
            //     'password' => Hash::make('8e2aef7b'),
            //     'phone' => '0824 4794 3864',
            //     'address1' => 'Kpg. B.Agam Dlm No. 897, Subulussalam 74452, KalTeng',
            //     'isAdmin' => 0 
            // ],
            [
                'first_name' => 'Gibze',
                'last_name' => '',
                'email' => 'gibze@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0812-3309-3232',
                'address1' => 'Jl. Kresna, Niwin, Sidorahayu, Kec. Wagir, Kota Malang, Jawa Timur 65158',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'bumi',
                'last_name' => 'superfood',
                'email' => 'bumi_superfood@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '(0341) 835199',
                'address1' => 'JL. Sidorahayu, RT. 012 RW. 03, Niwen, Kauman, Kec. Klojen, Kota Malang, Jawa Timur 65119',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Earth',
                'last_name' => 'Apothecary',
                'email' => 'earth_apothecary@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '(0341) 836612',
                'address1' => 'No. 3, Wagir, Ds Sidorahayu, Niwin, Sidorahayu, Kec. Wagir, Malang, Jawa Timur 65158',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Sorgum',
                'last_name' => 'Lover',
                'email' => 'sorgum_lover@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0823-3823-3888',
                'address1' => 'dusun kalikacang rt 01 rw 05, desa, Kali Kacang, Sidorejo, Sugio, Kabupaten Lamongan, Jawa Timur 62256',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Unis',
                'last_name' => 'Sorgum',
                'email' => 'unis_sorgum@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0822-5757-9117',
                'address1' => 'Jl. Langgarwakaf No.20, Sawo, Babat, Kec. Babat, Kabupaten Lamongan, Jawa Timur 62271',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Fighter',
                'last_name' => '',
                'email' => 'fighter@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0822-4567-9235',
                'address1' => 'taman di dekat Gunung Lapa,, Ares Tengah, Lapa Taman, Dungkek, Kabupaten Sumenep, Jawa Timur 69474',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'KSO',
                'last_name' => 'Tirto',
                'email' => 'kso_tirto@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0815-5181-303',
                'address1' => 'Polowijen, Kec. Blimbing, Kota Malang, Jawa Timur 65126',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Anugerah',
                'last_name' => '18',
                'email' => 'anugerah_18@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0822-3526-3285',
                'address1' => 'Area Sawah, Gunungronggo, Kec. Tajinan, Malang, Jawa Timur 65172',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Floresia',
                'last_name' => 'Organik',
                'email' => 'floresia_organik@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0815-4251-325',
                'address1' => 'Jl. Selomangleng No.143, Pojok, Kec. Mojoroto, Kota Kediri, Jawa Timur 64115',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Agro',
                'last_name' => 'Benih',
                'email' => 'agro_benih@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0822-3622-4356',
                'address1' => 'Menang, Kec. Pagu, Kediri, Jawa Timur 64183',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Purie',
                'last_name' => 'Shop',
                'email' => 'purie_shop@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0822-4562-5341',
                'address1' => 'Sembung, Margopatut, Sawahan, Kabupaten Nganjuk, Jawa Timur 64475',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Danish',
                'last_name' => '',
                'email' => 'danish@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0812-5264-0505',
                'address1' => 'Dusun Sidolegi, Sumberjo, Wonosalam, Sidolegi, Sumberjo, Wonosalam, Kabupaten Jombang, Jawa Timur 61476',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Arva',
                'last_name' => 'Store',
                'email' => 'arva_store@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0812-5327-2461',
                'address1' => 'Hutan, Ngluyu, Kabupaten Nganjuk, Jawa Timur 64452',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Savi',
                'last_name' => 'Store',
                'email' => 'savi_store@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0812-3183-9995',
                'address1' => 'Dusun Gondang, Desa Carangwulung, Wonosalam, Gondang, Carangwulung, Wonosalam, Kabupaten Jombang, Jawa Timur 61476',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Tunas',
                'last_name' => 'Benih',
                'email' => 'tunas_benih@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0856-3017-051',
                'address1' => 'Kedunglumpang, Kec. Mojoagung, Kabupaten Jombang, Jawa Timur 61482',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Dapur',
                'last_name' => 'Mamaku',
                'email' => 'dapur_mamaku@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0812-9878-4888',
                'address1' => 'Dawuhan, Kec. Kademangan, Blitar, Jawa Timur 66161',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Pusat',
                'last_name' => 'Distributor',
                'email' => 'pusat_distributor@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0812-2647-3521',
                'address1' => 'Jl. Anjuk Ladang, Ploso, Kec. Nganjuk, Kabupaten Nganjuk, Jawa Timur 64417',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'DIDINOP',
                'last_name' => '',
                'email' => 'didinop@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0812-2647-3521',
                'address1' => 'Jl. Jenderal Sudirman No.16, Kepanjen Lor, Kec. Kepanjenkidul, Kota Blitar, Jawa Timur 66112',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Nutrisi',
                'last_name' => 'Indah',
                'email' => 'nutrisi_indah@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0889999999999',
                'address1' => 'Manukan',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Pujaseraku',
                'last_name' => '',
                'email' => 'pujaseraku@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '(0355) 335579',
                'address1' => 'Desa Moyoketen, RT.03/RW.04, Kalituri, Waung, Kec. Boyolangu, Kabupaten Tulungagung, Jawa Timur 66235',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Formula',
                'last_name' => 'Mart',
                'email' => 'formula_mart@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0812-4327-3481',
                'address1' => 'Jl. Wadung Asih, Prasungtambak, Prasung, Kec. Buduran, Kabupaten Sidoarjo, Jawa Timur 61252',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Choseed',
                'last_name' => '',
                'email' => 'choseed@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0813-3623-3017',
                'address1' => 'Jl. Temenggungan Ledok, Kesatrian, Kec. Blimbing, Kota Malang, Jawa Timur 65121',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Victory',
                'last_name' => 'Seed',
                'email' => 'victory_seed@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0812-6425-5471',
                'address1' => 'Segolo-golo Eco Park, Area Sawah/Kebun, Panglungan, Wonosalam, Kabupaten Jombang, Jawa Timur 61476',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Kamsya',
                'last_name' => '',
                'email' => 'kamsya@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0822-2573-3568',
                'address1' => 'Kutorejo, Kec. Tuban, Kabupaten Tuban, Jawa Timur 62311',
                'isAdmin' => 0 
            ],
            [
                'first_name' => 'Cyborgh',
                'last_name' => '',
                'email' => 'cyborgh@mail.com',
                'password' => Hash::make('pass1234'),
                'phone' => '0851-0025-0379',
                'address1' => 'Jalan Dokter Soetomo, Serning, Banjaragung, Kec. Bareng, Kabupaten Jombang, Jawa Timur 61474',
                'isAdmin' => 0 
            ],
        ]);
    }
}
