@extends('layouts.masterclient')

@section('content')

<style>
    :root {
        --primary-bg: #f6e3c5;
        --accent-dark: #0f2540;
        --accent-muted: #bfa98b;
        --card-bg: #f6ece0;
        --hover-bg: #e6d3bd;
        --border-radius: 12px;
        --font-serif: "Georgia", "Times New Roman", serif;
    }

    .archiving-hero {
        width: 100%;
        margin: 0 auto 1.5rem auto;
        text-align: center;
        display: flex;
        padding: 5rem 1.5rem 4rem;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to bottom, var(--card-bg) 0%, var(--primary-bg) 100%);
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        border-radius: var(--border-radius);
    }

    .archiving-hero h1 {
        font-weight: 800;
        color: var(--accent-dark);
        margin: 0 0 1rem 0;
        letter-spacing: -1.5px;
        line-height: 1.2;
    }

    .archiving-hero p {
        font-size: 1.1rem;
        color: var(--accent-dark);
        opacity: 0.8;
        margin: 0;
        max-width: 700px;
        line-height: 1.6;
    }

    .form-container {
        max-width: 800px;
        margin: 3rem auto;
        background: white;
        padding: 3rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(15, 37, 64, 0.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        color: var(--accent-dark);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid #eee;
        border-radius: 10px;
        font-family: var(--font-serif);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--accent-muted);
        outline: none;
        box-shadow: 0 0 0 4px rgba(191, 169, 139, 0.1);
    }

    .submit-btn {
        background: var(--accent-dark);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 30px;
        font-weight: 700;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .submit-btn:hover {
        background: var(--accent-muted);
        color: var(--accent-dark);
        transform: translateY(-2px);
    }

    .info-box {
        background: var(--card-bg);
        padding: 1.5rem;
        border-radius: 12px;
        border-left: 5px solid var(--accent-muted);
        margin-bottom: 2rem;
        display: none;
    }

    .info-box h4 {
        margin-top: 0;
        color: var(--accent-dark);
        font-weight: 700;
    }

    .info-box p {
        margin-bottom: 0;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Hide the upload field initially if book is selected or by default */
    #upload-container {
        display: none;
    }

    .error-text {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: none;
    }
</style>

<section class="archiving-hero">
    <h1>Documentation Archiving</h1>
    <p>Help us preserve Tamil heritage by submitting your documentations. Whether it is a digital PDF or a physical hard copy, your contribution ensures our history lives on.</p>
</section>

<div class="container">
    <div class="form-container">
        <form id="archivingForm" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="donor_name">Donor Name</label>
                    <input type="text" name="donor_name" id="donor_name" class="form-control" placeholder="Your full name" required>
                    <span class="error-text" id="error-donor_name"></span>
                </div>
                <div class="col-md-6 form-group">
                    <label for="donor_email">Donor Email</label>
                    <input type="email" name="donor_email" id="donor_email" class="form-control" placeholder="Your email address" required>
                    <span class="error-text" id="error-donor_email"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="donor_phone">Donor Phone</label>
                    <input type="text" name="donor_phone" id="donor_phone" class="form-control" placeholder="Contact number" required>
                    <span class="error-text" id="error-donor_phone"></span>
                </div>
                <div class="col-md-6 form-group">
                    <label for="author_name">Author of Documentation</label>
                    <input type="text" name="author_name" id="author_name" class="form-control" placeholder="Name of the author/creator" required>
                    <span class="error-text" id="error-author_name"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="doc_type">Type of Documentation</label>
                <select name="doc_type" id="doc_type" class="form-control" required>
                    <option value="" disabled selected>Select type...</option>
                    <option value="pdf">PDF (Digital Copy)</option>
                    <option value="book">Hard Copy Book</option>
                </select>
                <span class="error-text" id="error-doc_type"></span>
            </div>

            <!-- PDF Upload Container -->
            <div id="upload-container" class="form-group">
                <label for="file_upload">Upload PDF File</label>
                <input type="file" name="file_upload" id="file_upload" class="form-control" accept=".pdf">
                <small class="text-muted">Maximum file size: 10MB</small>
                <span class="error-text" id="error-file_upload"></span>
            </div>

            <!-- Physical Book Submission Info -->
            <div id="address-container" class="info-box">
                <h4>Submission Address</h4>
                <p>Please send your hard copy book to our main archive center at:</p>
                <div class="mt-3">
                    {!! nl2br(e($address)) !!}
                </div>
                <p class="mt-3"><small>* Please include your donor details inside the package.</small></p>
            </div>

            <div class="form-group">
                <label for="description">Brief Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" placeholder="Tell us more about this documentation..."></textarea>
                <span class="error-text" id="error-description"></span>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">Submit Documentation</button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle interface based on doc type
        $('#doc_type').on('change', function() {
            const type = $(this).val();
            if (type === 'pdf') {
                $('#upload-container').fadeIn();
                $('#address-container').hide();
                $('#file_upload').attr('required', true);
            } else if (type === 'book') {
                $('#upload-container').hide();
                $('#address-container').fadeIn();
                $('#file_upload').attr('required', false);
            }
        });

        // Handle AJAX form submission
        $('#archivingForm').on('submit', function(e) {
            e.preventDefault();
            
            // Reset errors
            $('.error-text').hide().text('');
            $('#submitBtn').prop('disabled', true).text('Processing...');

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('client.archiving.submit') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#archivingForm')[0].reset();
                        $('#upload-container, #address-container').hide();
                    }
                    $('#submitBtn').prop('disabled', false).text('Submit Documentation');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $(`#error-${key}`).text(value[0]).show();
                        });
                        toastr.error("Please check the form for errors.");
                    } else {
                        toastr.error("An unexpected error occurred. Please try again.");
                    }
                    $('#submitBtn').prop('disabled', false).text('Submit Documentation');
                }
            });
        });
    });
</script>
@endsection
