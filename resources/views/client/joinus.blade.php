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

  .page-header-section {
    width: 100%; 
    padding: 4rem 1rem 1.5rem !important;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(to bottom, var(--card-bg) 0%, var(--primary-bg) 100%);
    border: 1px solid rgba(0, 0, 0, 0.08); 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); 
    border-radius: var(--border-radius);
  }

  .page-header-section .page-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--accent-dark);
    margin: 0 0 1rem 0;
    letter-spacing: -1.5px;
    line-height: 1.1;
  }

  .page-header-section .page-subtitle {
    font-size: 1.25rem;
    color: var(--accent-dark);
    opacity: 0.8;
    margin: 0;
    max-width: 800px;
    line-height: 1.6;
  }

  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
        .container {
          
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        .card {
            background-color: white;
            border: var(--accent-dark);
            border-radius: 10px;
            width: 400px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card h2 {
            color: #0f2540;
            margin: 0 0 10px;
            font-size: 1.8em;
        }
        .card p {
            margin: 0 0 10px;
            font-size: 1.1em;
            line-height: 1.6;
            color: #0f2540;
        }
        .btn {
            display: inline-block;
            background-color: #0f2540;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color:#0f2540;
        }
        /* Mobile responsiveness */
        @media (max-width: 900px) {
            .card {
                width: 100%;
            }
        }
      
        .title {
            text-align: center;
            font-size: 2.3em;
            color: #0f2540;;
            margin-bottom: 40px;
        }
        .main-content {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            align-items: flex-start; /* Ensures left and right start at the same top level */
        }
        .left-section {
            flex: 2;
            min-width: 350px;
        }
        .right-section {
            flex: 1;
            min-width: 250px;
        }
        .section-title {
            color: #8b0000;
            font-size: 1.8em;
            margin-bottom: 15px;
            border-bottom: 5px #b9996c;
            padding-bottom: 5px;
            margin-top: 0; /* No top margin - starts right at the top */
        }
        .community-text {
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .activities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .activity-item {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .sidebar-box {
            background-color: #fff;
            border: 1px solid #8b0000;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .sidebar-title {
            color:#0f2540;
            font-size: 1.3em;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .list {
            list-style-type: none;
            padding: 0;
        }
        .list li {
            margin-bottom: 10px;
            font-size: 1.1em;
        }
        .apply-box {
            background-color: #e1d2be;
            color: rgb(1, 0, 0);
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }
        .apply-box p {
            margin: 0 0 13px;
            font-size: 1.3em;
        }
        .btn {
            display: inline-block;
            background-color: white;
            color: #8b0000;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.1em;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #f0f0f0;
        }
        /* Mobile responsiveness */
        @media (max-width: 900px) {
            .main-content {
                flex-direction: column;
            }
            .right-section {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: space-between;
            }
            .sidebar-box {
                flex: 1;
                min-width: 200px;
            }
        }
        @media (max-width: 600px) {
            .right-section {
                flex-direction: column;
            }
        }
        /* Wrap the entire Become a Volunteer section in a bordered box */
.volunteer-box {
    background-color: white;
    border: 1px solid var(--accent-dark); /* Thick dark border using your variable */
    border-radius: var(--border-radius);
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    margin: 20px auto;
    max-width: 1200px; /* Keeps it centered and contained */
}

/* Key Volunteer Activities hover effect */
.activity-item {
    background-color: var(--card-bg);
    border: 2px solid var(--accent-muted);
    border-radius: var(--border-radius);
    padding: 25px;
    text-align: center;
    font-weight: 700;
    font-size: 1.15em;
    color: var(--accent-dark);
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    cursor: pointer; /* Makes it feel interactive */
}

.activity-item:hover {
    background-color: var(--hover-bg);
    transform: translateY(-8px);
   box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    border-color: var(--accent-dark);
     color: var(--accent-dark);
}
/* Volunteer box mobile responsiveness */
@media (max-width: 768px) {
    .volunteer-box {
        padding: 15px;
        margin: 15px 8px;
    }
    .title {
        font-size: 1.6em;
        margin-bottom: 20px;
    }
    .section-title {
        font-size: 1.3em;
    }
    .community-text {
        font-size: 1em;
    }
    .activities-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    .activity-item {
        padding: 15px 10px;
        font-size: 0.95em;
    }
    .left-section {
        min-width: unset;
        width: 100%;
    }
    .right-section {
        min-width: unset;
        width: 100%;
    }
    .apply-box {
        padding: 15px;
    }
    .apply-box p:first-child {
        font-size: 1.3rem;
    }
    .apply-box p:nth-child(2) {
        font-size: 1em;
    }
    .apply-btn {
        padding: 0.8rem 2rem;
        font-size: 1rem;
    }
    .sidebar-box {
        padding: 15px;
    }
    .sidebar-title {
        font-size: 1.1em;
    }
}
@media (max-width: 480px) {
    .title {
        font-size: 1.3em;
    }
    .activities-grid {
        grid-template-columns: 1fr 1fr;
    }
    .activity-item {
        font-size: 0.85em;
        padding: 12px 8px;
    }
}
/* :root {
            --primary-bg:#f6e3c5;
            --accent-dark: #0f2540;
            --accent-muted: #bfa98b;
            --card-bg: #f6ece0;
            --hover-bg: #e6d3bd;
            --border-radius: 12px;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        } */

        .document-section {
            max-width: 850px; /* Reducing max-width for 2-column layout */
            margin: 10px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .section-header h2 {
            color: var(--accent-dark);
            font-size: 1.8em;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .section-header p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 30px;
        }

        /* --- Key Change: Flex container with gap --- */
        .document-cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Space between cards */
            justify-content: flex-start;
        }

        .document-card {
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 20px;
            /* Key Change: Setting width for two cards per row */
            width: calc(50% - 10px); /* 50% width minus half the gap (20px / 2 = 10px) */
            box-sizing: border-box;
            text-align: left;
            transition: all 0.3s ease;
        }
        /* ------------------------------------------- */

        .document-card:hover {
            border-color: var(--accent-dark);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .document-card h3 {
            color: var(--accent-dark);
            font-size: 1.1em;
            margin-top: 0;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .document-card p {
            font-size: 0.9em;
            color: #777;
            margin-bottom: 20px;
        }

        .download-link {
            display: inline-block;
            color: #ca3737;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.95em;
            transition: color 0.3s;
        }

        .download-link:hover {
            color: #8b0000;
        }

        /* Mobile Responsiveness: Ensures single column on small screens */
        @media (max-width: 650px) {
            .document-card {
                width: 100%; /* One card per row on small screens */
            }
        }
        /* Apply Now Button Style */
.apply-box {
    background: white;
    padding: 2.5rem;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
    max-width: 800px;
    margin: 3rem auto;
    transition: all 0.3s ease;
}

.apply-box:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.apply-box p:first-child {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--accent-dark);
    margin-bottom: 1rem;
}

.apply-box p:nth-child(2) {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.apply-btn {
    display: inline-block;
    background: var(--accent-dark);
    color: white;
    padding: 1rem 3rem;
    border-radius: 50px;
    font-size: 1.2rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 6px 15px rgba(15,37,64,0.3);
}

.apply-btn:hover {
    background: #1a3a5f;
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(15,37,64,0.4);
}
</style>

<section class="page-header-section">
  <h1 class="page-title">Join Us</h1>
  <p class="page-subtitle">Explore our collection of Tamil heritage books and research materials</p>
</section>

<main class="container">

   <div class="container cards-section">
        <div class="card">
            <h2>Volunteers</h2>
            <p>Join our dedicated team and contribute your skills to preserve Tamil heritage</p>
        </div>
        <div class="card">
            <h2>Working with Partners</h2>
            <p>Collaborate with us on meaningful projects and advocacy programs</p>
        </div>
    </div>

    <div class="container">
        <div class="volunteer-box">
            <h1 class="title">Become a Volunteer</h1>

            <div class="main-content">
                <div class="left-section">
                    <h2 class="section-title">Join Our Volunteer Community</h2>
                    <p class="community-text">
                        AIC depends on volunteers for many key activities that drive our mission forward and preserve Tamil heritage for future generations.
                    </p>

                    <h3 class="section-title">Key Volunteer Activities:</h3>
                    <div class="activities-grid">
                        <div class="activity-item">Documentation & Research</div>
                        <div class="activity-item">Publications</div>
                        <div class="activity-item">Organizing Events</div>
                        <div class="activity-item">Fundraising</div>
                        <div class="activity-item">Representation</div>
                        <div class="activity-item">Administrative Support</div>
                    </div>

                    <div class="apply-box">
                        <p>How to Apply</p>
                        <p>Anyone interested in volunteering can apply by completing the provided volunteer application form.</p>
                        
                        <!-- Apply Now Button -->
                        <button type="button" class="apply-btn" data-bs-toggle="modal" data-bs-target="#membershipModal">
                            Apply Now
                        </button>
                    </div>            
                </div>

                <div class="right-section">
                    <div class="sidebar-box">
                        <div class="sidebar-title">Time Commitment</div>
                        <p>Flexible hours based on your availability and project needs</p>
                    </div>

                    <div class="sidebar-box">
                        <div class="sidebar-title">Location</div>
                        <p>Remote and in-person opportunities available</p>
                    </div>

                    <div class="sidebar-box">
                        <div class="sidebar-title">Benefits</div>
                        <ul class="list">
                            <li>• Skill development</li>
                            <li>• Community networking</li>
                            <li>• Cultural preservation</li>
                            <li>• Professional references</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="document-section">
              <div class="section-header">
                  <h2>Supporting Documents</h2>
                  <p>Relevant supporting documents are provided for further reference and detailed information about our programs and partnerships.</p>
              </div>

              <div class="document-cards-container">
                  <div class="document-card">
                      <h3>Volunteer Handbook</h3>
                      <p>Complete guide for IIC volunteers</p>
                      <a href="#" class="download-link">Download PDF</a>
                  </div>

                  <div class="document-card">
                      <h3>Partnership Guidelines</h3>
                      <p>Framework for organizational collaboration</p>
                      <a href="#" class="download-link">Download PDF</a>
                  </div>

                  <div class="document-card">
                      <h3>Annual Report</h3>
                      <p>IIC's latest activities and achievements</p>
                      <a href="#" class="download-link">Download PDF</a>
                  </div>

                  <div class="document-card">
                      <h3>Project Proposals</h3>
                      <p>Template for partnership proposals</p>
                      <a href="#" class="download-link">Download DOC</a>
                  </div>
              </div>
    </div>


</main>



  



@endsection

@section('modal')
<!-- Membership Application Modal -->
<div class="modal fade" id="membershipModal" tabindex="-1" aria-labelledby="membershipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: var(--card-bg); border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fs-3 fw-bold" id="membershipModalLabel" style="color: var(--accent-dark);">Membership Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="membershipApplyForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Full Name *</label>
                            <input type="text" name="full_name" class="form-control" required placeholder="Enter your full name">
                            <span class="text-danger error-text full_name_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIC Number *</label>
                            <input type="text" name="nic" class="form-control" required placeholder="Enter NIC number">
                            <span class="text-danger error-text nic_error"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block">Phone Number *</label>
                            <input type="tel" id="member_phone" class="form-control w-100" required>
                            <input type="hidden" name="phone" id="full_phone_member">
                            <span class="text-danger error-text phone_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email Address *</label>
                            <input type="email" name="email" class="form-control" required placeholder="Enter email address">
                            <span class="text-danger error-text email_error"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Address *</label>
                        <textarea name="address" class="form-control" rows="2" required placeholder="Enter your current address"></textarea>
                        <span class="text-danger error-text address_error"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Purpose of Visit *</label>
                        <textarea name="purpose" class="form-control" rows="3" required placeholder="Why do you want to join?"></textarea>
                        <span class="text-danger error-text purpose_error"></span>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Photo Upload (Image only, Max 2MB) *</label>
                            <input type="file" name="photo" class="form-control" accept="image/*" required>
                            <span class="text-danger error-text photo_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Verification Document (PDF only, Max 5MB) *</label>
                            <input type="file" name="verification_document" class="form-control" accept="application/pdf" required>
                            <span class="text-danger error-text verification_document_error"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Quick Human Check *</label>
                        <div class="captcha-box d-flex align-items-center gap-2">
                            <span class="captcha-math" id="memberCaptchaText">
                                {{ $a }} + {{ $b }} =
                            </span>
                            <input type="number" name="captcha_answer" id="member_captcha_answer" class="form-control" placeholder="?" required style="width: 80px;">
                          
                        </div>
                        <span class="text-danger error-text captcha_answer_error"></span>
                    </div>

                    <div class="text-end pt-3">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn apply-btn rounded-pill px-5" id="submitMemberBtn">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let iti_member;
    const phoneInputFieldMember = document.querySelector("#member_phone");
    const fullPhoneFieldMember = document.querySelector("#full_phone_member");

    if (phoneInputFieldMember) {
        iti_member = window.intlTelInput(phoneInputFieldMember, {
            initialCountry: "gb",
            separateDialCode: true,
            geoIpLookup: function(success, failure) {
                fetch("https://ipapi.co/json")
                    .then(res => res.json())
                    .then(data => success(data.country_code))
                    .catch(() => success("gb"));
            },
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@21.0.8/build/js/utils.js",
        });
    }

    function refreshMemberCaptcha() {
        const refreshBtn = $('.captcha-refresh-member');
        refreshBtn.find('i').addClass('fa-spin');

        fetch("{{ route('captcha.refresh') }}", {
            credentials: 'same-origin',
            cache: 'no-store'
        })
        .then(r => r.json())
        .then(data => {
            document.getElementById('memberCaptchaText').textContent = `${data.a} + ${data.b} =`;
            document.getElementById('member_captcha_answer').value = '';
            document.getElementById('member_captcha_answer').focus();
        })
        .catch(err => console.error('Captcha refresh failed:', err))
        .finally(() => {
            refreshBtn.find('i').removeClass('fa-spin');
        });
    }

    $(document).ready(function() {
        // Handle Form Submission
        $('#membershipApplyForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = $('#submitMemberBtn');
            const originalBtnHtml = submitBtn.html();

            // Clear errors
            $('.error-text').text('');
            form.find('input, textarea').removeClass('is-invalid').css('border-color', '');

            // Validate phone number
            if (phoneInputFieldMember.value.trim()) {
                if (iti_member.isValidNumber()) {
                    fullPhoneFieldMember.value = iti_member.getNumber();
                } else {
                    form.find('.phone_error').text('Please enter a valid phone number.');
                    phoneInputFieldMember.style.borderColor = '#dc2626';
                    return;
                }
            } else {
                form.find('.phone_error').text('Phone number is required.');
                phoneInputFieldMember.style.borderColor = '#dc2626';
                return;
            }

            // Prepare Data
            const formData = new FormData(this);
            
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

            $.ajax({
                url: "{{ route('membership.apply') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#membershipModal').modal('hide');
                        form[0].reset();
                        refreshMemberCaptcha();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $(`.${key}_error`).text(value[0]);
                            $(`[name="${key}"]`).addClass('is-invalid').css('border-color', '#dc2626');
                            if(key === 'phone') phoneInputFieldMember.style.borderColor = '#dc2626';
                        });
                        toastr.error('Please fix the errors in the form.');
                    } else if (xhr.status === 429) {
                        toastr.error('Too many attempts. Please try again later.');
                    } else {
                        toastr.error('An unexpected error occurred. Please try again.');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalBtnHtml);
                }
            });
        });
    });
</script>
<style>
.iti { width: 100%; }
.iti__flag-container { z-index: 5; }
.captcha-math {
    font-size: 1.1rem;
    font-weight: 600;
}
.captcha-box {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    padding: 10px;
    border-radius: 8px;
}
</style>
@endsection