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

    .committee-hero {
        width: 100%;
        margin: 0 auto 3rem auto;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 4rem 1rem 3rem;
        background: linear-gradient(to bottom, var(--card-bg) 0%, var(--primary-bg) 100%);
        border: 1px solid rgba(0,0,0,0.08);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
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
        font-size: 1.25rem;
        color: var(--accent-dark);
        opacity: 0.85;
        margin: 0;
        max-width: 800px;
    }

    .member-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2.5rem;
        padding-bottom: 5rem;
    }

    .member-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 2rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(15, 37, 64, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .member-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(15, 37, 64, 0.12);
        background: var(--hover-bg);
    }

    .member-photo-wrapper {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin-bottom: 1.5rem;
        overflow: hidden;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        background: #fdfdfd;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .member-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .member-initials {
        font-size: 3rem;
        color: var(--accent-muted);
        font-weight: 700;
    }

    .member-name {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--accent-dark);
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .member-position {
        font-size: 0.95rem;
        color: var(--accent-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1rem;
    }

    .member-divider {
        width: 40px;
        height: 3px;
        background: var(--accent-muted);
        margin: 0 auto 1.5rem;
        border-radius: 2px;
    }

    .member-contact {
        display: flex;
        gap: 1rem;
        margin-top: auto;
    }

    .contact-link {
        color: var(--accent-dark);
        font-size: 1.1rem;
        transition: color 0.2s;
        opacity: 0.7;
    }

    .contact-link:hover {
        color: var(--accent-muted);
        opacity: 1;
    }

    .no-members {
        text-align: center;
        padding: 5rem 2rem;
        background: var(--card-bg);
        border-radius: var(--border-radius);
        color: var(--accent-dark);
        opacity: 0.7;
    }
</style>

<div class="container">
    <section class="committee-hero">
        <h1>Committee Members</h1>
        <p>The dedicated team overseeing the management and preservation of our archives.</p>
    </section>

    @if($members && $members->count() > 0)
        <div class="member-grid">
            @foreach($members as $member)
                <div class="member-card">
                    <div class="member-photo-wrapper">
                        @if($member->photo_path)
                            <img src="{{ asset($member->photo_path) }}" alt="{{ $member->full_name }}" class="member-photo">
                        @else
                            <div class="member-initials">
                                {{ collect(explode(' ', $member->full_name))->map(fn($n) => substr($n, 0, 1))->take(2)->join('') }}
                            </div>
                        @endif
                    </div>
                    
                    <h3 class="member-name">{{ $member->full_name }}</h3>
                    <div class="member-position">{{ $member->purpose }}</div>
                    <div class="member-divider"></div>
                    
                    <div class="member-contact">
                        @if($member->email)
                            <a href="mailto:{{ $member->email }}" class="contact-link" title="Email {{ $member->full_name }}">
                                <i class="fas fa-envelope"></i>
                            </a>
                        @endif
                        @if($member->phone)
                            <a href="tel:{{ $member->phone }}" class="contact-link" title="Call {{ $member->full_name }}">
                                <i class="fas fa-phone"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-members">
            <i class="fas fa-users-slash fa-3x mb-3"></i>
            <p>No committee members are currently listed.</p>
        </div>
    @endif
</div>

@endsection
