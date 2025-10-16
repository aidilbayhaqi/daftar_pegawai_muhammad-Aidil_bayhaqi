<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\Jabatan;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        // Units
        $units = [
            ['id'=>1,'nama_unit'=>'Sekretariat Utama'],
            ['id'=>2,'nama_unit'=>'Biro Kepegawaian'],
            ['id'=>3,'nama_unit'=>'DKP'],
            ['id'=>4,'nama_unit'=>'Surveyor Pemetaan'],
        ];
        foreach($units as $u){
            Unit::updateOrCreate(['id'=>$u['id']],$u);
        }

        // Jabatan
        $jabatans = [
            ['id'=>1,'nama_jabatan'=>'Kepala Sekretariat','eselon'=>'IV/e','golongan'=>'IV/e'],
            ['id'=>2,'nama_jabatan'=>'Penyusun Laporan Keuangan','eselon'=>'IV/a','golongan'=>'IV/a'],
            ['id'=>3,'nama_jabatan'=>'Surveyor Pemetaan Pertama','eselon'=>'III/c','golongan'=>'III/c'],
            ['id'=>4,'nama_jabatan'=>'Analis Data Survei','eselon'=>'III/b','golongan'=>'III/b'],
            ['id'=>5,'nama_jabatan'=>'Perancang Per-UUan Utama','eselon'=>'IV/e','golongan'=>'IV/e'],
        ];
        foreach($jabatans as $j){
            Jabatan::updateOrCreate(['id'=>$j['id']],$j);
        }

        // Karyawan
        // ======= Karyawan =======
        $karyawans = [
            [
                'nip' => '12130569001',
                'nama' => 'Saifulloh Rifai',
                'tempat_lahir' => 'Banjarnegara',
                'tanggal_lahir' => '1968-03-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Melon No.16 Dian Asri',
                'no_hp' => '081234567890',
                'npwp' => '1234567890',
                'agama' => 'Islam',
                'foto' => null,
                'unit_id' => 1,
                'jabatan_id' => 1
            ],
            [
                'nip' => '12130569002',
                'nama' => 'Ahmad Fauzi',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1975-12-28',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Garuda Gg. Mangga RT002',
                'no_hp' => '081234567891',
                'npwp' => '1234567891',
                'agama' => 'Islam',
                'foto' => null,
                'unit_id' => 4,
                'jabatan_id' => 5
            ],
            [
                'nip' => '12130569003',
                'nama' => 'Siti Aminah',
                'tempat_lahir' => 'Trengalek',
                'tanggal_lahir' => '1992-07-07',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Trengalek No.7',
                'no_hp' => '081234567892',
                'npwp' => '1234567892',
                'agama' => 'Islam',
                'foto' => null,
                'unit_id' => 4,
                'jabatan_id' => 5
            ],
            [
                'nip' => '12130569004',
                'nama' => 'Budi Santoso',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1987-05-03',
                'jenis_kelamin' => 'L',
                'alamat' => 'Perum Jombor Baru',
                'no_hp' => '081234567893',
                'npwp' => '1234567893',
                'agama' => 'Islam',
                'foto' => null,
                'unit_id' => 4,
                'jabatan_id' => 4
            ],
        ];

        foreach($karyawans as $k){
            Karyawan::updateOrCreate(['nip'=>$k['nip']],$k);
        }
    }
}
