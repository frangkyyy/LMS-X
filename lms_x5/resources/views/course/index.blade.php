<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <!-- IoT Introduction Image -->
        <div class="card mt-3">
            <div class="card-body text-center">
                <img src="{{ asset('iot/iot.jpg') }}" class="img-fluid w-100" style="height: auto; max-height: 457px; object-fit: cover;" alt="Pengenalan IoT">
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h2>{{$title}}</h2>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="fw-bold">Selamat Datang {{ Auth::user()->name }}</h4>
            </div>
        </div>

        <!-- Course Overview -->
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="fw-bold">Course overview</h4>

                <!-- Filter Buttons -->
                <div class="d-flex gap-2 mb-3 align-items-center">
                    <!-- Category Filter Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            All Categories
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            <li><a class="dropdown-item" href="#" data-filter="all">All Categories</a></li>
                            <li><hr class="dropdown-divider"></li>
                            @foreach($courses as $course)
                                <li><a class="dropdown-item" href="#" data-filter="{{ $course->id }}">{{ $course->full_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Search Input -->
                    <input type="text" class="form-control w-25" id="courseSearch" placeholder="Search courses..." onkeyup="filterCourses()">

                    <!-- Sort Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Sort by course name
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item" href="#" data-sort="name-asc">A to Z</a></li>
                            <li><a class="dropdown-item" href="#" data-sort="name-desc">Z to A</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-sort="semester-asc">Semester (Low to High)</a></li>
                            <li><a class="dropdown-item" href="#" data-sort="semester-desc">Semester (High to Low)</a></li>
                        </ul>
                    </div>

                    <!-- View Toggle -->
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-light active view-toggle" data-view="card">
                            <i class="fas fa-th-large"></i> Card
                        </button>
                        <button type="button" class="btn btn-light view-toggle" data-view="list">
                            <i class="fas fa-list"></i> List
                        </button>
                    </div>
                </div>

                <!-- Course Cards Container -->
                <div class="row" id="coursesContainer">
                    @foreach($courses as $course)
                        <div class="col-md-3 mb-4 course-card" data-category="{{ $course->category_id }}" data-name="{{ strtolower($course->full_name) }}" data-semester="{{ $course->semester }}">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body p-0">
                                    <!-- Gradient Banner with subtle animation -->
                                    <div class="banner-gradient" style="height: 80px;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        transition: all 0.3s ease;">
                                    </div>
                                    <div class="p-3">
                                        <p class="text-muted mb-0">SEMESTER {{ $course->semester }}</p>
                                        <a href="{{ route('course.topikmatkul', ['course_id' => $course->id]) }}" class="fw-bold text-primary d-block mt-2">
                                            {{ $course->short_name }} - {{ $course->full_name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

{{--                <!-- Course Card -->--}}
{{--                @foreach($courses as $course)--}}
{{--                    <div class="card w-25">--}}
{{--                        <div class="card-body p-0">--}}
{{--                            <div class="bg-success" style="height: 80px;"></div> <!-- Banner -->--}}
{{--                            <div class="p-3">--}}
{{--                                <p class="text-muted mb-0">SEMESTER {{ $course['semester'] }}</p>--}}
{{--                                <a href="{{ route('course.topikmatkul', ['course_id' => $course->id]) }}" class="fw-bold text-primary">--}}
{{--                                    {{ $course['short_name'] }} - {{ $course['full_name'] }}--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}

            </div>
        </div>
    </div>
</div>

<script>
    // Filter courses based on search input
    function filterCourses() {
        const input = document.getElementById('courseSearch');
        const filter = input.value.toLowerCase();
        const cards = document.querySelectorAll('.course-card');

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            if (name.includes(filter)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Category filter
    document.querySelectorAll('[data-filter]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const filterValue = this.getAttribute('data-filter');
            const cards = document.querySelectorAll('.course-card');

            // Update dropdown button text
            document.getElementById('categoryDropdown').textContent = this.textContent;

            cards.forEach(card => {
                if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Sort functionality
    document.querySelectorAll('[data-sort]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const sortValue = this.getAttribute('data-sort');
            const container = document.getElementById('coursesContainer');
            const cards = Array.from(document.querySelectorAll('.course-card'));

            // Update dropdown button text
            document.getElementById('sortDropdown').textContent = this.textContent;

            cards.sort((a, b) => {
                if (sortValue === 'name-asc') {
                    return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                } else if (sortValue === 'name-desc') {
                    return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
                } else if (sortValue === 'semester-asc') {
                    return a.getAttribute('data-semester') - b.getAttribute('data-semester');
                } else if (sortValue === 'semester-desc') {
                    return b.getAttribute('data-semester') - a.getAttribute('data-semester');
                }
                return 0;
            });

            // Re-append sorted cards
            cards.forEach(card => container.appendChild(card));
        });
    });

    // View toggle
    document.querySelectorAll('.view-toggle').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.view-toggle').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            if (this.getAttribute('data-view') === 'list') {
                document.getElementById('coursesContainer').classList.add('list-view');
                document.querySelectorAll('.course-card').forEach(card => {
                    card.classList.remove('col-md-3');
                    card.classList.add('col-12');
                });
            } else {
                document.getElementById('coursesContainer').classList.remove('list-view');
                document.querySelectorAll('.course-card').forEach(card => {
                    card.classList.add('col-md-3');
                    card.classList.remove('col-12');
                });
            }
        });
    });
</script>

<script>
    // To apply different gradients to each card
    document.addEventListener('DOMContentLoaded', function() {
        const gradients = [
            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%)',
            'linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%)'
        ];

        const banners = document.querySelectorAll('.banner-gradient');
        banners.forEach((banner, index) => {
            banner.style.background = gradients[index % gradients.length];
        });
    });
</script>

<style>
    .list-view .card {
        flex-direction: row !important;
    }
    .list-view .card-body {
        display: flex;
        align-items: center;
    }
    .list-view .bg-success {
        width: 120px;
        height: auto !important;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }

    /* Different gradient options - you can choose one or rotate through them */
    .banner-gradient {
        background-size: 200% 200%;
        animation: gradientBG 5s ease infinite;
    }

    /* Gradient animation */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>
