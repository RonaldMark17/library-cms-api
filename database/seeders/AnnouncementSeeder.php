<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\User;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        $adminUser = User::where('role', 'admin')->first();

        $announcements = [
            [
                'title' => [
                    'en' => 'Library Extended Hours During Finals Week',
                    'tl' => 'Pinalawak na Oras ng Aklatan sa Finals Week'
                ],
                'content' => [
                    'en' => 'We are pleased to announce that the library will extend its operating hours during the upcoming finals week (December 11-17, 2025). The library will be open from 7:00 AM to 11:00 PM to provide students with additional study time and resources. All facilities including study rooms, computer labs, and the quiet reading area will be available. Please note that reference desk services will be available until 9:00 PM.',
                    'tl' => 'Kami ay natutuwa na ipahayag na ang aklatan ay magpapalawig ng oras ng operasyon sa paparating na finals week (Disyembre 11-17, 2025). Ang aklatan ay bukas mula 7:00 AM hanggang 11:00 PM upang magbigay sa mga estudyante ng karagdagang oras sa pag-aaral at resources. Lahat ng pasilidad kasama ang study rooms, computer labs, at quiet reading area ay available. Pakitandaan na ang reference desk services ay available hanggang 9:00 PM.'
                ],
                'priority' => 'high',
                'published_at' => now()->subDays(2),
                'expires_at' => now()->addDays(10),
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'title' => [
                    'en' => 'New Digital Collection: Filipino Literature Archive',
                    'tl' => 'Bagong Digital Collection: Filipino Literature Archive'
                ],
                'content' => [
                    'en' => 'We are excited to launch our new Filipino Literature Digital Archive, featuring over 5,000 digitized works from classic to contemporary Filipino authors. This collection includes novels, poetry, essays, and literary criticism spanning from the Spanish colonial period to the present. Access is free for all library members through our online portal. We extend our gratitude to the National Commission for Culture and the Arts for their support in this digitization project.',
                    'tl' => 'Kami ay nasasabik na ilunsad ang aming bagong Filipino Literature Digital Archive, na naglalaman ng mahigit 5,000 digitized works mula sa classic hanggang contemporary Filipino authors. Ang koleksyong ito ay kinabibilangan ng mga nobela, tula, sanaysay, at literary criticism mula sa Spanish colonial period hanggang sa kasalukuyan. Ang access ay libre para sa lahat ng library members sa pamamagitan ng aming online portal. Aming ipinahahayag ang aming pasasalamat sa National Commission for Culture and the Arts para sa kanilang suporta sa digitization project na ito.'
                ],
                'priority' => 'high',
                'published_at' => now()->subDays(5),
                'expires_at' => null,
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'title' => [
                    'en' => 'Winter Reading Program for Children',
                    'tl' => 'Winter Reading Program para sa mga Bata'
                ],
                'content' => [
                    'en' => 'Join us for our annual Winter Reading Program designed for children ages 5-12! Running from December 15, 2025 to January 15, 2026, this program encourages young readers to explore books through fun activities, storytelling sessions, and prizes. Children who complete the reading challenge will receive a certificate and a book of their choice. Registration is now open at the Children\'s Section desk or online through our website. Limited slots available!',
                    'tl' => 'Sumali sa amin para sa aming taunang Winter Reading Program na idinisenyo para sa mga bata edad 5-12! Tumatakbo mula Disyembre 15, 2025 hanggang Enero 15, 2026, ang programang ito ay nag-uudyok sa mga batang mambabasa na tuklasin ang mga libro sa pamamagitan ng masayang mga aktibidad, storytelling sessions, at premyo. Ang mga batang makakumpleto ng reading challenge ay makakatanggap ng certificate at isang libro na kanilang pinili. Ang registration ay bukas na sa Children\'s Section desk o online sa pamamagitan ng aming website. Limited slots available!'
                ],
                'priority' => 'medium',
                'published_at' => now()->subDays(7),
                'expires_at' => now()->addDays(30),
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'title' => [
                    'en' => 'Scheduled System Maintenance - December 12',
                    'tl' => 'Naka-iskedyul na System Maintenance - Disyembre 12'
                ],
                'content' => [
                    'en' => 'Please be advised that our online catalog and digital resources will be temporarily unavailable on December 12, 2025, from 12:00 AM to 6:00 AM due to scheduled system maintenance and upgrades. The physical library will remain open during regular hours, but online services including catalog search, account access, and database resources will be offline. We apologize for any inconvenience and appreciate your understanding.',
                    'tl' => 'Mangyaring pansinin na ang aming online catalog at digital resources ay pansamantalang hindi available sa Disyembre 12, 2025, mula 12:00 AM hanggang 6:00 AM dahil sa naka-iskedyul na system maintenance at upgrades. Ang pisikal na aklatan ay mananatiling bukas sa regular na oras, ngunit ang online services kasama ang catalog search, account access, at database resources ay offline. Humihingi kami ng paumanhin sa anumang abala at pinahahalagahan ang inyong pag-unawa.'
                ],
                'priority' => 'medium',
                'published_at' => now()->subDays(10),
                'expires_at' => now()->addDays(5),
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'title' => [
                    'en' => 'Workshop: Research Skills and Academic Writing',
                    'tl' => 'Workshop: Research Skills at Academic Writing'
                ],
                'content' => [
                    'en' => 'Enhance your research and writing skills! Join our comprehensive workshop series on December 14-16, 2025. Topics include: effective database searching, evaluating sources, citation management with Zotero, academic writing structure, and avoiding plagiarism. The workshop is free for students and faculty. Sessions run from 2:00 PM to 5:00 PM each day. Register online or at the Reference Desk. Materials and light refreshments will be provided.',
                    'tl' => 'Pahusayin ang inyong research at writing skills! Sumali sa aming comprehensive workshop series sa Disyembre 14-16, 2025. Mga paksa: epektibong database searching, pagsusuri ng sources, citation management gamit ang Zotero, academic writing structure, at pag-iwas sa plagiarism. Ang workshop ay libre para sa mga estudyante at faculty. Ang sessions ay tumatakbo mula 2:00 PM hanggang 5:00 PM bawat araw. Mag-register online o sa Reference Desk. Ang materials at light refreshments ay ibibigay.'
                ],
                'priority' => 'medium',
                'published_at' => now()->subDays(12),
                'expires_at' => now()->addDays(8),
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
            [
                'title' => [
                    'en' => 'Holiday Closure Notice',
                    'tl' => 'Paunawa ng Pagsasara sa Holiday'
                ],
                'content' => [
                    'en' => 'The library will be closed on December 24-26 and December 31, 2025 to January 1, 2026 in observance of the Christmas and New Year holidays. We will resume normal operations on December 27 and January 2. All borrowed materials due during the closure period will have their due dates automatically extended. Online resources remain accessible 24/7. We wish everyone a joyful holiday season!',
                    'tl' => 'Ang aklatan ay sarado sa Disyembre 24-26 at Disyembre 31, 2025 hanggang Enero 1, 2026 bilang pagdiriwang ng Christmas at New Year holidays. Babalik kami sa normal na operasyon sa Disyembre 27 at Enero 2. Lahat ng hiniram na materials na due sa panahon ng closure ay awtomatikong mapapalawak ang due dates. Ang online resources ay mananatiling accessible 24/7. Nais naming batiin ang lahat ng masayang holiday season!'
                ],
                'priority' => 'low',
                'published_at' => now()->subDays(15),
                'expires_at' => now()->addDays(25),
                'is_active' => true,
                'created_by' => $adminUser->id,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }

        $this->command->info('Announcements seeded successfully!');
    }
}