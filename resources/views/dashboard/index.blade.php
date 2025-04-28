@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-5 text-center fw-bold">Sales Data Set Report</h1>

    <div class="row g-4 mb-5">
        <!-- Total Sales -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-light rounded-3">
                    <h5 class="card-title text-muted">Total Sales</h5>
                    <p class="card-text h2 text-success mt-3">₱{{ number_format($totalSales, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-light rounded-3">
                    <h5 class="card-title text-muted">Sales Per Region</h5>
                    <ul class="list-unstyled">
                        @foreach ($salesPerRegion as $region)
                            <li class="d-flex justify-content-between">
                                <span>{{ $region['region_name'] }}</span>
                                <span class="text-success">{{ number_format($region['total_units']) }}</span> <!-- Assuming unit price is 1169 -->
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        

        <!-- Number of Sales -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-light rounded-3">
                    <h5 class="card-title text-muted">Number of Sales</h5>
                    <p class="card-text h2 text-primary mt-3">{{ $salesCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-4">
        <!-- Sales Per Region Chart -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent fw-bold">Sales Count Per Region</div>
                <div class="card-body">
                    <canvas id="salesPerRegionChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Sales Per Date Chart -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent fw-bold">Sales Total Per Date</div>
                <div class="card-body">
                    <canvas id="salesPerMonthChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Sales Per Region Chart
const salesPerRegionCtx = document.getElementById('salesPerRegionChart').getContext('2d');
new Chart(salesPerRegionCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($salesPerRegion->pluck('region_name')) !!},
        datasets: [{
            label: 'Sales Count',
            data: {!! json_encode($salesPerRegion->pluck('total_units')) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            borderRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 5 }
            }
        }
    }
});

// Sales Per Date Chart
const salesPerMonthCtx = document.getElementById('salesPerMonthChart').getContext('2d');

const months = {!! json_encode(
    $salesPerMonth->map(function($item) {
        return \Carbon\Carbon::parse($item->month)->format('d-m-Y');
    })
) !!};

const monthlySalesData = {!! json_encode(
    $salesPerMonth->pluck('total_units')
) !!};

new Chart(salesPerMonthCtx, {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Units Sold',
            data: monthlySalesData,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
            fill: true,
            tension: 0.4,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            x: {
                ticks: {
                    maxRotation: 90,
                    minRotation: 45
                }
            },
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection
