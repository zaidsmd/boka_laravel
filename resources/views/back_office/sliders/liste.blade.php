@extends('back_office.admin_layouts.main')

@section('document-title', __('lang.articles.titre'))

@push('css')
    <style>
        .image-table {
            width: 100%;
            border-collapse: collapse;
        }
        .image-table th,
        .image-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .image-table th {
            background-color: #f4f4f4;
            text-align: right;
        }
        .image-table tr {
        }
        .image-table img {
            max-width: 100px;
            max-height: 100px; /* Ensure images do not exceed row height */
            object-fit: cover;
        }
        .image-table .move-up,
        .image-table .move-down {
            cursor: pointer;
        }
        .image-table .move-up.disabled,
        .image-table .move-down.disabled {
            color: #ccc;
            cursor: not-allowed;
        }
        .delete-btn {
            position: absolute;
            top: 0;
            background: red;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .image-preview {
            width: 100%;
            height: auto;
            max-height: 100px;
            object-fit: cover;
        }
        #file-input {
            display: none;
        }
        .custom-file-input {
            border: 2px dashed #000000;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            color: #000000;
            cursor: pointer;
        }
        .invalid-image {
            border: 2px solid red;
        }
        .form-text.text-muted {
            color: #6c757d;
            font-size: 0.875rem;
        }
        .custom-message {
            color: red !important;
            font-size: 0.875rem !important;
        }
        .custom-file-input::before {
            content: 'اختر الملفات';
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 6px 12px;
            cursor: pointer;
        }

        .custom-file-input {
            position: relative;
            width: 200px; /* Adjust as needed */
            height: 40px;
            opacity: 0;
        }
    </style>
@endpush

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="articles-form" action="{{ route('sliders.sauvegarder') }}" enctype="multipart/form-data" method="post" autocomplete="off">
                        <div class="card-title">
                            <div id="__fixed" class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="m-0 float-end ms-3">
                                        <i class="fa fas fa-boxes me-2 text-success"></i>
                                        إعدادات الشريط المتحرك
                                    </h5>
                                </div>
                                <div class="pull-right">
                                    <button id="save-btn" class="btn btn-soft-info" type="submit">
                                        <i class="fa fa-save"></i> {{ __('lang.articles.save') }}
                                    </button>
                                </div>
                            </div>
                            <hr class="border">
                        </div>
                        @csrf

                        <div class="row">
                            <div class="col-sm-9 row mx-0 col-12 align-content-start">
                                <div class="col-12 mt-2">
                                    <h5 class="text-muted">أضف الصور  </h5>
                                    <hr class="border border-success">
                                </div>


                                <div class="col-12 col-lg-12 mb-3">
                                    <div class="d-flex align-items-center">

                                        <div class="form-group flex-grow-1 me-2">
{{--                                            <label for="image" class="form-label">أضف صورة</label>--}}
                                            <input style="display: none;" lang="ar" type="file" id="image" name="image[]" class="form-control" multiple accept="image/*">
                                            <button type="button" class="btn btn-primary w-25" id="selectFilesBtn">اختر الصور   <i class="mdi mdi-plus"></i></button>
                                            <br>
                                            <small class="form-text text-muted">
                                                يجب أن تكون الصورة بالأبعاد التالية: 1640 × 563 بكسل، ونسبة العرض إلى الارتفاع 2.91:1.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="image-data" name="image_data">

                                <div class="col-12 col-lg-12 mb-3">
                                    <table class="image-table">
                                        <thead>
                                        <tr>
                                            <th>الترتيب</th>
                                            <th>الصورة</th>
                                            <th style="width: 30%;">الاسم</th>
                                            <th style="width: 30%;">الرابط</th>
                                            <th style="width: 10%">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody id="image-table-body">
                                        @foreach($mediaItems as $media)
                                            <tr data-id="{{ $media->id }}">
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td><img src="{{ $media->getUrl() }}" alt="Image" class="image-preview"></td>
                                                <td>{{ $media->file_name }}</td>
                                                <td><input class="form-control" type="text" value="{{$media->url}}"></td>
                                                <td>
                                                    <button type="button" class="btn btn-soft-warning btn-sm move-up {{ $loop->first ? 'disabled' : '' }}"><i class="fas fa-chevron-up"></i></button>
                                                    <button type="button" class="btn btn-soft-info btn-sm move-down {{ $loop->last ? 'disabled' : '' }}"><i class="fas fa-chevron-down"></i></button>
                                                    <button type="button" class="btn btn-soft-danger btn-sm remove"><i class="fas fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Hidden inputs for row order -->
                                    <div id="row-order-container">
                                        <!-- Row orders will be appended here -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 row mx-0 col-12 align-content-start">
                                <div class="col-12 mt-2">
                                    <h5 class="text-muted">إعدادات</h5>
                                    <hr class="border border-success">
                                </div>

                                <div class=" col-12 col-lg-12 mb-3 ">
                                    <label class="form-label  required " for="transition_time">  وقت الانتقال  بالمللي ثانية</label>
                                    <div class="input-group">
                                        <input type="number" step="any"
                                               class="form-control {{$errors->has('transition_time')? 'is-invalid' : ''}}"
                                               id="transition_time"
                                               name="transition_time" value="{{old('transition_time' ,$slider->transition_time)}}">
                                        <div class="invalid-feedback">
                                            @if($errors->has('transition_time'))
                                                {{ $errors->first('transition_time') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-12 mb-3">
                                    <label class="form-label required" for="autoplay">تشغيل تلقائي</label>
                                    <div class="input-group">
                                        <select class="form-select {{$errors->has('autoplay') ? 'is-invalid' : ''}}" name="autoplay" id="autoplay">
                                            <option value="0" {{ old('autoplay', $slider->autoplay) == 0 ? 'selected' : '' }}>نعم</option>
                                            <option value="1" {{ old('autoplay', $slider->autoplay) == 1 ? 'selected' : '' }}>لا</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            @if($errors->has('autoplay'))
                                                {{ $errors->first('autoplay') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imageInput = document.getElementById('image');
            var selectFilesBtn = document.getElementById('selectFilesBtn');
            const imageTableBody = document.getElementById('image-table-body');
            const formText = document.querySelector('.form-text');
            const form = document.getElementById('articles-form');
            const imageDataInput = document.getElementById('image-data');

            selectFilesBtn.addEventListener('click', function() {
                imageInput.click();
            });
            // Initialize existing images with event listeners
            initializeRowActions();

            imageInput.addEventListener('change', (event) => {
                const files = event.target.files;
                if (files.length === 0) return;

                // Clear previous messages
                const existingMessages = document.querySelectorAll('.custom-message');
                existingMessages.forEach(msg => {
                    msg.classList.remove('custom-message');
                });

                Array.from(files).forEach(file => {
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        const imageUrl = event.target.result;
                        const img = new Image();

                        img.onload = function() {
                            const width = img.width;
                            const height = img.height;
                            const aspectRatio = width / height;

                            // Define allowed dimensions and aspect ratio
                            const requiredWidth = 1640;
                            const requiredHeight = 563;
                            const requiredAspectRatio = 2.91;

                            // Check dimensions and aspect ratio
                            if (width !== requiredWidth || height !== requiredHeight || Math.abs(aspectRatio - requiredAspectRatio) > 0.01) {
                                formText.className = 'form-text custom-message'; // Set text color to red
                                 formText.textContent = `يجب أن تكون الصورة بالأبعاد التالية: 1640 × 563 بكسل، ونسبة العرض إلى الارتفاع 2.91:1. `;
                                return; // Skip this file
                            }

                            // Add valid image to table
                            addImageToTable(imageUrl, file.name);
                        };

                        img.src = imageUrl;
                    };

                    reader.readAsDataURL(file);
                });

                // Clear the input
                imageInput.value = '';
            });

            function addImageToTable(imageUrl, imageName) {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${imageTableBody.children.length + 1}</td>
            <td><img src="${imageUrl}" alt="Image" class="image-preview"></td>
            <td>${imageName}</td>
            <td><input class="form-control" type="text"></td>
            <td>
                <button type="button" class="btn btn-soft-warning btn-sm move-up"><i class="fas fa-chevron-up"></i></button>
                <button type="button" class="btn btn-soft-info btn-sm move-down"><i class="fas fa-chevron-down"></i></button>
                <button type="button" class="btn btn-soft-danger btn-sm remove"><i class="fas fa-trash-alt"></i></button>
            </td>
        `;

                imageTableBody.appendChild(row);
                updateRowActions(row); // Initialize actions for the new row
                updateOrderNumbers(); // Update order numbers after adding
            }

            function initializeRowActions() {
                // Apply actions to existing rows
                const rows = imageTableBody.querySelectorAll('tr');
                rows.forEach(row => updateRowActions(row));
            }

            function updateRowActions(row) {
                row.querySelector('.move-up').addEventListener('click', () => {
                    const prevRow = row.previousElementSibling;
                    if (prevRow) {
                        imageTableBody.insertBefore(row, prevRow);
                        updateOrderNumbers();
                    }
                });

                row.querySelector('.move-down').addEventListener('click', () => {
                    const nextRow = row.nextElementSibling;
                    if (nextRow) {
                        imageTableBody.insertBefore(nextRow, row);
                        updateOrderNumbers();
                    }
                });

                row.querySelector('.remove').addEventListener('click', () => {
                    row.remove();
                    updateOrderNumbers(); // Update order numbers after removal
                });
            }

            function updateOrderNumbers() {
                const rows = imageTableBody.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    row.children[0].textContent = index + 1;
                    const moveUpButton = row.querySelector('.move-up');
                    const moveDownButton = row.querySelector('.move-down');
                    moveUpButton.classList.toggle('disabled', index === 0);
                    moveDownButton.classList.toggle('disabled', index === rows.length - 1);
                });
                updateImageDataInput(); // Update hidden input with new order
            }

            function updateImageDataInput() {
                const rows = imageTableBody.querySelectorAll('tr');
                const imageData = Array.from(rows).map((row,index) => {
                    return {
                        id: row.dataset.id || null, // Add ID if available
                        order: index + 1, // Include order
                        real_url: row.querySelector('img').src,
                        additional_url: row.querySelector('td:nth-child(4) input').value, // Additional URL from the input field
                        name: row.querySelector('td:nth-child(3)').textContent
                    };
                });
                imageDataInput.value = JSON.stringify(imageData);
            }

            form.addEventListener('submit', () => {
                updateImageDataInput();
            });
        });

    </script>

    <script>
        $(document).ready(function(){

            var successMessage = '{{ session('success') }}';
            if (successMessage) {
                Swal.fire({
                    title: '{{ __("lang.succes") }}',
                    text: successMessage,
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
        document.getElementById('image').addEventListener('change', function(event) {
            const fileInput = event.target;
            const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : 'لم يتم اختيار أي ملف';
            // Display the file name or message in an element if needed
            console.log(fileName);
        });
    </script>
@endpush

