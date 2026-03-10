{{-- resources/views/client/partials/eventcard.blade.php --}}

@php
    $isPast = $isPast ?? false;
@endphp

<div class="col-md-6 col-lg-4">
    <div class="card event-card h-100 shadow-sm {{ $event->is_live ? 'border-danger border-2' : '' }}">
        {{-- Status Badge --}}
        <div class="position-absolute top-0 end-0 m-2 z-1">
            @if($event->is_live)
                <span class="badge bg-danger animate-pulse">● LIVE</span>
            @elseif($event->is_upcoming)
                <span class="badge bg-success">Upcoming</span>
            @else
                <span class="badge bg-secondary">Past</span>
            @endif
        </div>

        {{-- Image --}}
        <div class="position-relative">
            @if($event->title_image)
                <img src="{{ asset($event->title_image) }}" 
                     class="card-img-top {{ $isPast ? 'opacity-75' : '' }}" 
                     alt="{{ $event->event_title }}"
                     style="height: 200px; object-fit: cover;">
            @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center {{ $isPast ? 'opacity-75' : '' }}" 
                     style="height: 200px;">
                    <i class="bi bi-calendar-event display-4 text-muted"></i>
                </div>
            @endif
            
            {{-- Live Overlay --}}
            @if($event->is_live)
                <div class="position-absolute bottom-0 start-0 end-0 bg-danger bg-opacity-90 text-white text-center py-1">
                    <small><i class="bi bi-broadcast"></i> Happening Now</small>
                </div>
            @endif
        </div>

        <div class="card-body">
            {{-- Category --}}
            @if($event->category)
                <span class="badge bg-info mb-2">{{ $event->category->name }}</span>
            @endif

            <h5 class="card-title {{ $isPast ? 'text-muted' : '' }}">
                {{ Str::limit($event->event_title, 50) }}
            </h5>
            
            <p class="card-text text-muted small mb-2">
                <i class="bi bi-calendar"></i> {{ $event->date->format('M d, Y') }}<br>
                <i class="bi bi-clock"></i> 
                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} - 
                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}<br>
                <i class="bi bi-geo-alt"></i> {{ Str::limit($event->venue, 30) }}
            </p>

            <p class="card-text small">
                {{ Str::limit(strip_tags($event->content), 80) }}
            </p>
        </div>

        <div class="card-footer bg-transparent">
            <a href="{{ route('events.show', $event->id) }}" 
               class="btn {{ $event->is_live ? 'btn-danger' : ($isPast ? 'btn-outline-secondary' : 'btn-primary') }} btn-sm w-100">
                @if($event->is_live)
                    <i class="bi bi-eye"></i> Watch Now
                @elseif($isPast)
                    <i class="bi bi-archive"></i> View Details
                @else
                    <i class="bi bi-eye"></i> View Details
                @endif
            </a>
        </div>
    </div>
</div>