<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExternalLink;

class ExternalLinkSeeder extends Seeder
{
    public function run()
    {
        $links = [
            [
                'title' => [
                    'en' => 'National Library of the Philippines',
                    'tl' => 'Pambansang Aklatan ng Pilipinas'
                ],
                'url' => 'https://web.nlp.gov.ph/',
                'description' => [
                    'en' => 'The official repository of the printed and recorded cultural heritage of the Philippines and other intellectual, literary, and information sources.',
                    'tl' => 'Ang opisyal na repositoryo ng nakalimbag at nakarekord na pamana sa kultura ng Pilipinas at iba pang intelektwal, pampanitikan, at mga pinagmumulan ng impormasyon.'
                ],
                'icon' => '🏛️',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Project Gutenberg',
                    'tl' => 'Project Gutenberg'
                ],
                'url' => 'https://www.gutenberg.org/',
                'description' => [
                    'en' => 'Over 70,000 free eBooks available for download. Choose among free epub and Kindle eBooks, download them or read them online.',
                    'tl' => 'Mahigit 70,000 libreng eBooks na available para sa download. Pumili sa mga libreng epub at Kindle eBooks, i-download o basahin online.'
                ],
                'icon' => '📖',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Google Scholar',
                    'tl' => 'Google Scholar'
                ],
                'url' => 'https://scholar.google.com/',
                'description' => [
                    'en' => 'Search scholarly literature across disciplines and sources: articles, theses, books, abstracts and court opinions.',
                    'tl' => 'Maghanap ng scholarly literature sa iba\'t ibang disiplina at sources: mga artikulo, thesis, libro, abstracts at court opinions.'
                ],
                'icon' => '🎓',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Open Library',
                    'tl' => 'Open Library'
                ],
                'url' => 'https://openlibrary.org/',
                'description' => [
                    'en' => 'An open, editable library catalog, building towards a web page for every book ever published.',
                    'tl' => 'Isang bukas, maaaring i-edit na catalog ng aklatan, bumubuo tungo sa web page para sa bawat libro na nai-publish.'
                ],
                'icon' => '📚',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Internet Archive',
                    'tl' => 'Internet Archive'
                ],
                'url' => 'https://archive.org/',
                'description' => [
                    'en' => 'A non-profit library with millions of free books, movies, software, music, websites, and more.',
                    'tl' => 'Isang non-profit na aklatan na may milyun-milyong libreng libro, pelikula, software, musika, websites, at iba pa.'
                ],
                'icon' => '🌐',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'JSTOR',
                    'tl' => 'JSTOR'
                ],
                'url' => 'https://www.jstor.org/',
                'description' => [
                    'en' => 'Digital library for scholars, researchers, and students. Access to academic journals, books, and primary sources.',
                    'tl' => 'Digital library para sa mga iskolar, mananaliksik, at estudyante. Access sa academic journals, libro, at primary sources.'
                ],
                'icon' => '📄',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'DepEd Commons',
                    'tl' => 'DepEd Commons'
                ],
                'url' => 'https://commons.deped.gov.ph/',
                'description' => [
                    'en' => 'Learning resource portal of the Department of Education providing educational materials for students and teachers.',
                    'tl' => 'Learning resource portal ng Kagawaran ng Edukasyon na nagbibigay ng educational materials para sa mga estudyante at guro.'
                ],
                'icon' => '🏫',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Khan Academy',
                    'tl' => 'Khan Academy'
                ],
                'url' => 'https://www.khanacademy.org/',
                'description' => [
                    'en' => 'Free online courses, lessons and practice in various subjects including math, science, and humanities.',
                    'tl' => 'Libreng online courses, mga aralin at praktis sa iba\'t ibang paksa kasama ang math, science, at humanities.'
                ],
                'icon' => '🎯',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'WorldCat',
                    'tl' => 'WorldCat'
                ],
                'url' => 'https://www.worldcat.org/',
                'description' => [
                    'en' => 'The world\'s largest library catalog helping you find library materials online.',
                    'tl' => 'Ang pinakamalaking library catalog sa mundo na tumutulong sa iyo na makahanap ng library materials online.'
                ],
                'icon' => '🌍',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'PubMed',
                    'tl' => 'PubMed'
                ],
                'url' => 'https://pubmed.ncbi.nlm.nih.gov/',
                'description' => [
                    'en' => 'Free search engine accessing primarily the MEDLINE database of references and abstracts on life sciences and biomedical topics.',
                    'tl' => 'Libreng search engine na nag-access sa pangunahing MEDLINE database ng references at abstracts sa life sciences at biomedical topics.'
                ],
                'icon' => '🔬',
                'order' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($links as $link) {
            ExternalLink::create($link);
        }

        $this->command->info('External links seeded successfully!');
    }
}