<x-public-layout pageTitle="Projects" metaDescription="FrugalDev projects and portfolio.">

    <h1>$ ls -la projects/</h1>

    {{-- Filters --}}
    <div class="mt-1" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
        <span class="mono text-muted" style="font-size:11px">$ filter --by</span>

        {{-- Status filter --}}
        <select id="filterStatus" onchange="filterProjects()"
            style="font-size:11px;background:var(--bg2);color:var(--text);border:1px solid var(--border);padding:2px 6px;font-family:var(--mono)">
            <option value="all">all status</option>
            <option value="completed">[done]</option>
            <option value="in_progress">[wip]</option>
        </select>

        {{-- Tech stack filter --}}
        <select id="filterTech" onchange="filterProjects()"
            style="font-size:11px;background:var(--bg2);color:var(--text);border:1px solid var(--border);padding:2px 6px;font-family:var(--mono)">
            <option value="all">all tech</option>
            @foreach($techStacks as $tech)
                <option value="{{ strtolower($tech) }}">{{ $tech }}</option>
            @endforeach
        </select>

        {{-- Sort dropdown --}}
        <select id="sortBy" onchange="sortProjects(this.value)"
            style="font-size:11px;background:var(--bg2);color:var(--text);border:1px solid var(--border);padding:2px 6px;font-family:var(--mono)"
            aria-label="Sort projects">
            <option value="default">default order</option>
            <option value="name">by name</option>
            <option value="year-desc">newest first</option>
            <option value="year-asc">oldest first</option>
        </select>

        {{-- View toggle --}}
        <button onclick="toggleView()" class="btn"
            style="font-size:9px;padding:2px 8px;box-shadow:1px 1px 0px var(--heading)" id="viewToggle">[grid]</button>

        <span class="mono text-muted" style="font-size:10px;margin-left:auto" id="projectCount">{{ count($projects) }}
            projects</span>
    </div>

    {{-- Table View --}}
    <div class="mt-2" id="tableView">
        <table class="retro-table">
            <thead>
                <tr>
                    <th>name</th>
                    <th>description</th>
                    <th>tech</th>
                    <th>year</th>
                    <th>status</th>
                    <th>links</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr class="project-row" data-status="{{ $project->status }}"
                        data-tech="{{ strtolower(implode(',', $project->tech_stack)) }}">
                        <td><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a></td>
                        <td class="text-muted" style="max-width:200px">{{ Str::limit($project->description, 50) }}</td>
                        <td><span style="font-size:11px">{{ implode(', ', array_slice($project->tech_stack, 0, 3)) }}</span>
                        </td>
                        <td>{{ $project->year }}</td>
                        <td>
                            @if($project->status === 'completed')<span class="text-green">[done]</span>
                            @elseif($project->status === 'in_progress')<span class="blink text-accent">[wip]</span>
                            @else<span class="text-muted">[archived]</span>
                            @endif
                        </td>
                        <td>
                            @if($project->url)<a href="{{ $project->url }}" target="_blank">[live]</a> @endif
                            @if($project->repo_url)<a href="{{ $project->repo_url }}" target="_blank">[repo]</a>@endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Grid View (hidden by default) --}}
    <div class="mt-2" id="gridView" style="display:none">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:12px">
            @foreach($projects as $project)
                <div class="ascii-border project-card" data-status="{{ $project->status }}"
                    data-tech="{{ strtolower(implode(',', $project->tech_stack)) }}" style="padding:12px">
                    <a href="{{ route('projects.show', $project->slug) }}">
                        <h3 style="font-size:12px;margin-bottom:4px">{{ $project->title }}</h3>
                    </a>
                    <div class="text-muted" style="font-size:11px;margin-bottom:8px">
                        {{ Str::limit($project->description, 80) }}
                    </div>
                    <div style="font-size:10px">
                        @foreach(array_slice($project->tech_stack, 0, 4) as $tech)
                            <span class="tag">{{ $tech }}</span>
                        @endforeach
                    </div>
                    <div class="mono" style="font-size:10px;margin-top:6px;display:flex;justify-content:space-between">
                        <span>{{ $project->year }}</span>
                        <span>
                            @if($project->status === 'completed')<span class="text-green">[done]</span>
                            @elseif($project->status === 'in_progress')<span class="text-accent">[wip]</span>
                            @endif
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if($projects->isEmpty())
        <p class="text-muted mono mt-2">drwxr-xr-x 0 items</p>
    @endif

    <script>
        function filterProjects() {
            const status = document.getElementById('filterStatus').value;
            const tech = document.getElementById('filterTech').value;
            let visible = 0;

            document.querySelectorAll('.project-row, .project-card').forEach(el => {
                const s = el.dataset.status;
                const t = el.dataset.tech;
                const matchStatus = status === 'all' || s === status;
                const matchTech = tech === 'all' || t.includes(tech);
                const show = matchStatus && matchTech;
                el.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            // Count only from visible view
            document.getElementById('projectCount').textContent = Math.ceil(visible / 2) + ' projects';
        }

        let isGrid = false;
        function toggleView() {
            isGrid = !isGrid;
            document.getElementById('tableView').style.display = isGrid ? 'none' : '';
            document.getElementById('gridView').style.display = isGrid ? '' : 'none';
            document.getElementById('viewToggle').textContent = isGrid ? '[table]' : '[grid]';
        }

        // Sort projects
        function sortProjects(mode) {
            const tbody = document.querySelector('#tableView tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const grid = document.querySelector('#gridView > div');
            const cards = Array.from(grid.querySelectorAll('.project-card'));

            const sorter = (a, b) => {
                if (mode === 'name') return a.querySelector('a').textContent.localeCompare(b.querySelector('a').textContent);
                if (mode === 'year-desc') return (b.dataset.year || '0') - (a.dataset.year || '0');
                if (mode === 'year-asc') return (a.dataset.year || '0') - (b.dataset.year || '0');
                return 0;
            };
            rows.sort(sorter).forEach(r => tbody.appendChild(r));
            cards.sort(sorter).forEach(c => grid.appendChild(c));
        }
    </script>

</x-public-layout>