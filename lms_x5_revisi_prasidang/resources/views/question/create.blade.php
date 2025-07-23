@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-primary text-white rounded-top">
                <h2 class="mb-0">Create New Quiz #{{ $quiz->id }}</h2>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('questions.store', $quiz->id) }}" method="POST" id="quiz-form">
                    @csrf

                    <div id="questions-container">
                        <div class="card mb-3 question-block shadow-sm" data-index="0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title">Question 1</h5>
                                    <button type="button" class="btn btn-danger btn-sm delete-question" style="display: none;">Delete</button>
                                </div>
                                <input type="hidden" name="questions[0][quiz_id]" value="{{ $quiz->id }}">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Question Text</label>
                                    <textarea class="form-control rounded" id="question_text_1" name="questions[0][question_text]" rows="4"></textarea>
                                    <div class="invalid-feedback">Please provide the question text.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Points</label>
                                    <input type="number" class="form-control rounded" name="questions[0][poin]" min="0" required>
                                    <div class="invalid-feedback">Please provide a valid number of points (0 or more).</div>
                                </div>
                                <div class="options-container">
                                    <h6 class="fw-bold">Options</h6>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control rounded" name="questions[0][options_a]" placeholder="Option A" required>
                                            <div class="invalid-feedback">Please provide Option A.</div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <input type="radio" name="questions[0][correct_answer]" value="A"> Correct
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control rounded" name="questions[0][options_b]" placeholder="Option B" required>
                                            <div class="invalid-feedback">Please provide Option B.</div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <input type="radio" name="questions[0][correct_answer]" value="B"> Correct
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control rounded" name="questions[0][options_c]" placeholder="Option C" required>
                                            <div class="invalid-feedback">Please provide Option C.</div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <input type="radio" name="questions[0][correct_answer]" value="C"> Correct
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control rounded" name="questions[0][options_d]" placeholder="Option D" required>
                                            <div class="invalid-feedback">Please provide Option D.</div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <input type="radio" name="questions[0][correct_answer]" value="D"> Correct
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">Please select a correct answer.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-outline-secondary " id="add-question">
                            <i class="bi bi-plus-circle me-2"></i>Add Question
                        </button>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Save Quiz
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="window.history.back()">Cancel</button>

                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .btn-lg {
            font-size: 1.1rem;
        }
        .btn-primary:hover {
            background-color: #005f73;
            border-color: #005f73;
        }
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
        .form-control, .form-control:focus {
            border-radius: 0.5rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let questionCount = 1;

            // Fungsi untuk membuat blok pertanyaan baru
            function createQuestionBlock(index) {
                return `
                <div class="card mb-3 question-block shadow-sm" data-index="${index}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Question ${index + 1}</h5>
                            <button type="button" class="btn btn-danger btn-sm delete-question">Delete</button>
                        </div>
                        <input type="hidden" name="questions[${index}][quiz_id]" value="{{ $quiz->id }}">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Question Text</label>
                            <textarea class="form-control rounded" id="question_text_${index + 1}" name="questions[${index}][question_text]" rows="4"></textarea>
                            <div class="invalid-feedback">Please provide the question text.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Points</label>
                            <input type="number" class="form-control rounded" name="questions[${index}][poin]" min="0" required>
                            <div class="invalid-feedback">Please provide a valid number of points (0 or more).</div>
                        </div>
                        <div class="options-container">
                            <h6 class="fw-bold">Options</h6>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-10">
                                    <input type="text" class="form-control rounded" name="questions[${index}][options_a]" placeholder="Option A" required>
                                    <div class="invalid-feedback">Please provide Option A.</div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <input type="radio" name="questions[${index}][correct_answer]" value="A" required> Correct
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-10">
                                    <input type="text" class="form-control rounded" name="questions[${index}][options_b]" placeholder="Option B" required>
                                    <div class="invalid-feedback">Please provide Option B.</div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <input type="radio" name="questions[${index}][correct_answer]" value="B"> Correct
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-10">
                                    <input type="text" class="form-control rounded" name="questions[${index}][options_c]" placeholder="Option C" required>
                                    <div class="invalid-feedback">Please provide Option C.</div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <input type="radio" name="questions[${index}][correct_answer]" value="C"> Correct
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-10">
                                    <input type="text" class="form-control rounded" name="questions[${index}][options_d]" placeholder="Option D" required>
                                    <div class="invalid-feedback">Please provide Option D.</div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <input type="radio" name="questions[${index}][correct_answer]" value="D"> Correct
                                </div>
                            </div>
                            <div class="invalid-feedback">Please select a correct answer.</div>
                        </div>
                    </div>
                </div>
            `;
            }

            // Fungsi untuk mengupdate tombol delete
            function updateDeleteButtons() {
                const questionBlocks = document.querySelectorAll('.question-block');
                questionBlocks.forEach((block, index) => {
                    const deleteButton = block.querySelector('.delete-question');
                    if (deleteButton) {
                        deleteButton.style.display = questionBlocks.length > 1 ? 'block' : 'none';
                    }
                });
            }

            // Event listener untuk tombol Add Question
            document.getElementById('add-question').addEventListener('click', function() {
                const container = document.getElementById('questions-container');
                const newQuestion = document.createElement('div');
                newQuestion.innerHTML = createQuestionBlock(questionCount);
                container.appendChild(newQuestion);

                // Update counter
                questionCount++;

                // Update tombol delete
                updateDeleteButtons();

                // Hilangkan validasi jika ada
                document.getElementById('quiz-form').classList.remove('was-validated');
            });

            // Event delegation untuk tombol delete
            document.getElementById('questions-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-question')) {
                    const questionBlock = e.target.closest('.question-block');

                    // Hapus editor TinyMCE jika ada
                    const textareaId = questionBlock.querySelector('textarea').id;
                    if (typeof tinymce !== 'undefined' && tinymce.get(textareaId)) {
                        tinymce.get(textareaId).remove();
                    }

                    questionBlock.remove();

                    // Reindex pertanyaan yang tersisa
                    const questions = document.querySelectorAll('.question-block');
                    questions.forEach((question, index) => {
                        question.dataset.index = index;
                        question.querySelector('.card-title').textContent = `Question ${index + 1}`;

                        // Update semua nama field
                        question.querySelector('input[type="hidden"]').name = `questions[${index}][quiz_id]`;
                        question.querySelector('textarea').name = `questions[${index}][question_text]`;
                        question.querySelector('textarea').id = `question_text_${index + 1}`;
                        question.querySelector('input[type="number"]').name = `questions[${index}][poin]`;

                        // Update nama option dan radio button
                        const options = ['a', 'b', 'c', 'd'];
                        options.forEach((opt, i) => {
                            const textInput = question.querySelector(`input[name^="questions["][name$="[options_${opt}]"]`);
                            const radioInput = question.querySelector(`input[type="radio"][value="${opt.toUpperCase()}"]`);

                            if (textInput) textInput.name = `questions[${index}][options_${opt}]`;
                            if (radioInput) radioInput.name = `questions[${index}][correct_answer]`;
                        });
                    });

                    questionCount = questions.length;
                    updateDeleteButtons();
                    document.getElementById('quiz-form').classList.remove('was-validated');
                }
            });

            // Inisialisasi tombol delete pertama kali
            updateDeleteButtons();

            // Validasi form
            const form = document.getElementById('quiz-form');
            form.addEventListener('submit', function(event) {
                let isValid = true;

                // Validasi setiap pertanyaan
                document.querySelectorAll('.question-block').forEach((block, index) => {
                    // Validasi textarea
                    const textarea = block.querySelector('textarea');
                    if (!textarea.value.trim()) {
                        isValid = false;
                        textarea.classList.add('is-invalid');
                    } else {
                        textarea.classList.remove('is-invalid');
                    }

                    // Validasi radio button (correct answer)
                    const radios = block.querySelectorAll(`input[name="questions[${index}][correct_answer]"]`);
                    const isChecked = Array.from(radios).some(radio => radio.checked);
                    if (!isChecked) {
                        isValid = false;
                        radios.forEach(radio => {
                            radio.classList.add('is-invalid');
                        });

                        let feedback = block.querySelector('.options-container .invalid-feedback');
                        if (!feedback) {
                            feedback = document.createElement('div');
                            feedback.classList.add('invalid-feedback');
                            feedback.textContent = 'Please select a correct answer.';
                            block.querySelector('.options-container').appendChild(feedback);
                        }
                        feedback.style.display = 'block';
                    } else {
                        radios.forEach(radio => {
                            radio.classList.remove('is-invalid');
                        });
                    }
                });

                // Cek jika tidak ada pertanyaan
                if (document.querySelectorAll('.question-block').length === 0) {
                    alert('Please add at least one question to the quiz.');
                    event.preventDefault();
                    event.stopPropagation();
                    return;
                }

                // Jika tidak valid, tampilkan error
                if (!form.checkValidity() || !isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                }
            });
        });
    </script>
@endsection
