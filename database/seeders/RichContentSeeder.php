<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Changelog;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\GuestBookEntry;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\Subscriber;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RichContentSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin user ────────────────────────────────────────
        $admin = User::where('is_admin', true)->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'FrugalDev',
                'email' => env('ADMIN_EMAIL', 'admin@frugaldev.site'),
                'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
                'is_admin' => true,
                'display_name' => 'FrugalDev',
            ]);
        }

        // ─── Profile ──────────────────────────────────────────
        Profile::updateOrCreate(['user_id' => $admin->id], [
            'title' => 'Full Stack Developer',
            'bio' => "I build things for the web. Minimalist by choice, pragmatist by nature.\nI believe in shipping fast, keeping it simple, and writing code that works.\n\nNo bloat. No fluff. Just code that solves problems.\n\nCurrently obsessed with terminal UIs, SQLite performance tuning, and making websites load in under 100ms. When I'm not coding, I'm probably reading about distributed systems or tweaking my Neovim config for the 47th time.",
            'social_links' => [
                'github' => 'https://github.com/frugaldev',
                'twitter' => 'https://twitter.com/frugaldev',
                'linkedin' => 'https://linkedin.com/in/frugaldev',
                'email' => 'hello@frugaldev.site',
            ],
            'status_text' => '🟢 Available for freelance work',
            'currently_reading' => 'Designing Data-Intensive Applications — Martin Kleppmann',
            'currently_building' => 'A zero-dependency PHP framework',
            'currently_listening' => 'Synthwave / Lo-fi beats',
            'location' => 'Southeast Asia 🌏',
            'email_public' => 'hello@frugaldev.site',
        ]);

        // ─── Tags ─────────────────────────────────────────────
        $tagNames = [
            'Laravel',
            'PHP',
            'JavaScript',
            'Vue.js',
            'React',
            'Python',
            'Docker',
            'PostgreSQL',
            'SQLite',
            'Tailwind',
            'Linux',
            'API',
            'DevOps',
            'Security',
            'Performance',
            'Architecture',
            'Tutorial',
            'Opinion',
            'Tools',
            'Open Source',
            'Database',
            'Frontend',
            'Backend',
            'CLI',
            'Bash',
        ];
        $tags = [];
        foreach ($tagNames as $name) {
            $tags[$name] = Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        // ─── Projects ─────────────────────────────────────────
        $projects = [
            [
                'title' => 'Budget Tracker CLI',
                'slug' => 'budget-tracker-cli',
                'description' => 'A terminal-based budget tracking tool. No GUI needed.',
                'long_description' => "Built with Python and SQLite. Runs in your terminal.\n\nFeatures:\n- Expense tracking with categories\n- Monthly/yearly reports with ASCII charts\n- CSV/JSON export\n- Multi-currency support\n- Recurring transactions\n- Budget alerts\n\nBecause spreadsheets are overrated.",
                'tech_stack' => ['Python', 'SQLite', 'Click', 'Rich'],
                'repo_url' => 'https://github.com/frugaldev/budget-cli',
                'featured' => true,
                'year' => 2025,
                'status' => 'completed',
                'sort_order' => 1,
                'tags' => ['Python', 'SQLite', 'CLI'],
            ],
            [
                'title' => 'API Gateway',
                'slug' => 'api-gateway',
                'description' => 'Lightweight API gateway with rate limiting and caching.',
                'long_description' => "A self-hosted API gateway built with Laravel.\n\nIncludes:\n- Rate limiting per API key\n- Response caching with configurable TTL\n- API key management dashboard\n- Usage analytics & charts\n- Request/response logging\n- Webhook forwarding\n\nDeploy with a single Docker command.",
                'tech_stack' => ['Laravel', 'PHP', 'Redis', 'Docker'],
                'repo_url' => 'https://github.com/frugaldev/api-gateway',
                'url' => 'https://gateway.frugaldev.site',
                'featured' => true,
                'year' => 2025,
                'status' => 'completed',
                'sort_order' => 2,
                'tags' => ['Laravel', 'PHP', 'Docker', 'API'],
            ],
            [
                'title' => 'Dotfiles',
                'slug' => 'dotfiles',
                'description' => 'My personal dev environment config. Neovim, tmux, zsh, and more.',
                'long_description' => "Everything you need to set up a productive dev environment in 5 minutes.\n\nIncludes:\n- Neovim config with LSP, Treesitter, Telescope\n- tmux with custom keybindings\n- zsh with autosuggestions & syntax highlighting\n- Git aliases & hooks\n- Custom scripts for daily workflows\n\nOne command setup: `./install.sh`",
                'tech_stack' => ['Bash', 'Lua', 'Vim', 'Linux'],
                'repo_url' => 'https://github.com/frugaldev/dotfiles',
                'featured' => false,
                'year' => 2024,
                'status' => 'in_progress',
                'sort_order' => 3,
                'tags' => ['Linux', 'Bash', 'Tools'],
            ],
            [
                'title' => 'MarkdownMail',
                'slug' => 'markdown-mail',
                'description' => 'Write emails in Markdown. Send beautiful HTML newsletters.',
                'long_description' => "A CLI tool that converts Markdown to responsive HTML emails.\n\nFeatures:\n- 12 built-in responsive templates\n- Dark mode support\n- Image optimization\n- SMTP / Mailgun / SES support\n- Subscriber management\n- A/B testing subject lines\n\n```bash\nmdmail send newsletter.md --list=subscribers\n```",
                'tech_stack' => ['Python', 'Jinja2', 'MJML'],
                'repo_url' => 'https://github.com/frugaldev/markdown-mail',
                'featured' => true,
                'year' => 2025,
                'status' => 'completed',
                'sort_order' => 4,
                'tags' => ['Python', 'CLI', 'Open Source'],
            ],
            [
                'title' => 'SQLite Dashboard',
                'slug' => 'sqlite-dashboard',
                'description' => 'Web-based SQLite database browser. Zero dependencies.',
                'long_description' => "Browse, query, and manage SQLite databases from your browser.\n\nFeatures:\n- Schema visualization\n- SQL editor with autocomplete\n- Data export (CSV, JSON, SQL)\n- Table relationships diagram\n- Query history\n- Read-only mode for production\n\nSingle PHP file. No framework needed.",
                'tech_stack' => ['PHP', 'SQLite', 'JavaScript'],
                'repo_url' => 'https://github.com/frugaldev/sqlite-dashboard',
                'url' => 'https://sqlitedash.frugaldev.site',
                'featured' => true,
                'year' => 2026,
                'status' => 'in_progress',
                'sort_order' => 5,
                'tags' => ['PHP', 'SQLite', 'JavaScript', 'Tools'],
            ],
            [
                'title' => 'Deploy.sh',
                'slug' => 'deploy-sh',
                'description' => 'Zero-downtime deployment in a single bash script.',
                'long_description' => "No CI/CD platform needed. Just SSH and bash.\n\nFeatures:\n- Zero-downtime deployments\n- Automatic rollback on failure\n- Health check verification\n- Slack/Discord notifications\n- Multi-server support\n- Docker & bare metal\n\n250 lines of bash. That's it.",
                'tech_stack' => ['Bash', 'Docker', 'SSH'],
                'repo_url' => 'https://github.com/frugaldev/deploy-sh',
                'featured' => false,
                'year' => 2025,
                'status' => 'completed',
                'sort_order' => 6,
                'tags' => ['Bash', 'DevOps', 'Docker'],
            ],
        ];

        foreach ($projects as $pData) {
            $tagList = $pData['tags'] ?? [];
            unset($pData['tags']);
            $project = Project::updateOrCreate(['slug' => $pData['slug']], $pData);
            $project->tags()->sync(collect($tagList)->map(fn($t) => $tags[$t]->id ?? null)->filter()->all());
        }

        // ─── Skills ───────────────────────────────────────────
        $skills = [
            ['name' => 'PHP', 'category' => 'Languages', 'level' => 5, 'sort_order' => 1],
            ['name' => 'JavaScript', 'category' => 'Languages', 'level' => 4, 'sort_order' => 2],
            ['name' => 'Python', 'category' => 'Languages', 'level' => 4, 'sort_order' => 3],
            ['name' => 'TypeScript', 'category' => 'Languages', 'level' => 3, 'sort_order' => 4],
            ['name' => 'SQL', 'category' => 'Languages', 'level' => 5, 'sort_order' => 5],
            ['name' => 'Bash', 'category' => 'Languages', 'level' => 4, 'sort_order' => 6],
            ['name' => 'Go', 'category' => 'Languages', 'level' => 2, 'sort_order' => 7],
            ['name' => 'Laravel', 'category' => 'Frameworks', 'level' => 5, 'sort_order' => 1],
            ['name' => 'Vue.js', 'category' => 'Frameworks', 'level' => 3, 'sort_order' => 2],
            ['name' => 'Tailwind CSS', 'category' => 'Frameworks', 'level' => 4, 'sort_order' => 3],
            ['name' => 'FastAPI', 'category' => 'Frameworks', 'level' => 3, 'sort_order' => 4],
            ['name' => 'Express.js', 'category' => 'Frameworks', 'level' => 3, 'sort_order' => 5],
            ['name' => 'Docker', 'category' => 'Tools', 'level' => 4, 'sort_order' => 1],
            ['name' => 'Git', 'category' => 'Tools', 'level' => 5, 'sort_order' => 2],
            ['name' => 'Linux', 'category' => 'Tools', 'level' => 5, 'sort_order' => 3],
            ['name' => 'Neovim', 'category' => 'Tools', 'level' => 4, 'sort_order' => 4],
            ['name' => 'Nginx', 'category' => 'Tools', 'level' => 4, 'sort_order' => 5],
            ['name' => 'CI/CD', 'category' => 'Tools', 'level' => 3, 'sort_order' => 6],
            ['name' => 'PostgreSQL', 'category' => 'Databases', 'level' => 4, 'sort_order' => 1],
            ['name' => 'SQLite', 'category' => 'Databases', 'level' => 5, 'sort_order' => 2],
            ['name' => 'Redis', 'category' => 'Databases', 'level' => 3, 'sort_order' => 3],
            ['name' => 'MongoDB', 'category' => 'Databases', 'level' => 2, 'sort_order' => 4],
        ];
        foreach ($skills as $skill) {
            Skill::updateOrCreate(['name' => $skill['name']], $skill);
        }

        // ─── Experiences ──────────────────────────────────────
        $experiences = [
            [
                'type' => 'work',
                'title' => 'Senior Full Stack Developer',
                'organization' => 'FrugalDev Labs',
                'location' => 'Remote',
                'start_date' => '2023-01-01',
                'end_date' => null,
                'description' => "Leading development of web applications and open-source tools.\n- Architected microservices handling 50K+ daily requests\n- Reduced deployment time by 80% with custom CI/CD pipeline\n- Mentoring junior developers across 3 time zones",
            ],
            [
                'type' => 'work',
                'title' => 'Backend Developer',
                'organization' => 'TechStartup Inc.',
                'location' => 'Remote',
                'start_date' => '2020-06-01',
                'end_date' => '2022-12-31',
                'description' => "Built REST APIs and microservices for a SaaS platform.\n- Designed database schema serving 100K+ users\n- Implemented real-time notification system\n- Reduced API response time by 60% through query optimization",
            ],
            [
                'type' => 'work',
                'title' => 'Junior Developer',
                'organization' => 'WebAgency Co.',
                'location' => 'Jakarta, Indonesia',
                'start_date' => '2018-09-01',
                'end_date' => '2020-05-31',
                'description' => "Full stack development for client projects.\n- Built 15+ client websites using Laravel & WordPress\n- Managed server infrastructure on DigitalOcean\n- Introduced automated testing, reducing bugs by 40%",
            ],
            [
                'type' => 'work',
                'title' => 'Freelance Web Developer',
                'organization' => 'Self-employed',
                'location' => 'Remote',
                'start_date' => '2017-01-01',
                'end_date' => '2018-08-31',
                'description' => "Built websites and web apps for small businesses.\n- E-commerce, portfolios, booking systems\n- Learned the value of clear communication & deadlines\n- First taste of the grind. Loved every minute.",
            ],
            [
                'type' => 'education',
                'title' => 'Computer Science',
                'organization' => 'University of the Internet',
                'start_date' => '2014-09-01',
                'end_date' => '2018-05-31',
                'description' => "Self-taught + formal education. The best combo.\n- Data structures, algorithms, OS fundamentals\n- Side projects > homework (sorry, professors)\n- Founded the university's first open source club",
            ],
            [
                'type' => 'education',
                'title' => 'AWS Certified Solutions Architect',
                'organization' => 'Amazon Web Services',
                'start_date' => '2022-03-01',
                'end_date' => '2022-03-31',
                'description' => "Because sometimes you need to prove you know things.\n- Associate level certification\n- Focused on cost optimization & scalability\n- Still prefer SQLite on a $5 VPS though 😄",
            ],
        ];
        foreach ($experiences as $exp) {
            Experience::updateOrCreate(
                ['title' => $exp['title'], 'organization' => $exp['organization']],
                $exp
            );
        }

        // ─── Blog Posts ───────────────────────────────────────
        $posts = [
            [
                'title' => 'Why I Chose a Retro Design for My Portfolio',
                'slug' => 'why-retro-design',
                'content_md' => "# Why I Chose a Retro Design\n\nEveryone's building sleek, animated, JavaScript-heavy portfolios. I went the other way.\n\n## The Problem with Modern Web\n\nMost portfolio sites are:\n- 5MB+ page weight\n- Require JavaScript to show text\n- Slow on mobile\n- All look the same\n\n## My Approach\n\nThis site loads in under 50KB. No framework. No build step needed for the frontend. Just HTML, CSS, and a sprinkle of vanilla JS.\n\n## Performance Numbers\n\n| Metric | This Site | Average Portfolio |\n|--------|-----------|------------------|\n| Page Weight | ~30KB | 5-15MB |\n| Time to Interactive | <200ms | 3-8s |\n| JavaScript | ~5KB | 500KB+ |\n| Lighthouse Score | 99 | 60-80 |\n\n## The Design Philosophy\n\nI drew inspiration from:\n- Unix man pages\n- IRC clients\n- Old-school BBS systems\n- GitHub's markdown rendering\n\n## The Result\n\n- Page loads instantly\n- Works without JavaScript\n- Readable on any device\n- Memorable (because nobody does this anymore)\n\n> The best code is no code. The second best is less code.\n\nSometimes going backwards is going forward.",
                'content_html' => '<h1>Why I Chose a Retro Design</h1><p>Everyone\'s building sleek portfolios. I went the other way.</p>',
                'excerpt' => 'Everyone builds the same shiny portfolio. I chose the road less traveled — a retro, terminal-inspired design that loads in under 50KB.',
                'is_published' => true,
                'published_at' => now()->subDays(30),
                'reading_time' => 4,
                'views_count' => 847,
                'tags' => ['Opinion', 'Frontend', 'Performance'],
            ],
            [
                'title' => 'SQLite is Enough for Your Side Project',
                'slug' => 'sqlite-is-enough',
                'content_md' => "# SQLite is Enough\n\nStop spinning up PostgreSQL containers for your todo app.\n\n## When SQLite Works\n\n- Personal projects\n- Small to medium traffic sites (< 100K daily)\n- Prototyping & MVPs\n- CLI tools\n- This site (yes, really)\n\n## The Numbers\n\nSQLite can handle:\n- **100K+ requests/day** easily\n- **Terabytes** of data\n- **Complex queries** with full SQL support\n- **Full-text search** built-in\n- **JSON functions** since 3.38\n\n## How I Use It\n\n```php\n// config/database.php\n'default' => 'sqlite',\n\n// That's it. That's the config.\nDB_CONNECTION=sqlite\n```\n\n## WAL Mode: The Secret Sauce\n\n```sql\nPRAGMA journal_mode=WAL;\nPRAGMA busy_timeout=5000;\nPRAGMA synchronous=NORMAL;\n```\n\nThese three lines give you:\n- Concurrent reads during writes\n- Better crash recovery\n- 5x faster write performance\n\n## When NOT to Use SQLite\n\n- Multiple servers writing to the same DB\n- Need real-time replication\n- Write-heavy workloads (> 1000 writes/sec)\n- Your boss says so (pick your battles)\n\n## The Bottom Line\n\nNo Docker. No ports. No passwords. Just a file.\n\n**Ship it.** You can always migrate later (but you probably won't need to).",
                'content_html' => '<h1>SQLite is Enough</h1><p>Stop spinning up PostgreSQL containers for your todo app.</p>',
                'excerpt' => 'You probably don\'t need PostgreSQL for your side project. Here\'s why SQLite might be all you need — and how to squeeze maximum performance out of it.',
                'is_published' => true,
                'published_at' => now()->subDays(25),
                'reading_time' => 5,
                'views_count' => 2341,
                'tags' => ['SQLite', 'Database', 'Tutorial', 'PHP'],
            ],
            [
                'title' => 'Docker for PHP Developers: A No-BS Guide',
                'slug' => 'docker-for-php-developers',
                'content_md' => "# Docker for PHP Developers\n\nYou don't need to understand container orchestration to use Docker. Here's what you actually need.\n\n## The Only Dockerfile You Need\n\n```dockerfile\nFROM php:8.4-fpm-alpine\n\nRUN apk add --no-cache \\\\\n    sqlite-dev \\\\\n    && docker-php-ext-install pdo_sqlite opcache\n\nCOPY . /var/www/html\nWORKDIR /var/www/html\n\nRUN composer install --no-dev --optimize-autoloader\n\nEXPOSE 9000\n```\n\n## Docker Compose for Local Dev\n\n```yaml\nservices:\n  app:\n    build: .\n    volumes:\n      - .:/var/www/html\n    ports:\n      - 8000:80\n```\n\n## Common Mistakes\n\n1. **Running as root** — Always use a non-root user\n2. **Not using multi-stage builds** — Your images are 2GB because of node_modules\n3. **Ignoring .dockerignore** — Stop copying vendor/ into your build context\n4. **Not caching composer install** — Copy composer.json first, install, then copy code\n\n## Production Tips\n\n- Use `opcache.validate_timestamps=0` in production\n- Enable `opcache.preload` for Laravel\n- Use supervisor to manage multiple processes\n- Health checks via curl to `/up`\n\n**Remember:** Docker is a tool, not a religion. Use it when it helps. Skip it when it doesn't.",
                'content_html' => '<h1>Docker for PHP Developers</h1><p>A no-BS guide to Docker for PHP developers.</p>',
                'excerpt' => 'A practical, no-BS guide to using Docker for PHP development. No Kubernetes, no orchestration — just the stuff you actually need.',
                'is_published' => true,
                'published_at' => now()->subDays(18),
                'reading_time' => 6,
                'views_count' => 1567,
                'tags' => ['Docker', 'PHP', 'DevOps', 'Tutorial'],
            ],
            [
                'title' => 'The Art of Writing Clean Laravel Code',
                'slug' => 'clean-laravel-code',
                'content_md' => "# The Art of Writing Clean Laravel Code\n\nAfter 6 years with Laravel, here are the patterns that actually matter.\n\n## 1. Fat Models, Skinny Controllers\n\n```php\n// ❌ Bad: Logic in controller\npublic function store(Request \$request) {\n    \$user = User::create(\$request->all());\n    Mail::send(new WelcomeEmail(\$user));\n    event(new UserRegistered(\$user));\n    Cache::forget('users');\n    return redirect('/dashboard');\n}\n\n// ✅ Good: Logic in model/service\npublic function store(StoreUserRequest \$request) {\n    \$user = UserService::register(\$request->validated());\n    return redirect('/dashboard');\n}\n```\n\n## 2. Use Query Scopes\n\n```php\n// ❌ Repeating conditions everywhere\nBlogPost::where('is_published', true)\n    ->whereNotNull('published_at')\n    ->where('published_at', '<=', now())\n    ->get();\n\n// ✅ Query scope\nBlogPost::published()->latest()->get();\n```\n\n## 3. Configuration Over Magic\n\n- Use config files, not hardcoded values\n- Use `.env` for environment-specific settings\n- Never put secrets in code\n\n## 4. Eloquent Tips\n\n- Use `updateOrCreate()` for upserts\n- Use `firstOrCreate()` over check-then-create\n- Lazy load → Eager load with `with()`\n- Use `chunk()` for large datasets\n\n## The Golden Rule\n\n> Write code for the developer who will maintain it at 3 AM.\n> That developer is probably you.",
                'content_html' => '<h1>Clean Laravel Code</h1><p>After 6 years with Laravel, here are the patterns that actually matter.</p>',
                'excerpt' => 'Practical patterns for writing maintainable Laravel code. No abstract theory — just battle-tested practices from 6 years of Laravel development.',
                'is_published' => true,
                'published_at' => now()->subDays(12),
                'reading_time' => 7,
                'views_count' => 3204,
                'tags' => ['Laravel', 'PHP', 'Architecture', 'Tutorial'],
            ],
            [
                'title' => 'Security Checklist for Laravel Apps',
                'slug' => 'laravel-security-checklist',
                'content_md' => "# Security Checklist for Laravel Apps\n\nA practical checklist before going to production.\n\n## Headers\n- [x] X-Content-Type-Options: nosniff\n- [x] X-Frame-Options: SAMEORIGIN\n- [x] X-XSS-Protection: 1; mode=block\n- [x] Strict-Transport-Security\n- [x] Referrer-Policy\n- [x] Permissions-Policy\n- [x] Remove X-Powered-By\n\n## Application\n- [x] APP_DEBUG=false in production\n- [x] Strong APP_KEY (generated via artisan)\n- [x] CSRF protection on all forms\n- [x] Rate limiting on sensitive endpoints\n- [x] Input validation on all requests\n- [x] SQL injection prevention (use Eloquent)\n\n## Authentication\n- [x] Bcrypt/Argon2 password hashing\n- [x] Session timeout configured\n- [x] Secure cookie flags (Secure, HttpOnly, SameSite)\n- [x] Account lockout after failed attempts\n\n## Infrastructure\n- [x] HTTPS everywhere\n- [x] Firewall configured (only 80, 443 open)\n- [x] Database not exposed to internet\n- [x] Regular backups with tested restore\n- [x] Log monitoring\n\n## Bonus\n- [x] Content Security Policy\n- [x] Subresource Integrity for CDN assets\n- [x] Regular dependency updates\n\n**This is not exhaustive.** But if you check all these boxes, you're ahead of 90% of Laravel apps out there.",
                'content_html' => '<h1>Security Checklist</h1><p>A practical security checklist for Laravel apps.</p>',
                'excerpt' => 'A battle-tested security checklist for Laravel applications. Check these boxes before going to production.',
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'reading_time' => 4,
                'views_count' => 1890,
                'tags' => ['Laravel', 'Security', 'Tutorial'],
            ],
            [
                'title' => 'Why I Still Use Vanilla JavaScript',
                'slug' => 'vanilla-javascript',
                'content_md' => "# Why I Still Use Vanilla JavaScript\n\nReact, Vue, Svelte, Solid, Qwik... I choose none of them for most projects.\n\n## The Problem with Frameworks\n\nFor a portfolio site, a simple form, or a dashboard:\n- React: 45KB gzipped (just the runtime)\n- Vue: 33KB gzipped\n- Vanilla JS: 0KB runtime\n\n## What I Actually Need\n\n```javascript\n// Toggle a menu\ndocument.querySelector('.menu-btn')\n  .addEventListener('click', e => {\n    document.querySelector('.nav').classList.toggle('open');\n  });\n```\n\nI don't need a virtual DOM for this.\n\n## Modern Vanilla JS is Great\n\n- `fetch()` replaced jQuery.ajax\n- Template literals replaced templating\n- `querySelector` replaced jQuery selectors\n- ES modules replaced build tools\n- `localStorage` handles client state\n\n## When I DO Use a Framework\n\n- Complex SPAs with lots of state\n- Real-time collaborative features\n- Large team projects (conventions > freedom)\n\n## The Rule of Thumb\n\n> If your site works fine with a page reload, you don't need a SPA framework.\n\nMost sites fall into this category. Fight me.",
                'content_html' => '<h1>Vanilla JavaScript</h1><p>Why I still use vanilla JS for most projects.</p>',
                'excerpt' => 'You don\'t need React for a contact form. Here\'s why vanilla JavaScript is still my default choice for most web projects.',
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'reading_time' => 5,
                'views_count' => 956,
                'tags' => ['JavaScript', 'Frontend', 'Opinion'],
            ],
            [
                'title' => 'Building a Blog Engine in 200 Lines of PHP',
                'slug' => 'blog-engine-200-lines',
                'content_md' => "# Blog Engine in 200 Lines of PHP\n\nNo framework. No dependencies. Just PHP and SQLite.\n\n## The Stack\n\n- PHP 8.4\n- SQLite 3\n- Markdown (via \$content_html)\n- That's it.\n\n## The Database\n\n```sql\nCREATE TABLE posts (\n  id INTEGER PRIMARY KEY,\n  title TEXT NOT NULL,\n  slug TEXT UNIQUE NOT NULL,\n  content TEXT NOT NULL,\n  published_at DATETIME,\n  created_at DATETIME DEFAULT CURRENT_TIMESTAMP\n);\n```\n\n## The Router (20 lines)\n\n```php\n\$uri = parse_url(\$_SERVER['REQUEST_URI'], PHP_URL_PATH);\n\nmatch(true) {\n  \$uri === '/' => listPosts(),\n  str_starts_with(\$uri, '/post/') => showPost(substr(\$uri, 6)),\n  \$uri === '/rss' => rssFeed(),\n  default => http_response_code(404),\n};\n```\n\n## Why?\n\nBecause sometimes the best way to learn a framework is to build what it does from scratch.\n\n**The full source code is on [GitHub](https://github.com/frugaldev/micro-blog).**",
                'content_html' => '<h1>Blog Engine in 200 Lines</h1><p>No framework. No dependencies. Just PHP and SQLite.</p>',
                'excerpt' => 'Building a complete blog engine from scratch using only PHP and SQLite. No framework, no dependencies — just 200 lines of code.',
                'is_published' => true,
                'published_at' => now()->subDays(1),
                'reading_time' => 8,
                'views_count' => 428,
                'tags' => ['PHP', 'SQLite', 'Tutorial', 'Backend'],
            ],
        ];

        foreach ($posts as $pData) {
            $postTags = $pData['tags'] ?? [];
            unset($pData['tags']);
            $pData['user_id'] = $admin->id;
            $post = BlogPost::updateOrCreate(['slug' => $pData['slug']], $pData);
            $post->tags()->sync(collect($postTags)->map(fn($t) => $tags[$t]->id ?? null)->filter()->all());
        }

        // ─── Comments ─────────────────────────────────────────
        $commentData = [
            'why-retro-design' => [
                ['author_name' => 'terminalfan42', 'author_email' => 'fan@example.com', 'content' => "This is exactly the vibe I've been looking for! Most dev portfolios are so over-engineered. This is refreshing.", 'is_approved' => true],
                ['author_name' => 'css_wizard', 'author_email' => 'css@example.com', 'content' => "Love the terminal aesthetic. Reminds me of the early days of the internet. What font are you using?", 'is_approved' => true],
                ['author_name' => 'minimalist_dev', 'author_email' => 'min@example.com', 'content' => "30KB for a full portfolio site. That's insane. Meanwhile my React hello-world is 2MB 😅", 'is_approved' => true],
            ],
            'sqlite-is-enough' => [
                ['author_name' => 'db_admin_joe', 'author_email' => 'joe@example.com', 'content' => "WAL mode tip is gold. Went from 50ms writes to 8ms on my project. Thanks!", 'is_approved' => true],
                ['author_name' => 'startup_cto', 'author_email' => 'cto@example.com', 'content' => "We're serving 200K daily users with SQLite + Litestream backup. Can confirm — it just works.", 'is_approved' => true],
                ['author_name' => 'postgres_fan', 'author_email' => 'pg@example.com', 'content' => "Interesting take. I still prefer PostgreSQL for the ecosystem, but SQLite has definitely earned its place.", 'is_approved' => true],
                ['author_name' => 'newbie_dev', 'author_email' => 'new@example.com', 'content' => "As a beginner, this is so encouraging. I've been overthinking my stack. Time to just ship it with SQLite!", 'is_approved' => true],
            ],
            'docker-for-php-developers' => [
                ['author_name' => 'docker_noob', 'author_email' => 'noob@example.com', 'content' => "Finally a Docker guide that doesn't assume I know Kubernetes. Bookmarked!", 'is_approved' => true],
                ['author_name' => 'senior_dev_maya', 'author_email' => 'maya@example.com', 'content' => "Tip about multi-stage builds saved us 3GB on our production image. Great article.", 'is_approved' => true],
            ],
            'clean-laravel-code' => [
                ['author_name' => 'laravel_artisan', 'author_email' => 'artisan@example.com', 'content' => "The query scope pattern changed my codebase. So much cleaner now. Thanks for the examples!", 'is_approved' => true],
                ['author_name' => 'code_reviewer', 'author_email' => 'review@example.com', 'content' => "'Write code for the 3AM maintainer' — I'm putting this on a poster in our office. 😂", 'is_approved' => true],
                ['author_name' => 'junior_php', 'author_email' => 'junior@example.com', 'content' => "updateOrCreate() just blew my mind. I've been writing check-then-create everywhere. 🤦", 'is_approved' => true],
            ],
            'vanilla-javascript' => [
                ['author_name' => 'react_lover', 'author_email' => 'react@example.com', 'content' => "I disagree about frameworks, but your argument is well-made. Respect for going against the grain.", 'is_approved' => true],
                ['author_name' => 'htmx_fan', 'author_email' => 'htmx@example.com', 'content' => "Have you tried HTMX? It's the best of both worlds — server-rendered HTML with sprinkles of interactivity.", 'is_approved' => true],
            ],
        ];

        foreach ($commentData as $slug => $comments) {
            $post = BlogPost::where('slug', $slug)->first();
            if ($post) {
                foreach ($comments as $c) {
                    Comment::updateOrCreate(
                        ['blog_post_id' => $post->id, 'author_name' => $c['author_name']],
                        array_merge($c, ['blog_post_id' => $post->id])
                    );
                }
            }
        }

        // ─── Guestbook Entries ────────────────────────────────
        $guestbookEntries = [
            ['nickname' => 'visitor_001', 'message' => 'Cool site! Love the retro vibes. Reminds me of my first GeoCities page 🕹️', 'is_approved' => true, 'ip_address' => '10.0.0.1', 'edit_token' => Str::random(32)],
            ['nickname' => 'code_ninja', 'message' => "Found this site through Hacker News. The ASCII art is *chef's kiss*. Bookmarked!", 'website' => 'https://codeninja.dev', 'is_approved' => true, 'ip_address' => '10.0.0.2', 'edit_token' => Str::random(32)],
            ['nickname' => 'retro_fan', 'message' => 'Finally, a developer portfolio that doesn\'t make my browser cry. Sub-50KB page weight? Respect. 💯', 'is_approved' => true, 'ip_address' => '10.0.0.3', 'edit_token' => Str::random(32)],
            ['nickname' => 'sarah_dev', 'message' => "Your blog posts are incredibly helpful. The SQLite article saved my weekend project. Thank you! 🙏", 'website' => 'https://sarahcodes.io', 'is_approved' => true, 'ip_address' => '10.0.0.4', 'edit_token' => Str::random(32)],
            ['nickname' => 'ascii_artist', 'message' => 'Leaving my mark here:', 'ascii_art' => "  /\\_/\\  \n ( o.o ) \n  > ^ <  \n /|   |\\ \n(_|   |_)", 'is_approved' => true, 'ip_address' => '10.0.0.5', 'edit_token' => Str::random(32)],
            ['nickname' => 'linux_penguin', 'message' => 'I use Arch btw. Nice site. The command palette (Ctrl+K) is a great touch. Fellow keyboard warrior! ⌨️', 'is_approved' => true, 'ip_address' => '10.0.0.6', 'edit_token' => Str::random(32)],
            ['nickname' => 'web_wanderer', 'message' => 'Stumbled upon this from a Reddit thread. The theme creator is amazing — made a synthwave theme for myself 🌅', 'is_approved' => true, 'ip_address' => '10.0.0.7', 'edit_token' => Str::random(32)],
            ['nickname' => 'midnight_coder', 'message' => "3 AM, browsing dev portfolios, and this one hits different. The badge system is sneaky addictive 🏅", 'is_approved' => true, 'ip_address' => '10.0.0.8', 'edit_token' => Str::random(32)],
            ['nickname' => 'old_school', 'message' => "Back in my day, ALL websites looked like this. Kids these days with their SPAs don't know what they're missing. Great work!", 'is_approved' => true, 'ip_address' => '10.0.0.9', 'edit_token' => Str::random(32)],
            ['nickname' => 'maria_ux', 'message' => "As a UX designer, I appreciate the intentional simplicity. It's not minimal because it's lazy — it's minimal because it's focused. 🎯", 'website' => 'https://mariadesigns.co', 'is_approved' => true, 'ip_address' => '10.0.0.10', 'edit_token' => Str::random(32)],
        ];

        foreach ($guestbookEntries as $i => $entry) {
            $entry['created_at'] = now()->subDays(30 - $i * 3);
            GuestBookEntry::updateOrCreate(
                ['nickname' => $entry['nickname'], 'message' => $entry['message']],
                $entry
            );
        }

        // Add some replies to guestbook
        $parentEntry = GuestBookEntry::where('nickname', 'ascii_artist')->first();
        if ($parentEntry) {
            GuestBookEntry::updateOrCreate(
                ['nickname' => 'FrugalDev', 'parent_id' => $parentEntry->id],
                ['nickname' => 'FrugalDev', 'message' => 'Love the cat! Here\'s mine: =^.^=', 'parent_id' => $parentEntry->id, 'is_approved' => true, 'ip_address' => '127.0.0.1', 'edit_token' => Str::random(32)]
            );
        }

        // ─── Testimonials ─────────────────────────────────────
        $testimonials = [
            ['name' => 'Alex Chen', 'role' => 'CTO', 'company' => 'StartupCo', 'content' => "FrugalDev shipped our MVP in 2 weeks. Clean code, zero drama. The kind of developer you want on your team.", 'sort_order' => 1],
            ['name' => 'Priya Sharma', 'role' => 'Senior Developer', 'company' => 'OpenSource Foundation', 'content' => "Great to work with. Writes code that other humans can actually read. Rare skill in this industry.", 'sort_order' => 2],
            ['name' => 'Marcus Johnson', 'role' => 'Product Manager', 'company' => 'TechScale Inc.', 'content' => "Turned our 8-second page load into 200ms. The performance improvements alone paid for the engagement 10x over.", 'sort_order' => 3],
            ['name' => 'Yuki Tanaka', 'role' => 'Lead Developer', 'company' => 'NeoSoft', 'content' => "FrugalDev refactored our legacy codebase without breaking a single feature. Impressive attention to detail and thorough testing.", 'sort_order' => 4],
            ['name' => 'Emma Wilson', 'role' => 'Founder', 'company' => 'CreativeDigital', 'content' => "We needed a developer who could think, not just code. FrugalDev delivered solutions, not just implementations.", 'sort_order' => 5],
        ];
        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], $t);
        }

        // ─── Site Settings ────────────────────────────────────
        $settings = [
            ['key' => 'site_name', 'value' => 'FrugalDev', 'type' => 'string'],
            ['key' => 'site_tagline', 'value' => 'Build more. Bloat less.', 'type' => 'string'],
            ['key' => 'site_description', 'value' => 'Full Stack Developer portfolio. Minimalist, pragmatic, retro.', 'type' => 'string'],
            ['key' => 'footer_text', 'value' => 'Made with <3 and Laravel', 'type' => 'string'],
            ['key' => 'hit_counter', 'value' => '13370', 'type' => 'integer'],
            ['key' => 'ascii_banner', 'value' => " ___                       _ ___\n|  _|_ _ _ _ ___ ___| |  _ ___ _ _\n|  _|  _| | | . | .'| | | | -_| | |\n|_| |_| |___|_  |__,|_|___|___|___|\n            |___|", 'type' => 'text'],
        ];
        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // ─── Changelog ────────────────────────────────────────
        $changelogs = [
            ['version' => '1.0.0', 'title' => 'Initial Release', 'content' => "- Portfolio site launched\n- Blog system with Markdown support\n- Guest book with ASCII art\n- Command palette (Ctrl+K)\n- Three themes: retro, paper, amber", 'released_at' => now()->subMonths(3)],
            ['version' => '1.1.0', 'title' => 'Blog & Comments', 'content' => "- Blog commenting system\n- Comment moderation in admin\n- RSS feeds for posts and comments\n- Reading time estimates\n- Post view counter", 'released_at' => now()->subMonths(2)],
            ['version' => '1.2.0', 'title' => 'Badges & Gamification', 'content' => "- Badge collection system (11 badges)\n- First Visit, Explorer, Night Owl badges\n- Badge rarity system\n- Badge share cards\n- Hidden badge discovery", 'released_at' => now()->subMonths(1)],
            ['version' => '1.3.0', 'title' => 'Theme Creator & Guestbook Threading', 'content' => "- Custom theme creator with 5 presets\n- Live preview & CSS export\n- Guestbook reply threading\n- Message editing with tokens\n- Emoji reactions on entries", 'released_at' => now()->subWeeks(2)],
            ['version' => '1.4.0', 'title' => 'Security & Performance', 'content' => "- HSTS header added\n- X-Powered-By removed\n- OG image generation\n- Sitemap expanded to 10 URLs\n- HTML minification\n- Lazy image loading\n- Static asset caching (30 days)\n- Rate limiting on forms", 'released_at' => now()],
        ];
        foreach ($changelogs as $c) {
            Changelog::updateOrCreate(['version' => $c['version']], $c);
        }

        // ─── Contact Messages ─────────────────────────────────
        $messages = [
            ['name' => 'Recruiter Bob', 'email' => 'bob@techcorp.com', 'subject' => 'Exciting opportunity', 'message' => "Hi FrugalDev,\n\nI came across your portfolio and I'm impressed by your work. We have an exciting full-stack developer position at TechCorp.\n\nWould love to chat!\n\nBest,\nBob", 'is_read' => true, 'ip_address' => '10.0.1.1'],
            ['name' => 'Fellow Dev', 'email' => 'dev@example.com', 'subject' => 'Love your site!', 'message' => "Hey!\n\nJust wanted to say your portfolio is one of the best I've seen. The retro aesthetic with modern functionality is really well done.\n\nWould you be open to collaborating on an open source project?", 'is_read' => false, 'ip_address' => '10.0.1.2'],
            ['name' => 'Student Sarah', 'email' => 'sarah@university.edu', 'subject' => 'Question about your Docker article', 'message' => "Hi!\n\nI'm a CS student and your Docker article really helped me understand containers. Quick question: do you recommend Docker Desktop or Colima for Mac development?\n\nThanks!", 'is_read' => false, 'ip_address' => '10.0.1.3'],
        ];
        foreach ($messages as $m) {
            ContactMessage::updateOrCreate(
                ['email' => $m['email'], 'subject' => $m['subject'] ?? ''],
                $m
            );
        }

        // ─── Subscribers ──────────────────────────────────────
        $subscribers = [
            ['email' => 'reader1@example.com', 'is_verified' => true, 'verified_at' => now()->subDays(20)],
            ['email' => 'reader2@example.com', 'is_verified' => true, 'verified_at' => now()->subDays(15)],
            ['email' => 'devfan@example.com', 'is_verified' => true, 'verified_at' => now()->subDays(10)],
            ['email' => 'blogger@example.com', 'is_verified' => true, 'verified_at' => now()->subDays(5)],
            ['email' => 'newreader@example.com', 'is_verified' => false],
        ];
        foreach ($subscribers as $s) {
            Subscriber::updateOrCreate(['email' => $s['email']], $s);
        }
    }
}
