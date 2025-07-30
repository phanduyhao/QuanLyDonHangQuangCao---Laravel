<div class="col-lg-3 col-md-12 col-6 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
                <span class="fw-semibold d-block mb-1 fs-5">{{ $title }}</span>
                <div class="avatar flex-shrink-0">
                    <img src="/temp/img/icons/unicons/chart-success.png" alt="icon" class="rounded">
                </div>
            </div>
            <h3 class="card-title mb-2 {{ $currency ?? false ? 'currency' : '' }}">
                {{ $value }}
            </h3>
        </div>
    </div>
</div>
