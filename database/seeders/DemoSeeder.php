<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\BlogPost;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use App\Models\Changelog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'name' => 'FrugalDev',
            'email' => 'admin@frugaldev.site',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'display_name' => 'FrugalDev',
        ]);

        // Profile
        Profile::create([
            'user_id' => $admin->id,
            'title' => 'Full Stack Developer',
            'bio' => "I build things for the web. Minimalist by choice, pragmatist by nature.\nI believe in shipping fast, keeping it simple, and writing code that works.\n\nNo bloat. No fluff. Just code that solves problems.",
            'social_links' => [
                'github' => 'https://github.com/frugaldev',
                'twitter' => 'https://twitter.com/frugaldev',
                'linkedin' => 'https://linkedin.com/in/frugaldev',
                'email' => 'hello@frugaldev.site',
            ],
            'status_text' => 'Available for freelance work',
            'currently_reading' => 'The Pragmatic Programmer',
            'currently_building' => 'This portfolio site',
            'currently_listening' => 'Lo-fi beats',
            'location' => 'Internet',
            'email_public' => 'hello@frugaldev.site',
        ]);

        // Tags
        $tags = [];
        foreach (['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React', 'Python', 'Docker', 'PostgreSQL', 'SQLite', 'Tailwind', 'Linux', 'API'] as $tagName) {
            $tags[$tagName] = Tag::create(['name' => $tagName, 'slug' => Str::slug($tagName)]);
        }

        // Projects
        $p1 = Project::create([
            'title' => 'Budget Tracker CLI',
            'slug' => 'budget-tracker-cli',
            'description' => 'A terminal-based budget tracking tool. No GUI needed.',
            'long_description' => "Built with Python and SQLite. Runs in your terminal.\nFeatures: expense tracking, monthly reports, CSV export, category management.\nBecause spreadsheets are overrated.",
            'tech_stack' => ['Python', 'SQLite', 'Click'],
            'repo_url' => 'https://github.com/frugaldev/budget-cli',
            'featured' => true,
            'year' => 2025,
            'status' => 'completed',
            'sort_order' => 1,
        ]);
        $p1->tags()->attach([$tags['Python']->id, $tags['SQLite']->id]);

        $p2 = Project::create([
            'title' => 'API Gateway',
            'slug' => 'api-gateway',
            'description' => 'Lightweight API gateway with rate limiting and caching.',
            'long_description' => "A self-hosted API gateway built with Laravel.\nIncludes: rate limiting, request caching, API key management, usage analytics.\nDeploy with a single Docker command.",
            'tech_stack' => ['Laravel', 'PHP', 'Redis', 'Docker'],
            'repo_url' => 'https://github.com/frugaldev/api-gateway',
            'url' => 'https://gateway.frugaldev.site',
            'featured' => true,
            'year' => 2025,
            'status' => 'completed',
            'sort_order' => 2,
        ]);
        $p2->tags()->attach([$tags['Laravel']->id, $tags['PHP']->id, $tags['Docker']->id, $tags['API']->id]);

        $p3 = Project::create([
            'title' => 'Dotfiles',
            'slug' => 'dotfiles',
            'description' => 'My personal dev environment config. Vim, tmux, zsh.',
            'tech_stack' => ['Bash', 'Vim', 'Linux'],
            'repo_url' => 'https://github.com/frugaldev/dotfiles',
            'featured' => false,
            'year' => 2024,
            'status' => 'in_progress',
            'sort_order' => 3,
        ]);
        $p3->tags()->attach([$tags['Linux']->id]);

        // Skills
        $skills = [
            ['name' => 'PHP', 'category' => 'Languages', 'level' => 5, 'sort_order' => 1],
            ['name' => 'JavaScript', 'category' => 'Languages', 'level' => 4, 'sort_order' => 2],
            ['name' => 'Python', 'category' => 'Languages', 'level' => 4, 'sort_order' => 3],
            ['name' => 'SQL', 'category' => 'Languages', 'level' => 4, 'sort_order' => 4],
            ['name' => 'Bash', 'category' => 'Languages', 'level' => 3, 'sort_order' => 5],
            ['name' => 'Laravel', 'category' => 'Frameworks', 'level' => 5, 'sort_order' => 1],
            ['name' => 'Vue.js', 'category' => 'Frameworks', 'level' => 3, 'sort_order' => 2],
            ['name' => 'Tailwind CSS', 'category' => 'Frameworks', 'level' => 4, 'sort_order' => 3],
            ['name' => 'Docker', 'category' => 'Tools', 'level' => 4, 'sort_order' => 1],
            ['name' => 'Git', 'category' => 'Tools', 'level' => 5, 'sort_order' => 2],
            ['name' => 'Linux', 'category' => 'Tools', 'level' => 4, 'sort_order' => 3],
            ['name' => 'Vim', 'category' => 'Tools', 'level' => 3, 'sort_order' => 4],
            ['name' => 'PostgreSQL', 'category' => 'Databases', 'level' => 4, 'sort_order' => 1],
            ['name' => 'SQLite', 'category' => 'Databases', 'level' => 4, 'sort_order' => 2],
            ['name' => 'Redis', 'category' => 'Databases', 'level' => 3, 'sort_order' => 3],
        ];
        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        // Experiences
        Experience::create([
            'type' => 'work',
            'title' => 'Senior Developer',
            'organization' => 'FrugalDev Labs',
            'location' => 'Remote',
            'start_date' => '2023-01-01',
            'end_date' => null,
            'description' => 'Building web applications and tools. Shipping fast, breaking nothing.',
        ]);
        Experience::create([
            'type' => 'work',
            'title' => 'Backend Developer',
            'organization' => 'TechStartup Inc.',
            'location' => 'Remote',
            'start_date' => '2020-06-01',
            'end_date' => '2022-12-31',
            'description' => 'Built REST APIs, microservices, and database architectures.',
        ]);
        Experience::create([
            'type' => 'education',
            'title' => 'Computer Science',
            'organization' => 'University of the Internet',
            'start_date' => '2016-09-01',
            'end_date' => '2020-05-31',
            'description' => 'Self-taught + formal education. The best combo.',
        ]);

        // Blog posts
        $post1 = BlogPost::create([
            'user_id' => $admin->id,
            'title' => 'Why I Chose a Retro Design for My Portfolio',
            'slug' => 'why-retro-design',
            'content_md' => "# Why I Chose a Retro Design\n\nEveryone's building sleek, animated, JavaScript-heavy portfolios.\nI went the other way.\n\n## The Problem with Modern Web\n\nMost portfolio sites are:\n- 5MB+ page weight\n- Require JavaScript to show text\n- Slow on mobile\n- All look the same\n\n## My Approach\n\nThis site loads in under 50KB. No framework. No build step needed for the frontend.\nJust HTML, CSS, and a sprinkle of vanilla JS.\n\n## The Result\n\n- Page loads instantly\n- Works without JavaScript\n- Readable on any device\n- Memorable (because nobody does this anymore)\n\n> The best code is no code. The second best is less code.\n\nSometimes going backwards is going forward.",
            'content_html' => '<h1>Why I Chose a Retro Design</h1><p>Everyone\'s building sleek, animated, JavaScript-heavy portfolios. I went the other way.</p>',
            'excerpt' => 'Everyone builds the same shiny portfolio. I chose the road less traveled.',
            'is_published' => true,
            'published_at' => now(),
            'reading_time' => 3,
        ]);
        $post1->tags()->attach([$tags['Linux']->id]);

        $post2 = BlogPost::create([
            'user_id' => $admin->id,
            'title' => 'SQLite is Enough for Your Side Project',
            'slug' => 'sqlite-is-enough',
            'content_md' => "# SQLite is Enough\n\nStop spinning up PostgreSQL containers for your todo app.\n\n## When SQLite Works\n\n- Personal projects\n- Small to medium traffic sites\n- Prototyping\n- CLI tools\n- This site (yes, really)\n\n## The Numbers\n\nSQLite can handle:\n- 100k+ requests/day easily\n- Terabytes of data\n- Complex queries\n- Full-text search\n\n## How I Use It\n\n```php\n// That's it. That's the config.\nDB_CONNECTION=sqlite\n```\n\nNo Docker. No ports. No passwords. Just a file.\n\nShip it.",
            'content_html' => '<h1>SQLite is Enough</h1><p>Stop spinning up PostgreSQL containers for your todo app.</p>',
            'excerpt' => 'You probably don\'t need PostgreSQL for your side project.',
            'is_published' => true,
            'published_at' => now()->subDays(3),
            'reading_time' => 2,
        ]);
        $post2->tags()->attach([$tags['SQLite']->id, $tags['PHP']->id]);

        // Testimonials
        Testimonial::create([
            'name' => 'Tech Lead at Startup',
            'role' => 'CTO',
            'company' => 'StartupCo',
            'content' => 'FrugalDev shipped our MVP in 2 weeks. Clean code, zero drama.',
            'sort_order' => 1,
        ]);
        Testimonial::create([
            'name' => 'Fellow Developer',
            'role' => 'Senior Dev',
            'company' => 'OpenSource Foundation',
            'content' => 'Great to work with. Writes code that other humans can actually read.',
            'sort_order' => 2,
        ]);

        // Site Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'FrugalDev', 'type' => 'string'],
            ['key' => 'site_tagline', 'value' => 'Build more. Bloat less.', 'type' => 'string'],
            ['key' => 'site_description', 'value' => 'Full Stack Developer portfolio. Minimalist, pragmatic, retro.', 'type' => 'string'],
            ['key' => 'footer_text', 'value' => 'Made with <3 and Laravel', 'type' => 'string'],
            ['key' => 'hit_counter', 'value' => '1337', 'type' => 'integer'],
            ['key' => 'ascii_banner', 'value' => " ___                       _ ___\n|  _|_ _ _ _ ___ ___| |  _ ___ _ _\n|  _|  _| | | . | .'| | | | -_| | |\n|_| |_| |___|_  |__,|_|___|___|___|\n            |___|", 'type' => 'text'],
        ];
        foreach ($settings as $s) {
            SiteSetting::create($s);
        }

        // Changelog
        Changelog::create([
            'version' => '1.0.0',
            'title' => 'Initial Release',
            'content' => "- Portfolio site launched\n- Blog system added\n- Guest book enabled\n- Command palette (Ctrl+K)\n- Three themes: retro, paper, amber",
            'released_at' => now(),
        ]);
    }
}
