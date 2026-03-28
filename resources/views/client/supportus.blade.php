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


.support-hero {
    width: 100%; 
    
    margin: 0 auto 1.5rem auto; 
    
    text-align: center;
    display: flex;
    padding: 5rem 1.5rem 4rem; /* Standard height padding */

    flex-direction: column;
    align-items: center;
    justify-content: center;

    /* Background & Border Style - Consistent across the site */
    background: linear-gradient(to bottom, var(--card-bg) 0%, var(--primary-bg) 100%);
    border: 1px solid rgba(0, 0, 0, 0.08); 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); 
    border-radius: var(--border-radius); 
}

.support-hero h1 {
    font-weight: 800;
    color: var(--accent-dark);
    margin: 0 0 1rem 0;
    letter-spacing: -1.5px;
    line-height: 1.2;
}

.support-hero p {
    font-size: 1.25rem;
    color: var(--accent-dark);
    opacity: 0.8;
    margin: 0;
    max-width: 800px;
    line-height: 1.6;
}
/* Impact Section */
.impact-section {
    text-align: center;
    margin: 3rem 0 5rem;
}

.impact-section h2 {
    font-size: 2rem;
    margin-bottom: 2rem;
    color: var(--accent-dark);
}

.impact-grid {
    display: flex;
    justify-content: center;
    gap: 2.5rem;
    flex-wrap: wrap;
    max-width: 1200px;
    margin-top: 1rem auto 1rem;       /* top margin சின்னதா கொடுத்தோம் */
}   

.impact-card {
    background: var(--card-bg); /* #f6ece0 */
    border-radius: 20px;
    padding: 2rem 1.5rem;
    box-shadow: 0 10px 30px rgba(15,37,64,0.12);
    min-width: 180px;
    transition: all 0.3s ease;
}

.impact-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(15,37,64,0.18);
}

.impact-card h3 {
    font-size: 2.8rem;
    font-weight: 800;
    color: var(--accent-dark); /* Dark navy instead of red */
    margin: 0;
}

.impact-card p {
    font-size: 1.1rem;
    color: var(--accent-dark);
    margin-top: 0.8rem;
    opacity: 0.85;
}

/* Support Cards */
.support-methods {
    margin-bottom: 5rem;
}

.support-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
    gap: 3rem;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    justify-content: center;
}

.support-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(15,37,64,0.12);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.support-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 45px rgba(15,37,64,0.18);
}

.support-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
}

.support-card h3 {
    font-size: 1.6rem;
    padding: 1.8rem 1.8rem 1rem;
    margin: 0;
    color: var(--accent-dark);
    font-weight: 700;
}

.support-card p {
    flex-grow: 1;
    padding: 0 1.8rem;
    margin: 0 0 1.5rem;
    color: var(--accent-dark);
    opacity: 0.85;
    line-height: 1.7;
}

/* Buttons - Gold Theme */
.cta-btn {
    margin: 0 1.8rem 1.8rem;
    padding: 0.9rem 1.8rem;
    border-radius: 30px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.cta-btn.primary {
    background: var(--accent-muted); /* #bfa98b gold */
    color: var(--accent-dark);
}

.cta-btn.secondary {
    background: transparent;
    color: var(--accent-muted);
    border: 2px solid var(--accent-muted);
}

.cta-btn:hover {
    background: var(--accent-dark);
    color: white;
    transform: translateY(-4px);
}

/* Responsive */
@media (max-width: 768px) {
    .support-grid {
        gap: 2rem;
        padding: 0 1rem;
    }
}

@media (min-width: 1024px) {
    .support-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}
/* Impact Section - Extra Bottom Margin for Gap */
.impact-section {
    text-align: center;
    margin: 3rem 0 6rem;
    padding: 0 1rem;
}

.impact-grid {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2.5rem;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
}

/* Support Methods - Top Margin + Center Alignment */
.support-methods {
    margin-top: 2rem; /* Extra top margin for gap from impact section */
    margin-bottom: 5rem;
}

.support-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
    gap: 3rem;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem; /* Side padding for center alignment */
    justify-content: center; /* Center the grid items */
}

/* Card Height Equal for Better Alignment */
.support-card {
    display: flex;
    flex-direction: column;
    height: 100%; /* All cards same height */
    justify-content: space-between;
}

/* Responsive Gap Adjustment */
@media (max-width: 768px) {
    .impact-section {
        margin-bottom: 4rem;
    }
    .support-grid {
        gap: 2rem;
        padding: 0 1rem;
    }
}

@media (min-width: 1024px) {
    .support-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}
/* Support Cards - Fancy Hover Effect */
.support-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
    gap: 3rem;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    justify-content: center;
}

.support-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(15,37,64,0.12);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex;
    flex-direction: column;
    border: 2px solid transparent;
}

.support-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 25px 50px rgba(15,37,64,0.22);
    background: var(--hover-bg); /* #e6d3bd - Light gold hover */
    border-color: var(--accent-muted); /* Gold border on hover */
}

.support-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.support-card:hover img {
    transform: scale(1.08);
}

.support-card h3 {
    font-size: 1.6rem;
    padding: 1.8rem 1.8rem 1rem;
    margin: 0;
    color: var(--accent-dark);
    font-weight: 700;
    transition: color 0.3s ease;
}

.support-card:hover h3 {
    color: var(--accent-dark);
}

.support-card p {
    flex-grow: 1;
    padding: 0 1.8rem;
    margin: 0 0 1.5rem;
    color: var(--accent-dark);
    opacity: 0.85;
    line-height: 1.7;
    transition: opacity 0.3s ease;
}

.support-card:hover p {
    opacity: 1;
}

/* Buttons on Hover */
.cta-btn {
    margin: 0 1.8rem 1.8rem;
    padding: 0.9rem 1.8rem;
    border-radius: 30px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.4s ease;
    text-align: center;
}

.cta-btn.primary {
    background: var(--accent-muted); /* Gold */
    color: var(--accent-dark);
}

.cta-btn.secondary {
    background: transparent;
    color: var(--accent-muted);
    border: 2px solid var(--accent-muted);
}

.support-card:hover .cta-btn.primary {
    background: var(--accent-dark); /* Dark navy on hover */
    color: white;
}

.support-card:hover .cta-btn.secondary {
    background: var(--accent-muted);
    color: var(--accent-dark);
    border-color: var(--accent-dark);
}

.cta-btn:hover {
    transform: translateY(-4px);
}
.cta-btn {
    display: inline-block;
    text-decoration: none; /* Important for <a> */
    cursor: pointer;
}
.support-hero {
    margin-bottom: 2rem;          /* நீங்க விரும்பும் அளவுக்கு adjust பண்ணுங்க */
}

.impact-section {
    margin: 0;
    padding: 2rem 0;
}

.impact-grid {
    margin: 0;
}
</style>

  <section class="support-hero">
            <h1>Support Us</h1>
            <p>We truly appreciate your interest. Your contribution helps us continue our mission and serve the community better.</p>
  </section>

<main id="main-content" role="main">
    <div class="container">

      

        <section class="impact-section">
            <div class="impact-grid">
                <div class="impact-card">
                    <h3 class="impact-number" data-target="10k">0+</h3>
                    <p>Archives Preserved</p>
                </div>
                <div class="impact-card">
                    <h3 class="impact-number" data-target="500">0+</h3>
                    <p>Events Hosted</p>
                </div>
                <div class="impact-card">
                    <h3 class="impact-number" data-target="50k">0+</h3>
                    <p>Lives Touched</p>
                </div>
                <div class="impact-card">
                    <h3 class="impact-number" data-target="40">0+</h3>
                    <p>Years of Service</p>
                </div>
            </div>
        </section>

        <section class="support-methods">

        <div class="support-grid">
            <article class="support-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRQTs5QU3vHzp9TGV-kL9G7zYmaGEkCynJZFg&s alt="Donate to the Archives">
                <h3>Donate to the Archives</h3>
                <p>A one-off gift helps us care for collections and open exhibitions to the public. Every donation makes a lasting difference.</p>
                <a href="https://www.paypal.com/donate/?hosted_button_id=EXAMPLE" class="cta-btn primary" target="_blank">Donate Now</a>
                <a href="./donate-details.html" class="cta-btn secondary">Learn More</a>
            </article>

            <!-- Become a Member -->
            <article class="support-card">
                <img src="https://mba.org.au/wp-content/uploads/2025/05/AdobeStock_562906450-1290x860.jpeg" alt="Become a Member">
                <h3>Become a Member</h3>
                <p>Members receive exclusive access to events, exhibition previews, and special publications throughout the year.</p>
                <a href="./member.html" class="cta-btn primary">Join Today</a>
                <a href="./membership-benefits.html" class="cta-btn secondary">View Benefits</a>
            </article>

            <!-- Corporate Partnerships -->
            <article class="support-card">
                <img src="https://themodernnonprofit.com/wp-content/uploads/2021/08/corporate-partnerships.jpeg" alt="Corporate Partnerships">
                <h3>Corporate Partnerships</h3>
                <p>Partner with us for sponsorship and employee volunteering programs that make a real community impact.</p>
                <a href="./contact.html" class="cta-btn primary">Partner With Us</a>
                <a href="./corporate-benefits.html" class="cta-btn secondary">See Benefits</a>
            </article>

            <!-- Volunteer -->
            <article class="support-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMW4hnhH0v6aWc4wwZ5eQWepJUDKaLAkz5uw&s" alt="Volunteer" loading="lazy">
                <h3>Volunteer</h3>
                <p>Join our volunteer team and help at events, archives and education projects. Make a hands-on difference in your community.</p>
                <a href="./volunteer-signup.html" class="cta-btn primary">Sign Up</a>
                <a href="./volunteer-roles.html" class="cta-btn secondary">View Roles</a>
            </article>

            <!-- Support Our Publications -->
            <article class="support-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTUDLGHTMYYyY1MH7zDXE9EBYUJ_B2ezAhJwA&s" alt="Support Our Publications" loading="lazy">
                <h3>Support Our Publications</h3>
                <p>Help us continue publishing valuable research and cultural resources for the community by purchasing our publications.</p>
                <a href="./publication.html" class="cta-btn primary">Visit Shop</a>
                <a href="./contact.html" class="cta-btn secondary">Contact Us</a>
            </article>

            <!-- Fundraise for Us -->
            <article class="support-card">
                <img src="https://www.devatop.org/wp-content/uploads/2016/10/Fundraise-for-us-790x300.jpg" alt="Fundraise for Us">
                <h3>Fundraise for Us</h3>
                <p>Organise a fundraiser or community event and support our programs. Turn your passion into positive change.</p>
                <a href="./fundraise-start.html" class="cta-btn primary">Get Started</a>
                <a href="./fundraise-ideas.html" class="cta-btn secondary">View Ideas</a>
            </article>
        </div>

    </section>

    </div>
</main>


<script>
  document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.impact-number');
    const speed = 200; // Adjust speed (smaller = faster)

    const startCounter = (counter) => {
        const targetStr = counter.getAttribute('data-target');
        let target = parseInt(targetStr.replace('k', '000')); // "10k" → 10000, "50k" → 50000
        const isK = targetStr.includes('k');
        const displayK = isK && target >= 1000; // Only show K+ for 1K+

        let count = 0;
        const inc = target / speed;

        const updateCount = () => {
            count += inc;
            if (count < target) {
                if (displayK) {
                    counter.innerText = (Math.ceil(count / 1000)) + 'k+';
                } else {
                    counter.innerText = Math.ceil(count) + '+';
                }
                requestAnimationFrame(updateCount);
            } else {
                if (displayK) {
                    counter.innerText = (target / 1000) + 'k+';
                } else {
                    counter.innerText = target + '+';
                }
            }
        };

        updateCount();
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                startCounter(entry.target);
                observer.unobserve(entry.target); // Run once only
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => observer.observe(counter));
});
</script>

@endsection