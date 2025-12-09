<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaffMember;

class StaffMemberSeeder extends Seeder
{
    public function run()
    {
        $staff = [
            [
                'name' => [
                    'en' => 'Dr. Elena Martinez',
                    'tl' => 'Dr. Elena Martinez'
                ],
                'role' => [
                    'en' => 'Head Librarian',
                    'tl' => 'Punong Librarian'
                ],
                'email' => 'elena.martinez@library.com',
                'phone' => '+63 917 123 4567',
                'bio' => [
                    'en' => 'Dr. Martinez has over 20 years of experience in library science and information management. She holds a PhD in Library and Information Science from the University of the Philippines and has published numerous research papers on digital libraries and information literacy.',
                    'tl' => 'Si Dr. Martinez ay may mahigit 20 taong karanasan sa library science at information management. Siya ay may PhD sa Library and Information Science mula sa University of the Philippines at naglathala ng maraming research papers tungkol sa digital libraries at information literacy.'
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Maria Clara Santos',
                    'tl' => 'Maria Clara Santos'
                ],
                'role' => [
                    'en' => 'Reference Librarian',
                    'tl' => 'Reference Librarian'
                ],
                'email' => 'maria.santos@library.com',
                'phone' => '+63 917 234 5678',
                'bio' => [
                    'en' => 'Maria specializes in research assistance and information literacy programs. With 10 years of experience, she helps patrons navigate complex research topics and provides training on database searching and citation management.',
                    'tl' => 'Si Maria ay dalubhasa sa research assistance at information literacy programs. Sa 10 taong karanasan, tumutulong siya sa mga patron na mag-navigate ng komplikadong research topics at nagbibigay ng training sa database searching at citation management.'
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Jose Rizal Cruz',
                    'tl' => 'Jose Rizal Cruz'
                ],
                'role' => [
                    'en' => 'Technical Services Librarian',
                    'tl' => 'Technical Services Librarian'
                ],
                'email' => 'jose.cruz@library.com',
                'phone' => '+63 917 345 6789',
                'bio' => [
                    'en' => 'Jose manages the library\'s cataloging, acquisitions, and digital systems. He ensures that all library materials are properly organized and accessible through our online catalog.',
                    'tl' => 'Si Jose ay namamahala ng cataloging, acquisitions, at digital systems ng aklatan. Tinitiyak niya na lahat ng library materials ay maayos na nakaayos at accessible sa pamamagitan ng aming online catalog.'
                ],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Ana Liza Reyes',
                    'tl' => 'Ana Liza Reyes'
                ],
                'role' => [
                    'en' => 'Children\'s Librarian',
                    'tl' => 'Children\'s Librarian'
                ],
                'email' => 'ana.reyes@library.com',
                'phone' => '+63 917 456 7890',
                'bio' => [
                    'en' => 'Ana creates engaging programs for children including storytelling sessions, reading clubs, and educational workshops. She is passionate about fostering a love for reading in young minds.',
                    'tl' => 'Si Ana ay lumilikha ng nakaka-engage na mga programa para sa mga bata kasama ang storytelling sessions, reading clubs, at educational workshops. Siya ay masigasig sa pagpapaunlad ng pagmamahal sa pagbabasa sa mga batang isipan.'
                ],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Roberto Del Mundo',
                    'tl' => 'Roberto Del Mundo'
                ],
                'role' => [
                    'en' => 'Digital Resources Manager',
                    'tl' => 'Digital Resources Manager'
                ],
                'email' => 'roberto.delmundo@library.com',
                'phone' => '+63 917 567 8901',
                'bio' => [
                    'en' => 'Roberto oversees the library\'s digital collection, e-books, online databases, and technology infrastructure. He provides training on digital resources and maintains the library\'s website and online services.',
                    'tl' => 'Si Roberto ay nangangasiwa ng digital collection, e-books, online databases, at technology infrastructure ng aklatan. Nagbibigay siya ng training sa digital resources at nag-maintain ng website at online services ng aklatan.'
                ],
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Carmen Flores',
                    'tl' => 'Carmen Flores'
                ],
                'role' => [
                    'en' => 'Archives Specialist',
                    'tl' => 'Archives Specialist'
                ],
                'email' => 'carmen.flores@library.com',
                'phone' => '+63 917 678 9012',
                'bio' => [
                    'en' => 'Carmen manages our special collections and historical archives. She preserves rare books, manuscripts, and local history materials, making them accessible to researchers and historians.',
                    'tl' => 'Si Carmen ay namamahala ng aming special collections at historical archives. Nag-iingat siya ng mga rare books, manuscripts, at local history materials, ginagawa itong accessible sa mga researchers at historians.'
                ],
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($staff as $member) {
            StaffMember::create($member);
        }

        $this->command->info('Staff members seeded successfully!');
    }
}