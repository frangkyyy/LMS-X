@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="container-fluid">

            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-primary text-white py-3">
                    <h2 class="mb-0 font-weight-bold" style="font-family: 'Poppins', sans-serif;">Edit Page: {{ $page->name }}</h2>
                </div>
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success mb-4 rounded" style="font-family: 'Poppins', sans-serif;">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4 rounded" style="font-family: 'Poppins', sans-serif;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="sub_topic_id" value="{{ $subTopic->id }}">

                        <div class="row g-4">
                            <div class="col-12">
                                <label for="name" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Nama</label>
                                <input type="text" name="name" id="name" class="form-control rounded" style="border-color: #E4E6EF;" value="{{ old('name', $page->name) }}" required>
                                <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Nama wajib diisi.</div>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Deskripsi</label>
                                <textarea name="description" id="description" rows="4" class="form-control rounded" style="border-color: #E4E6EF;">{{ old('description', $page->description) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="content" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Konten</label>
                                <textarea name="content" id="content" rows="4" class="form-control rounded" style="border-color: #E4E6EF;" required>{{ old('content', $page->content) }}</textarea>
                                <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Konten wajib diisi.</div>
                            </div>

                            <div class="col-12">
                                <label for="sub_topic_id" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Sub Topik</label>
                                <select name="sub_topic_id" id="sub_topic_id" class="form-control rounded" style="border-color: #E4E6EF;" required>
                                    @foreach ($subTopics as $sub)
                                        <option value="{{ $sub->id }}" {{ $sub->id == old('sub_topic_id', $subTopic->id) ? 'selected' : '' }}>{{ $sub->title }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Pilih sub topik.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Learning Style</label>
                                <div id="dimension-container">
                                    @php
                                        $selectedDimension = $dimensions->firstWhere('id', 2);
                                    @endphp
                                    @if($selectedDimension)
                                        <input type="hidden" name="dimension[]" value="{{ $selectedDimension->id }}">
                                        <div class="form-check">
                                            <label class="form-check-label" style="font-family: 'Poppins', sans-serif; color: #3F4254;">
                                                {{ $selectedDimension->dimension }}
                                            </label>
                                        </div>
                                        <div id="options-container">
                                            <label class="form-label" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Pilih Opsi Dimensi</label>
                                            <div id="options-list">
                                                @foreach($selectedDimension->options as $option)
                                                    <div class="form-check">
                                                        <input class="form-check-input option-radio" type="radio"
                                                               name="dimension_options[]"
                                                               value="{{ $option->id }}"
                                                               id="option-{{ $option->id }}"
                                                               {{ $page->options->pluck('id')->contains($option->id) ? 'checked' : '' }}
                                                               required>
                                                        <label class="form-check-label" for="option-{{ $option->id }}" style="font-family: 'Poppins', sans-serif; color: #3F4254;">
                                                            {{ $option->nama_opsi_dimensi }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="invalid-feedback d-block" id="options-error" style="display: none; font-family: 'Poppins', sans-serif;">
                                                Pilih satu opsi dimensi.
                                            </div>
                                        </div>
                                    @else
                                        <p style="font-family: 'Poppins', sans-serif; color: #3F4254;">Dimensi dengan ID: 2 tidak ditemukan.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 font-weight-medium" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">Update Page</button>
                                <a href="{{ route('sections.show', [$page->sub_topic->section->course_id, $page->sub_topic->section->id]) }}" class="btn btn-secondary px-4 py-2 font-weight-medium" style="font-family: 'Poppins', sans-serif;">Kembali</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize TinyMCE for description and content
                if (typeof tinymce === 'undefined') {
                    console.error('TinyMCE tidak dimuat!');
                } else {
                    console.log('TinyMCE terdeteksi, inisialisasi dimulai...');
                    tinymce.init({
                        selector: '#description, #content',
                        plugins: [
                            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                            'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'mentions', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown'
                        ],
                        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                        tinycomments_mode: 'embedded',
                        tinycomments_author: 'Author name',
                        mergetags_list: [
                            { value: 'First.Name', title: 'First Name' },
                            { value: 'Email', title: 'Email' },
                        ],
                        setup: function (editor) {
                            editor.on('init', function () {
                                console.log('TinyMCE berhasil diinisialisasi untuk #' + editor.id);
                            });
                            editor.on('error', function (e) {
                                console.error('TinyMCE error:', e);
                            });
                        }
                    });
                }

                // Form validation
                (function () {
                    'use strict';
                    var forms = document.querySelectorAll('.needs-validation');
                    Array.prototype.slice.call(forms).forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            const checkedOption = document.querySelector('.option-radio:checked');
                            const optionsError = document.getElementById('options-error');

                            if (!form.checkValidity() || !checkedOption) {
                                event.preventDefault();
                                event.stopPropagation();
                                if (!checkedOption) {
                                    optionsError.style.display = 'block';
                                } else {
                                    optionsError.style.display = 'none';
                                }
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                })();
            });
        </script>
@endsection
