<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Exam;
use App\Models\User;
use App\Models\Level;
use App\Models\Examiner;
use App\Models\Instansi;
use App\Models\Position;
use App\Models\Appraiser;
use App\Models\Indicator;
use App\Models\ExamSession;
use App\Models\Participant;
use App\Models\Certificate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Instansi::create([
            'title'      => 'BKN',
        ]);
        Instansi::create([
            'title'      => 'Menpan',
        ]);

        Level::create([
            'title'      => 'Umum',
        ]);

        Level::create([
            'title'      => 'Pertama',
        ]);
        Level::create([
            'title'      => 'Muda',
        ]);
        Position::create([
            'title'      => 'Umum',
            'level_id'      => '1',
        ]);
        Position::create([
            'title'      => 'ASDMA',
            'level_id'      => '2',
        ]);
        Position::create([
            'title'      => 'Asesor',
            'level_id'      => '3',
        ]);
        User::create([
            'name'      => 'Administrator',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('password'),
        ]);

        Participant::create([
        'position_id'   => '2',
        'name'          => 'Randi',
        'nip'           => '123',
        'instansi_id'   => '1',
        'password'      => 'password',
        'type'          => 'KJ'
        ]);

        Participant::create([
            'position_id'   => '3',
            'name'          => 'Adi',
            'nip'           => '345',
            'instansi_id'   => '1',
            'password'      => 'password',
            'type'          => 'KJ'
            ]);

        Participant::create([
            'position_id'   => '2',
            'name'          => 'Budi',
            'nip'           => '678',
            'instansi_id'   => '1',
            'password'      => 'password',
            'type'          => 'KJ'
            ]);

        Participant::create([
            'position_id'   => '2',
            'name'          => 'Ani',
            'nip'           => '910',
            'instansi_id'   => '2',
            'password'      => 'password',
            'type'          => 'PJ'
             ]);

             Participant::create([
                'position_id'   => '3',
                'name'          => 'Deni',
                'nip'           => '112',
                'instansi_id'   => '2',
                'password'      => 'password',
                'type'          => 'PJ'
             ]);
             Participant::create([
                'position_id'   => '3',
                'name'          => 'Ari',
                'nip'           => '134',
                'instansi_id'   => '2',
                'password'      => 'password',
                'type'          => 'KJ'
             ]);

             Exam::create([
                'title'             => 'SBE Periode 1',
                'position_id'       => '1',
                'duration'          => '10',
                'description'       => 'SBE Periode 1',
                'random_question'   => 'N',
                'random_answer'     => 'N',
                'show_answer'       => 'N',
                'type'              => 'Teks',
             ]);

             Exam::create([
                'title'             => 'SBE Periode 2',
                'position_id'       => '1',
                'duration'          => '10',
                'description'       => 'SBE Periode 2',
                'random_question'   => 'N',
                'random_answer'     => 'N',
                'show_answer'       => 'N',
                'type'              => 'Teks',
             ]);

             Exam::create([
                'title'             => 'CBT Periode 1',
                'position_id'       => '2',
                'duration'          => '10',
                'description'       => 'CBT Periode 1',
                'random_question'   => 'Y',
                'random_answer'     => 'Y',
                'show_answer'       => 'Y',
                'type'              => 'PG',
             ]);

             Exam::create([
                'title'             => 'CBT Periode 2',
                'position_id'       => '3',
                'duration'          => '10',
                'description'       => 'CBT Periode 2',
                'random_question'   => 'Y',
                'random_answer'     => 'Y',
                'show_answer'       => 'Y',
                'type'              => 'PG',
             ]);


             ExamSession::create([
                'title'         => 'SBE Periode 1',
                'exam_id'       => '1',
                'start_time'    => '2023-09-13 22:48:00',
                'end_time'      => '2023-09-30 22:48:00',
             ]);

             ExamSession::create([
                'title'         => 'SBE Periode 2',
                'exam_id'       => '2',
                'start_time'    => '2023-09-13 22:48:00',
                'end_time'      => '2023-09-30 22:48:00',
             ]);

             ExamSession::create([
                'title'         => 'CBT Periode 1',
                'exam_id'       => '3',
                'start_time'    => '2023-09-13 22:48:00',
                'end_time'      => '2023-09-30 22:48:00',
             ]);

             ExamSession::create([
                'title'         => 'CBT Periode 2',
                'exam_id'       => '4',
                'start_time'    => '2023-09-13 22:48:00',
                'end_time'      => '2023-09-30 22:48:00',
             ]);


             Examiner::create([
                'nip'               => '111',
                'name'              => 'Sarni',
                'role'              => 'Penguji',
                'examsession_id'    => '3',
                'password'          => 'password',

             ]);
             Examiner::create([
                'nip'               => '222',
                'name'              => 'Agung',
                'role'              => 'Penguji',
                'examsession_id'    => '3',
                'password'          => 'password',

             ]);

             Examiner::create([
                'nip'               => '333',
                'name'              => 'Porman',
                'role'              => 'Penguji',
                'examsession_id'    => '4',
                'password'          => 'password',

             ]);

             Examiner::create([
                'nip'               => '444',
                'name'              => 'Halawiyah',
                'role'              => 'Penguji',
                'examsession_id'    => '4',
                'password'          => 'password',

             ]);


             Examiner::create([
                'nip'               => '555',
                'name'              => 'Rizky',
                'role'              => 'Sekre',
                'examsession_id'    => '1',
                'password'          => 'password',

             ]);

             Examiner::create([
                'nip'               => '666',
                'name'              => 'Ayu',
                'role'              => 'Sekre',
                'examsession_id'    => '1',
                'password'          => 'password',

             ]);

             Examiner::create([
                'nip'               => '777',
                'name'              => 'Wino',
                'role'              => 'Sekre',
                'examsession_id'    => '2',
                'password'          => 'password',

             ]);

             Examiner::create([
                'nip'               => '888',
                'name'              => 'Fani',
                'role'              => 'Sekre',
                'examsession_id'    => '2',
                'password'          => 'password',

             ]);

             Indicator::create([
                'title'               => 'Pemahaman Jabatan Yang Dituju',
                'cathegory'           => 'Wawancara',
                'sub'                 => 'KAPASITAS DIRI',
                'subsub'              => 'KAPASITAS DIRI',
                'status'              => '1',

             ]);

             Indicator::create([
                'title'               => 'Pengalaman',
                'cathegory'           => 'Wawancara',
                'sub'                 => 'KAPASITAS DIRI',
                'subsub'              => 'KAPASITAS DIRI',
                'status'              => '1',

             ]);

             Indicator::create([
                'title'               => 'Usaha Pencapaian',
                'cathegory'           => 'Wawancara',
                'sub'                 => 'KAPASITAS DIRI',
                'subsub'              => 'KAPASITAS DIRI',
                'status'              => '1',

             ]);

             Indicator::create([
                'title'               => 'Konten/Isi',
                'cathegory'           => 'Wawancara',
                'sub'                 => 'KOMUNIKASI',
                'subsub'              => 'PRESENTASI/TULISAN',
                'status'              => '1',

             ]);

             Indicator::create([
                'title'               => 'Konsep',
                'cathegory'           => 'Wawancara',
                'sub'                 => 'KOMUNIKASI',
                'subsub'              => 'PRESENTASI/TULISAN',
                'status'              => '1',

             ]);

             Indicator::create([
                'title'               => 'Penyajian',
                'cathegory'           => 'Wawancara',
                'sub'                 => 'KOMUNIKASI',
                'subsub'              => 'PRESENTASI/LISAN',
                'status'              => '1',

             ]);

             Certificate::create([
                'nip'               => '123',
                'title'             => 'Ujikom Februari',
                'link'              => 'https://ds.bkn.go.id/public/doc/1292b04817484dfba7c1122a9a951572'
             ]);


    }
}
