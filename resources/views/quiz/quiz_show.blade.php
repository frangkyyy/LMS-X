<div class="container mt-5">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('courses.topics', $course->id) }}">{{ $course->full_name }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('topik.showtopicmahasiswa', [$course->id, $section->id]) }}">{{ $section->title }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('sections.show', [$course->id, $section->id]) }}">{{ $subTopic->title }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $quiz->name }}</li>
        </ol>
    </nav>

    <!-- Quiz Title -->
{{--    <h2 class missão de 4">{{ $quiz->name }}</h2>--}}
    <h2 class="text-4xl font-bold">{{ $quiz->name }}</h2>

    <!-- Quiz Details -->
    <div class="card mb-4">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nilai Minimum Lulus:</strong> {{ $quiz->grade_to_pass ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Duration:</strong> {{ $quiz->time_limit ?? 'N/A' }} minutes</li>
                <li class="list-group-item"><strong>Maximum Attempts:</strong> {{ $quiz->max_attempts ?? 'N/A' }}</li>
            </ul>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="quizTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="participants-tab" data-bs-toggle="tab" href="#participants" role="tab" aria-controls="participants" aria-selected="true">Data Peserta Quiz</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="questions-tab" data-bs-toggle="tab" href="#questions" role="tab" aria-controls="questions" aria-selected="false">Pertanyaan Quiz</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="quizTabsContent">
        <!-- Participants Tab -->
        <div class="tab-pane fade show active" id="participants" role="tabpanel" aria-labelledby="participants-tab">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Data Peserta Quiz</h5>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">Copy</button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="exportToExcel()">Excel</button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="exportToPDF()">PDF</button>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="searchInput" class="me-2">Search:</label>
                            <input type="text" class="form-control" id="searchInput" placeholder="Search by Name or NRP">
                        </div>
                    </div>
                    @if($participants->isEmpty())
                        <p>No participant data available yet.</p>
                    @else
                        <table class="table table-bordered" id="participantsTable">
                            <thead>
                            <tr>
                                <th data-sort="name">Nama Peserta <i class="fas fa-sort"></i></th>
                                <th data-sort="nrp">NRP <i class="fas fa-sort"></i></th>
                                <th data-sort="score">Skor <i class="fas fa-sort"></i></th>
                                <th data-sort="attempt">Percobaan Ke- <i class="fas fa-sort"></i></th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($participants as $participant)
                                <tr>
                                    <td>{{ $participant['user']->name ?? 'N/A' }}</td>
                                    <td>{{ $participant['user']->id ?? 'N/A' }}</td>
                                    <td>{{ $participant['highest_score'] ?? 'N/A' }}</td>
                                    <td>{{ $participant['attempt_number'] }}</td>
                                    <td>{{ $participant['start_time'] ? $participant['start_time']->format('d-m-Y H:i') : 'N/A' }}</td>
                                    <td>{{ $participant['end_time'] ? $participant['end_time']->format('d-m-Y H:i') : 'N/A' }}</td>
                                    <td>
                                        @if($participant['highest_score'] !== null && $quiz->grade_to_pass !== null)
                                            @if($participant['highest_score'] >= $quiz->grade_to_pass)
                                                <span class="badge bg-success">Lulus</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Lulus</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Questions Tab -->
        <div class="tab-pane fade" id="questions" role="tabpanel" aria-labelledby="questions-tab">
            @if ($quiz->questions->isEmpty())
                <div class="alert alert-warning mt-3" role="alert">
                    No questions have been added to this quiz yet.
                </div>
            @else
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Questions</h5>
                        @foreach ($quiz->questions as $index => $question)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Question {{ $index + 1 }} ({{ $question->poin }} points)</h6>
                                    <p class="card-text">{!! $question->question_text !!}</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">A: {{ $question->options_a }}</li>
                                        <li class="list-group-item">B: {{ $question->options_b }}</li>
                                        <li class="list-group-item">C: {{ $question->options_c }}</li>
                                        <li class="list-group-item">D: {{ $question->options_d }}</li>
                                    </ul>
                                    <div class="mt-3">
                                        <strong>Correct Answer:</strong> {{ $question->correct_answer }}
                                    </div>
                                    <div class="mt-3 d-flex justify-content-end">
                                        <a href="{{ route('questions.edit', [$quiz->id, $question->id]) }}" class="btn btn-primary btn-sm me-2">Edit</a>
                                        <form action="{{ route('questions.destroy', [$quiz->id, $question->id]) }}" method="POST" onsubmit="return confirmDelete()" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-4">
        <a href="{{ route('questions.create', $quiz->id) }}" class="btn btn-primary">Add More Questions</a>
        <a href="{{ route('sections.show', [$course->id, $section->id]) }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<!-- External Libraries -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- JavaScript for Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Bootstrap Tabs
        const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const targetPane = document.querySelector(this.getAttribute('href'));
                if (targetPane) {
                    document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
                    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
                    this.classList.add('active');
                    targetPane.classList.add('show', 'active');
                }
            });
        });

        // Handle URL Hash for Questions Tab
        if (window.location.hash === '#questions') {
            const questionsTab = document.querySelector('#questions-tab');
            const participantsTab = document.querySelector('#participants-tab');
            if (questionsTab && participantsTab) {
                participantsTab.classList.remove('active');
                document.querySelector('#participants').classList.remove('show', 'active');
                questionsTab.classList.add('active');
                document.querySelector('#questions').classList.add('show', 'active');
            }
        }

        // Search Functionality
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('participantsTable');
        if (searchInput && table) {
            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const rows = table.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const name = row.cells[0].textContent.toLowerCase();
                    const nrp = row.cells[1].textContent.toLowerCase();
                    row.style.display = name.includes(searchTerm) || nrp.includes(searchTerm) ? '' : 'none';
                });
            });
        }

        // Sort Functionality
        const headers = document.querySelectorAll('#participantsTable th[data-sort]');
        headers.forEach(header => {
            header.addEventListener('click', function () {
                const sortKey = this.getAttribute('data-sort');
                const sortIcon = this.querySelector('i');
                const isAsc = !sortIcon.classList.contains('fa-sort-up');

                // Reset sort icons
                headers.forEach(h => {
                    const icon = h.querySelector('i');
                    icon.classList.remove('fa-sort-up', 'fa-sort-down');
                    icon.classList.add('fa-sort');
                });

                // Set current sort icon
                sortIcon.classList.remove('fa-sort');
                sortIcon.classList.add(isAsc ? 'fa-sort-up' : 'fa-sort-down');

                // Sort table
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                rows.sort((a, b) => {
                    let aValue, bValue;
                    switch (sortKey) {
                        case 'name':
                            aValue = a.cells[0].textContent.toLowerCase();
                            bValue = b.cells[0].textContent.toLowerCase();
                            break;
                        case 'nrp':
                            aValue = a.cells[1].textContent.toLowerCase();
                            bValue = b.cells[1].textContent.toLowerCase();
                            break;
                        case 'score':
                            aValue = parseFloat(a.cells[2].textContent) || 0;
                            bValue = parseFloat(b.cells[2].textContent) || 0;
                            break;
                        case 'attempt':
                            aValue = parseInt(a.cells[3].textContent) || 0;
                            bValue = parseInt(b.cells[3].textContent) || 0;
                            break;
                    }
                    return isAsc ? aValue < bValue ? -1 : aValue > bValue ? 1 : 0 : aValue < bValue ? 1 : aValue > bValue ? -1 : 0;
                });

                // Rebuild table
                tbody.innerHTML = '';
                rows.forEach(row => tbody.appendChild(row));
            });
        });

        // Copy to Clipboard
        window.copyToClipboard = function () {
            const table = document.getElementById('participantsTable');
            const rows = table.querySelectorAll('tr');
            let text = Array.from(rows[0].cells)
                .map(cell => cell.textContent.replace(/\s*\u2191|\u2193/g, '').trim())
                .join('\t') + '\n';

            Array.from(rows).slice(1).forEach(row => {
                if (row.style.display !== 'none') {
                    text += Array.from(row.cells)
                        .map(cell => cell.textContent.replace(/\n/g, ' ').trim())
                        .join('\t') + '\n';
                }
            });

            navigator.clipboard.writeText(text)
                .then(() => alert('Table data copied to clipboard!'))
                .catch(err => console.error('Failed to copy:', err));
        };

        // Export to Excel
        window.exportToExcel = function () {
            const table = document.getElementById('participantsTable');
            const rows = table.querySelectorAll('tr');
            const data = [
                Array.from(rows[0].cells).map(cell => cell.textContent.replace(/\s*\u2191|\u2193/g, '').trim())
            ];

            Array.from(rows).slice(1).forEach(row => {
                if (row.style.display !== 'none') {
                    data.push(Array.from(row.cells).map(cell => cell.textContent.replace(/\n/g, ' ').trim()));
                }
            });

            const ws = XLSX.utils.aoa_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Participants');
            XLSX.writeFile(wb, '{{ $quiz->name }}_Participants.xlsx');
        };

        // Export to PDF
        window.exportToPDF = function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.setFontSize(16);
            doc.text('{{ $quiz->name }} - Participant Data', 14, 20);

            const table = document.getElementById('participantsTable');
            const rows = table.querySelectorAll('tr');
            const data = [
                Array.from(rows[0].cells).map(cell => cell.textContent.replace(/\s*\u2191|\u2193/g, '').trim())
            ];

            Array.from(rows).slice(1).forEach(row => {
                if (row.style.display !== 'none') {
                    data.push(Array.from(row.cells).map(cell => cell.textContent.replace(/\n/g, ' ').trim()));
                }
            });

            doc.autoTable({
                head: [data[0]],
                body: data.slice(1),
                startY: 30,
                theme: 'grid',
                styles: { fontSize: 8 },
                headStyles: { fillColor: [41, 128, 185] },
                margin: { top: 30 }
            });

            doc.save('{{ $quiz->name }}_Participants.pdf');
        };

        // Delete Confirmation
        window.confirmDelete = function () {
            return confirm('Are you sure you want to delete this question? This action cannot be undone.');
        };
    });
</script>
