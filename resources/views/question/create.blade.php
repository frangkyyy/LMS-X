@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-primary text-white rounded-top">
                <h2 class="mb-0">Create New {{ $quiz->name }}</h2>
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

            function initializeTinyMCE(selector) {
                if (typeof tinymce === 'undefined') {
                    console.warn('TinyMCE is not loaded. Using plain textarea.');
                    const textarea = document.querySelector(selector);
                    if (textarea) {
                        textarea.style.display = 'block';
                        textarea.removeAttribute('aria-hidden');
                    }
                    return;
                }

                const editorId = selector.replace('#', '');
                if (tinymce.get(editorId)) {
                    return;
                }

                tinymce.init({
                    selector: selector,
                    plugins: 'link image lists table wordcount',
                    toolbar: 'undo redo | bold italic | link image | numlist bullist | table | removeformat',
                    menubar: false,
                    statusbar: false,
                    height: 200,
                    setup: function (editor) {
                        editor.on('init', function () {
                            console.log(`TinyMCE initialized for ${selector}`);
                        });
                        editor.on('change', function () {
                            editor.save();
                        });
                    }
                }).catch(error => {
                    console.error('Failed to initialize TinyMCE:', error);
                    const textarea = document.querySelector(selector);
                    if (textarea) {
                        textarea.style.display = 'block';
                        textarea.removeAttribute('aria-hidden');
                    }
                });
            }

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
                                        <input type="radio" name="questions[${index}][correct_answer]" value="A"> Correct
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

            function updateDeleteButtons() {
                const questionBlocks = document.querySelectorAll('.question-block');
                questionBlocks.forEach((block, index) => {
                    const deleteButton = block.querySelector('.delete-question');
                    if (deleteButton) {
                        deleteButton.style.display = questionBlocks.length > 1 ? 'block' : 'none';
                    }
                });
            }

            function reindexQuestions() {
                const questionBlocks = document.querySelectorAll('.question-block');
                questionBlocks.forEach((block, index) => {
                    block.dataset.index = index;
                    block.querySelector('h5').textContent = `Question ${index + 1}`;
                    block.querySelector('input[type="hidden"]').name = `questions[${index}][quiz_id]`;
                    block.querySelector('textarea').name = `questions[${index}][question_text]`;
                    block.querySelector('textarea').id = `question_text_${index + 1}`;
                    block.querySelector('input[type="number"]').name = `questions[${index}][poin]`;
                    block.querySelectorAll('.options-container input[type="text"]').forEach((input, i) => {
                        input.name = `questions[${index}][options_${String.fromCharCode(97 + i)}]`;
                    });
                    block.querySelectorAll('.options-container input[type="radio"]').forEach(radio => {
                        radio.name = `questions[${index}][correct_answer]`;
                    });

                    // Reinitialize TinyMCE for the textarea
                    const textareaId = `question_text_${index + 1}`;
                    if (tinymce?.get(textareaId)) {
                        tinymce.get(textareaId).remove();
                    }
                    initializeTinyMCE(`#${textareaId}`);
                });
                updateDeleteButtons();
            }

            document.getElementById('add-question').addEventListener('click', function () {
                const container = document.getElementById('questions-container');
                const newQuestion = document.createElement('div');
                newQuestion.innerHTML = createQuestionBlock(questionCount);
                container.appendChild(newQuestion);
                initializeTinyMCE(`#question_text_${questionCount + 1}`);
                questionCount++;
                reindexQuestions();
                document.getElementById('quiz-form').classList.remove('was-validated');
            });

            document.getElementById('questions-container').addEventListener('click', function (e) {
                if (e.target.classList.contains('delete-question')) {
                    const questionBlock = e.target.closest('.question-block');
                    const textareaId = questionBlock.querySelector('textarea').id;
                    if (tinymce?.get(textareaId)) {
                        tinymce.get(textareaId).remove();
                    }
                    questionBlock.remove();
                    questionCount--;
                    reindexQuestions();
                    document.getElementById('quiz-form').classList.remove('was-validated');
                }
            });

            initializeTinyMCE('#question_text_1');
            updateDeleteButtons();

            const form = document.getElementById('quiz-form');
            form.addEventListener('submit', function (event) {
                if (tinymce) {
                    try {
                        tinymce.triggerSave();
                    } catch (error) {
                        console.error('Error syncing TinyMCE content:', error);
                    }
                }

                let isValid = true;
                document.querySelectorAll('textarea[id^="question_text_"]').forEach(textarea => {
                    const editorId = textarea.id;
                    const editor = tinymce?.get(editorId);
                    if (editor) {
                        const content = editor.getContent().trim();
                        if (!content) {
                            isValid = false;
                            textarea.classList.add('is-invalid');
                            const feedback = textarea.nextElementSibling;
                            if (feedback && feedback.classList.contains('invalid-feedback')) {
                                feedback.style.display = 'block';
                            }
                        } else {
                            textarea.classList.remove('is-invalid');
                        }
                    } else {
                        if (!textarea.value.trim()) {
                            isValid = false;
                            textarea.classList.add('is-invalid');
                        } else {
                            textarea.classList.remove('is-invalid');
                        }
                    }
                });

                document.querySelectorAll('.question-block').forEach((block, index) => {
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

                const questionBlocks = document.querySelectorAll('.question-block');
                if (questionBlocks.length === 0) {
                    event.preventDefault();
                    event.stopPropagation();
                    alert('Please add at least one question to the quiz.');
                    return;
                }

                if (!form.checkValidity() || !isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                }
            });
        });
    </script>
@endsection
