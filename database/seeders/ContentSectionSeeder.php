<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContentSection;

class ContentSectionSeeder extends Seeder
{
    public function run()
    {
        $sections = [
            [
                'key' => 'vision',
                'content' => [
                    'en' => 'To be a leading institution that transforms lives through accessible knowledge, innovative learning spaces, and community engagement. We envision a future where every individual has the resources and support to pursue lifelong learning and achieve their full potential.',
                    'tl' => 'Maging nangungunang institusyon na bumabago ng buhay sa pamamagitan ng naaabot na kaalaman, makabagong espasyo ng pag-aaral, at pakikilahok ng komunidad. Nakikita namin ang hinaharap kung saan ang bawat indibidwal ay may mga mapagkukunan at suporta upang magpatuloy ng habambuhay na pag-aaral at makamit ang kanilang buong potensyal.'
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'mission',
                'content' => [
                    'en' => 'Our mission is to provide equitable access to information, foster intellectual growth, and serve as a community hub for learning and cultural enrichment. We are committed to delivering exceptional library services, promoting literacy, supporting research, and creating inclusive programs that meet the diverse needs of our community.',
                    'tl' => 'Ang aming misyon ay magbigay ng pantay na access sa impormasyon, paunlarin ang intelektwal na paglaki, at magsilbing sentro ng komunidad para sa pag-aaral at pagpapayaman ng kultura. Kami ay nakatuon sa paghahatid ng kahusayan na mga serbisyo ng aklatan, pagsusulong ng literacy, pagsuporta sa pananaliksik, at paglikha ng mga inklusibong programa na tumutugon sa magkakaibang pangangailangan ng aming komunidad.'
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'goals',
                'content' => [
                    'en' => 'Expand our digital collection to reach 100,000 titles by 2026. Increase community program participation by 50% through innovative workshops and events. Enhance accessibility with extended hours and mobile library services. Foster partnerships with local schools and organizations. Implement cutting-edge technology to improve user experience and resource discovery.',
                    'tl' => 'Palawakin ang aming digital na koleksyon upang maabot ang 100,000 titulo sa 2026. Dagdagan ang pakikilahok sa programa ng komunidad ng 50% sa pamamagitan ng makabagong mga workshop at kaganapan. Pahusayin ang accessibility sa pamamagitan ng pinalawig na oras at mobile library services. Bumuo ng partnership sa mga lokal na paaralan at organisasyon. Ipatupad ang pinakabagong teknolohiya upang mapabuti ang karanasan ng user at pagtuklas ng resources.'
                ],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'key' => 'about_us',
                'content' => [
                    'en' => 'Established in 1995, our library has been serving the community for over 28 years. With a collection of over 50,000 books, periodicals, and digital resources, we provide comprehensive information services to students, researchers, and the general public. Our state-of-the-art facilities include computer labs, study rooms, children\'s section, and multimedia resources.',
                    'tl' => 'Itinatag noong 1995, ang aming aklatan ay naglilingkod sa komunidad sa loob ng mahigit 28 taon. Sa koleksyon na mahigit 50,000 libro, periodicals, at digital resources, nagbibigay kami ng komprehensibong serbisyo ng impormasyon sa mga estudyante, mananaliksik, at publiko. Ang aming makabagong pasilidad ay kinabibilangan ng computer labs, study rooms, children\'s section, at multimedia resources.'
                ],
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            ContentSection::create($section);
        }

        $this->command->info('Content sections seeded successfully!');
    }
}