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
    }

    /* Hero Section */
    .committee-hero {
        width: 100%;
        margin: 0 auto 2rem auto;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem 2.5rem;
        background: linear-gradient(to bottom, var(--card-bg) 0%, var(--primary-bg) 100%);
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        border-radius: var(--border-radius);
    }

    .committee-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        color: var(--accent-dark);
        margin: 0 0 1rem 0;
        letter-spacing: -1px;
    }

    .committee-hero p {
        font-size: 1.2rem;
        color: var(--accent-dark);
        opacity: 0.85;
        margin: 0;
        max-width: 700px;
    }

    /* Intro Section */
    .committee-intro {
        background: var(--card-bg);
        padding: 2.5rem 2rem;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        text-align: center;
        max-width: 1100px;
        margin: 0 auto 3rem auto;
    }

    .committee-intro h2 {
        font-size: 2rem;
        color: var(--accent-dark);
        margin-bottom: 1rem;
    }

    .committee-intro p {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #000;
    }

    /* Members Grid */
    .committee-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto 3rem auto;
        padding: 0 1rem;
    }

    /* Member Card */
    .member-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .member-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.15);
        background: var(--hover-bg);
    }

    /* Member Photo */
    .member-photo {
        width: 100%;
        height: 280px;
        object-fit: cover;
        background: linear-gradient(135deg, #f6e3c5, #e6d3bd);
    }

    .member-photo-placeholder {
        width: 100%;
        height: 280px;
        background: linear-gradient(135deg, #f6e3c5, #e6d3bd);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: rgba(15, 37, 64, 0.2);
    }

    /* Member Info */
    .member-info {
        padding: 1.8rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .member-name {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--accent-dark);
        margin-bottom: 0.5rem;
    }

    .member-position {
        font-size: 0.95rem;
        color: var(--accent-muted);
        font-weight: 600;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .member-details {
        font-size: 0.95rem;
        line-height: 1.6;
        color: #333;
        flex-grow: 1;
    }

    .member-details p {
        margin: 0.5rem 0;
    }

    .detail-label {
        font-weight: 600;
        color: var(--accent-dark);
    }

    /* Contact Info */
    .member-contact {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(15, 37, 64, 0.1);
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .contact-item {
        font-size: 0.9rem;
        color: #555;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .contact-item i {
        color: var(--accent-dark);
        width: 18px;
    }

    /* Empty State */
    .no-members {
        text-align: center;
        padding: 3rem 2rem;
        background: var(--card-bg);
        border-radius: var(--border-radius);
        max-width: 600px;
        margin: 0 auto;
    }

    .no-members-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .no-members h3 {
        color: var(--accent-dark);
        margin-bottom: 0.5rem;
    }

    .no-members p {
        color: #666;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .committee-hero h1 {
            font-size: 2rem;
        }

        .committee-hero p {
            font-size: 1rem;
        }

        .committee-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .committee-intro {
            padding: 1.5rem 1rem;
        }

        .committee-intro h2 {
            font-size: 1.5rem;
        }

        .member-photo {
            height: 220px;
        }

        .member-info {
            padding: 1.2rem;
        }

        .member-name {
            font-size: 1.2rem;
        }
    }
</style>

<!-- Hero Section -->
<section class="committee-hero">
    <h1>Committee Members</h1>
    <p>Meet the dedicated members of our committee</p>
</section>

<!-- Intro Section -->
<section class="committee-intro">
    <h2>Our Committee</h2>
    <p>
        The Tamil Information Centre is guided by a dedicated committee of volunteers and professionals 
        committed to advancing human rights, preserving cultural heritage, and promoting peace and justice 
        for Tamil-speaking communities.
    </p>
</section>

<!-- Members Grid -->
<section class="committee-grid">
    @forelse($members as $member)
        <div class="member-card">
            <!-- Photo -->
            @if($member->photo_path)
                <img src="{{ asset($member->photo_path) }}" alt="{{ $member->full_name }}" class="member-photo">
            @else
                <div class="member-photo-placeholder">👤</div>
            @endif

            <!-- Info -->
            <div class="member-info">
                <h3 class="member-name">{{ $member->full_name }}</h3>
                
                @if($member->purpose)
                    <p class="member-position">{{ $member->purpose }}</p>
                @endif

                <div class="member-details">
                    @if($member->address)
                        <p>
                            <span class="detail-label">Location:</span><br>
                            {{ $member->address }}
                        </p>
                    @endif
                </div>

                @if($member->email || $member->phone)
                    <div class="member-contact">
                        @if($member->email)
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:{{ $member->email }}" style="color: inherit; text-decoration: none;">
                                    {{ $member->email }}
                                </a>
                            </div>
                        @endif
                        @if($member->phone)
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <a href="tel:{{ $member->phone }}" style="color: inherit; text-decoration: none;">
                                    {{ $member->phone }}
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="no-members">
            <div class="no-members-icon">👥</div>
            <h3>No Committee Members</h3>
            <p>Committee member information will be available soon.</p>
        </div>
    @endforelse
</section>

@endsection
