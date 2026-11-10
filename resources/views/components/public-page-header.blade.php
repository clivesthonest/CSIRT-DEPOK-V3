<div class="page-header-shell text-center">
    <span class="cyber-badge"><i class='bx bx-{{ $icon ?? 'shield-quarter' }} me-1'></i> {{ $badge }}</span>
    <h1>{{ $title }}</h1>
    @if(!empty($subtitle))
        <p class="text-cyber-muted mb-0">{{ $subtitle }}</p>
    @endif
</div>
