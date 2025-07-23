@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                            <h2 class="mb-0 font-weight-bold" style="font-family: 'Poppins', sans-serif;">Edit Label {{ $label->sub_topic->title }}</h2>
                        </div>
                        <div class="card-body p-4">
                            @if(session('success'))
                                <div class="alert alert-success mb-4 rounded" style="font-family: 'Poppins', sans-serif;">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('labels.update', $label->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="sub_topic_id" value="{{ $label->sub_topic_id }}">

                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="konten" class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Teks Label</label>
                                        <textarea name="konten" id="konten" rows="4" class="form-control rounded" style="border-color: #E4E6EF;" required>{{ old('konten', $label->konten) }}</textarea>
                                        <div class="invalid-feedback" style="font-family: 'Poppins', sans-serif;">Teks Label wajib diisi.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label font-weight-medium" style="font-family: 'Poppins', sans-serif; color: #3F4254;">Learning Style</label>
                                        <div id="dimension-container">
                                            @php
                                                $selectedDimension = $dimensions->firstWhere('id', 3);
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
                                                                       {{ in_array($option->id, $selectedOptions) ? 'checked' : '' }}
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
                                                <p style="font-family: 'Poppins', sans-serif; color: #3F4254;">Dimensi dengan ID: 3 tidak ditemukan.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-medium" style="font-family: 'Poppins', sans-serif; background-color: #3699FF; border-color: #3699FF;">Update Label</button>
                                        <a href="{{ route('sections.show', [$label->sub_topic->section->course_id, $label->sub_topic->section_id]) }}" class="btn btn-secondary px-4 py-2 font-weight-medium" style="font-family: 'Poppins', sans-serif;">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize TinyMCE
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: '#konten',
                    plugins: [
                        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                        'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
                    ],
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                    tinycomments_mode: 'embedded',
                    tinycomments_author: 'Author name',
                    mergetags_list: [
                        { value: 'First.Name', title: 'First Name' },
                        { value: 'Email', title: 'Email' },
                    ],
                    setup: function (editor) {
                        editor.on('init', function () {
                            console.log('TinyMCE berhasil diinisialisasi untuk #konten');
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
