@extends('layouts.masterclient')

@section('content')

<style>
  /* ===================================================
   Base Styles, Variables, and Typography (style.css)
   =================================================== */

/* 1. CSS Variables for Theme */
:root {
    --primary-bg: #f6e3c5;        /* Light Cream/Beige (BODY & GAP BG) */
    --accent-dark: #0f2540;       /* Deep Blue/Navy */
    --accent-muted: #bfa98b;      /* Muted Brown/Beige for links/accents */
    --card-bg: #fdf7ef;           /* Card Background (lighter Cream/Minimal Light) */
    --hover-bg: #e6d3bd;          /* Hover Background for dropdowns etc. */
    --border-radius: 12px;        /* Corner Radius */
    
    /* Mapping new variables to generic usage */
    --header-bg: var(--primary-bg); 
    --footer-bg: var(--accent-dark);
    --text-color: var(--accent-dark);
    --link-color: var(--accent-dark);
    --link-hover-color: var(--accent-muted);
    --border-color: #E0E0E0; /* General light border */
    
    /* NEW: Card Transition for smooth hover effect */
    --card-transition: all 0.3s ease-in-out; 
}

/* Base Reset and Typography */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* body {
    font-family: 'Inter', sans-serif;
    line-height: 1.6;
    color: var(--text-color);
    background-color: var(--primary-bg); /* Full Page Background Color */
} */

h1, h2, h3 {
    margin-bottom: 0.5em;
    font-weight: 700;
    line-height: 1.2;
    color: var(--accent-dark);
}

a {
    color: var(--link-color);
    text-decoration: none;
    transition: color 0.3s;
}

a:hover {
    color: var(--link-hover-color);
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
  
.contact-grid-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;                
    /* margin-top: -15.5rem;        
    padding: 0;
    background: transparent;
    box-shadow: none; */
}

/* Section Titles */
.contact-grid-section h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--accent-dark);
    margin-bottom: 20px;
    border-bottom: 3px solid var(--accent-muted); 
    display: inline-block;
    padding-bottom: 5px;
}

.info-intro, .form-intro {
    font-style: italic;
    color: #6B7280;
    margin-bottom: 30px;
}

/* 5.2 INDIVIDUAL CARD STYLING (Minimal Light Card + Hover) */

/* Form Container (Card 1) */
.enquiry-form-container {
    background-color: var(--card-bg); /* #f6ece0 */
    padding: 40px;
    border-radius: var(--border-radius);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); 
    transition: var(--card-transition); 
    order: 1; 
}

/* Contact Info Container (Card 2) */
.contact-info-container {
    background-color: var(--card-bg); /* #f6ece0 */
    padding: 40px;
    border-radius: var(--border-radius);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); 
    transition: var(--card-transition); 
    
    /* பழைய border மற்றும் padding நீக்கப்பட்டது */
    border-left: none; 
    padding-left: 40px; 
    padding-right: 40px;
    order: 2; 
}

/* HOVER EFFECT (Card Elevation) */
.enquiry-form-container:hover,
.contact-info-container:hover {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px); 
}

/* 5.3 Contact Info Styling */
.info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 25px;
    gap: 15px;
}

.info-item i {
    font-size: 1.5rem;
    color: var(--accent-muted); 
    margin-top: 3px;
    flex-shrink: 0;
}

.info-item strong {
    display: block;
    color: var(--accent-dark); 
    margin-bottom: 5px;
    font-weight: 700;
}

.info-item p, .info-item address {
    margin: 0;
    font-size: 0.95rem;
    color: var(--text-color);
}

/* 5.4 Form Styling */
.form-group {
    margin-bottom: 15px;
}

.enquiry-form-container input, 
.enquiry-form-container select, 
.enquiry-form-container textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: 1rem;
    color: var(--text-color);
    background-color: #FFFFFF; /* Pure white input field for contrast */
    transition: border-color 0.3s, box-shadow 0.3s;
}

.enquiry-form-container input:focus,
.enquiry-form-container select:focus,
.enquiry-form-container textarea:focus {
    border-color: var(--accent-muted);
    box-shadow: 0 0 0 3px rgba(191, 169, 139, 0.3); 
    outline: none;
}

.enquiry-form-container textarea {
    resize: vertical;
}

.submit-btn {
    width: 100%;
    padding: 14px;
    background-color: var(--accent-muted); 
    color: var(--accent-dark); 
    border: none;
    border-radius: var(--border-radius);
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.submit-btn:hover {
    background-color: var(--accent-dark); 
    color: var(--card-bg); 
    transform: translateY(-1px);
}

/* 5.5 Map Section */
.map-location-section {
    margin-bottom: 60px;
    text-align: center;
}

.map-location-section .section-title {
    margin-bottom: 30px;
    font-size: 2rem;
}

.map-placeholder {
    width: 100%;
    height: 450px;
    background-color: var(--hover-bg); 
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    display: flex;
    justify-content: center;
    align-items: center;
    color: var(--accent-dark);
    font-weight: 600;
    font-size: 1.2rem;
    overflow: hidden;
}

/* ===================================================
   6. RESPONSIVENESS (Media Queries)
   =================================================== */

@media (max-width: 992px) {
    /* Header/Nav Mobile Switch */
    .main-nav {
        display: none;
    }
    
    .mobile-menu-btn {
        display: block;
    }
    
    /* Contact Page Mobile Overrides */
    .contact-grid-section {
        grid-template-columns: 1fr; /* Stack into a single column */
        gap: 30px; /* Reduced gap on mobile */
        /* padding: 0 15px; */
    }
    
    .enquiry-form-container,
    .contact-info-container {
        padding: 30px; /* Reduced card padding on mobile */
    }

    /* Info container specific resets */
    .contact-info-container {
        border-left: none; /* Remove left border */
        padding-left: 30px; /* Reset padding to card padding */
        padding-right: 30px; 
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .map-placeholder {
        height: 300px;
    }
}

.captcha-box {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    padding: 14px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 5px;
}
.captcha-math {
    font-size: 1.1rem;
    font-weight: 600;
}
.captcha-refresh {
    cursor: pointer;
    border: none;
    background: none;
    font-size: 1.2rem;
}
.error-text {
    color: #dc2626;
    font-size: 0.85rem;
    display: block;
    margin-top: 4px;
    font-weight: 500;
}

@media (max-width: 768px) {
    .page-header-section {
      padding: 2rem 1rem 1rem !important;
    }

    .page-header-section .page-title {
      font-size: 2rem;
    }}

 @media (max-width: 480px) {
    .container {
      padding: 0 0.75rem;
    }

    .page-header-section {
      padding: 1.5rem 0.75rem !important;
    }

    .page-header-section .page-title {
      font-size: 1.5rem;
    }
 }


.iti { width: 100%; }
.iti__flag-container { z-index: 5; }
</style>
        <section class="page-header-section">
            <h1 class="page-title">Get in Touch with TIC Archives</h1>
            <p class="page-subtitle">We’re here to help with your questions and requests.</p>
        </section>
        <br>

            
          <section class="contact-grid-section">
                  
                  <div class="enquiry-form-container">
                      <h2>Send Us a Message</h2>
                      <p class="form-intro">Please fill out this quick form and we will respond within 48 hours.</p>

                    <form id="contact-enquiry-form"
                        method="POST"
                        action="{{ route('enquiry.store') }}">

                        @csrf

                        {{-- Honeypot (bot trap) --}}
                        <input type="text" name="website" style="display:none">

                        {{-- Time-based bot check --}}
                        <input type="hidden" name="form_time" value="{{ time() }}">

                        <div class="form-group">
                            <input type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Your Full Name *"
                                required>
                            <span class="text-danger error-text name_error"></span>
                        </div>

                        <div class="form-group">
                            <input type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Email Address *"
                                required>
                            <span class="text-danger error-text email_error"></span>
                        </div>

                        <div class="form-group">
                            <input type="tel"
                                id="phone"
                                name="phone_input"
                                value="{{ old('phone') }}"
                                placeholder="Phone Number">
                            <input type="hidden" name="phone" id="full_phone" value="{{ old('phone') }}">
                            <input type="hidden" name="country_name" id="country_name">
                            <span class="text-danger error-text phone_error"></span>
                        </div>

                        <div class="form-group">
                            <select name="subject" required>
                                <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select Inquiry Type *</option>
                                <option value="General" {{ old('subject') == 'General' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Collections" {{ old('subject') == 'Collections' ? 'selected' : '' }}>Archive Collections Access</option>
                                <option value="Donation" {{ old('subject') == 'Donation' ? 'selected' : '' }}>Donation / Support</option>
                                <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Website Feedback</option>
                            </select>
                            <span class="text-danger error-text subject_error"></span>
                        </div>

                        <div class="form-group">
                            <textarea name="message"
                                    rows="6"
                                    placeholder="Your Message *"
                                    required>{{ old('message') }}</textarea>
                            <span class="text-danger error-text message_error"></span>
                        </div>

                        <div class="form-group">
                            <label>Quick human check</label>

                            <div class="captcha-box">
                                <span class="captcha-math" id="captchaText">
                                    {{ $a }} + {{ $b }} =
                                </span>

                                <input type="number"
                                    name="captcha_answer"
                                    id="captcha_answer"
                                    placeholder="?"
                                    required
                                    aria-label="Math captcha answer"
                                    style="width:80px">
                            </div>
                            <span class="text-danger error-text captcha_answer_error"></span>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i> Send Enquiry
                        </button>
                    </form>

                  </div>

                   <div class="contact-info-container">
                      <h2>Contact Information</h2> <p class="info-intro">For immediate queries or specific departments, use the contact information below.</p>
                      
                      <div class="info-item">
                          <i class="fas fa-map-marker-alt"></i>
                          <div>
                              <strong>Address</strong>
                              <address>
                                  Tamil Information Centre <br>
                                  123 Heritage Lane <br>
                                  London, WC1X 0AA <br>
                                  United Kingdom
                              </address>
                          </div>
                      </div>
                      
                      <div class="info-item">
                          <i class="fas fa-phone"></i>
                          <div>
                              <strong>Phone</strong>
                              <p>Main: +44 20 1234 5678</p>
                              <p>Office: +44 20 1234 5679</p>
                          </div>
                      </div>

                      <div class="info-item">
                          <i class="fas fa-envelope"></i>
                          <div>
                              <strong>Email</strong>
                              <p>General: info@tic.org</p> <p>Research: research@tic.org</p>
                              <p>Events: events@tic.org</p>
                          </div>
                      </div>
                      
                      <div class="info-item">
                          <i class="fas fa-clock"></i>
                          <div>
                              <strong>Opening Hours</strong>
                              <p>Monday - Friday: 9:00 AM - 5:00 PM</p>
                              <p>Saturday: 9:00 AM - 1:00 PM</p>
                              <p>Sunday: Closed</p>
                          </div>
                      </div>
                  </div>
                  
             
            </section>
            <br>

            <section class="map-location-section">
                <h2 class="section-title"> Find Us on Map</h2> 
                <div class="map-placeholder">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2488.750519102462!2d-0.2882012!3d51.4133094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48760bbd1c9535c5%3A0x7d287af0d9154a49!2sTamil%20Information%20Centre!5e0!3m2!1sen!2suk!4v1701350400000!5m2!1sen!2suk" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </section>

@endsection

@section('scripts')
    <script>
    function refreshCaptcha() {
        const refreshBtn = $('.captcha-refresh');
        refreshBtn.find('i').addClass('fa-spin');
        
        fetch("{{ route('captcha.refresh') }}", {
            credentials: 'same-origin',
            cache: 'no-store'
        })
        .then(r => r.json())
        .then(data => {
            document.getElementById('captchaText').textContent =
                `${data.a} + ${data.b} =`;
            document.getElementById('captcha_answer').value = '';
            document.getElementById('captcha_answer').focus();
        })
        .finally(() => {
            refreshBtn.find('i').removeClass('fa-spin');
        });
    }

    const phoneInputField = document.querySelector("#phone");
    const fullPhoneField = document.querySelector("#full_phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
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

    $(document).ready(function() {
        $('#contact-enquiry-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('.submit-btn');
            const originalBtnHtml = submitBtn.html();
            
            // Clear previous errors
            form.find('.error-text').text('');
            form.find('.form-control, input, select, textarea').css('border-color', '');

            // Validate phone number
            if (phoneInputField.value.trim()) {
                if (phoneInput.isValidNumber()) {
                    fullPhoneField.value = phoneInput.getNumber();
                    document.getElementById('country_name').value = phoneInput.getSelectedCountryData().name;
                } else {
                    form.find('.phone_error').text('Please enter a valid phone number.');
                    phoneInputField.style.borderColor = '#dc2626';
                    return;
                }
            }

            // Disable button
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        form[0].reset();
                        refreshCaptcha();
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            form.find('.' + key + '_error').text(value[0]);
                            form.find('[name="' + key + '"]').css('border-color', '#dc2626');
                        });
                        toastr.error('Please fix the errors in the form.');
                    } else {
                        toastr.error('An unexpected error occurred. Please try again later.');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalBtnHtml);
                }
            });
        });
    });
    </script>
@endsection