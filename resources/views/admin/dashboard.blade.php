@extends('admin.index')
@section('admin')

    <style>
        .stat-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            transition: 0.3s;
        }
        /* .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0,0,0,0.12);
        } */
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
            font-size: 28px;
            color: #fff;
        }
        .bg-purple { background: #8e44ad!important; }
    </style>

    {{-- ======================= TOP COUNTERS ======================= --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-primary"><i class="fa fa-users"></i></div>
                <div><p>Total Users</p><h3>{{ $totalUsers }}</h3></div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-success"><i class="fa fa-list"></i></div>
                <div><p>Total Categories</p><h3>{{ $totalCategories }}</h3></div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-warning"><i class="fa fa-box"></i></div>
                <div><p>Total Products</p><h3>{{ $totalProducts }}</h3></div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-danger"><i class="fa fa-shopping-cart"></i></div>
                <div><p>Total Orders</p><h3>{{ $totalOrders }}</h3></div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-success"><i class="fa fa-money-bill"></i></div>
                <div><p>COD Orders</p><h3>{{ $codOrders }}</h3></div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-primary"><i class="fa fa-credit-card"></i></div>
                <div><p>Online Orders</p><h3>{{ $onlineOrders }}</h3></div>
            </div>
        </div>

        <form action="{{ route('orders.export') }}" method="GET" class="row g-3">

    <div class="col-md-4">
        <label>From Date</label>
        <input type="date" name="from_date" class="form-control" required>
    </div>

    <div class="col-md-4">
        <label>To Date</label>
        <input type="date" name="to_date" class="form-control" required>
    </div>

    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-success w-100">
            Export Orders
        </button>
    </div>

</form>

    </div>

    {{-- ======================= TODAY'S STATS ======================= --}}
    <h4 class="mt-4 mb-3">Today's Summary</h4>
    <div class="row g-4 mb-4">

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-dark"><i class="fa fa-calendar"></i></div>
                <div><p>Orders Today</p><h3>{{ $todayOrders }}</h3></div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-info"><i class="fa fa-rupee-sign"></i></div>
                <div><p>Today Revenue</p><h3>₹{{ $todayRevenue }}</h3></div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon bg-purple"><i class="fa fa-truck"></i></div>
                <div><p>Courier Charge Today</p><h3>₹{{ $todayCourier }}</h3></div>
            </div>
        </div>
    </div>

    {{-- ======================= ORDER STATUS ======================= --}}
    <h4 class="mt-4 mb-3">Order Status Overview</h4>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-secondary"><i class="fa fa-clock"></i></div>
                <div><p>Pending Orders</p><h3>{{ $pendingOrders }}</h3></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success"><i class="fa fa-check"></i></div>
                <div><p>Delivered</p><h3>{{ $deliveredOrders }}</h3></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-danger"><i class="fa fa-times"></i></div>
                <div><p>Cancelled</p><h3>{{ $cancelledOrders }}</h3></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning"><i class="fa fa-undo"></i></div>
                <div><p>Returned</p><h3>{{ $returnedOrders }}</h3></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- ================= LEFT COLUMN (MONTH FILTER) ================= -->
        <div class="col-md-6">
            <h4 class="mt-4 mb-3">Courier Charge (Month Filter)</h4>

            <div class="mb-3">
                <label>Select Month</label>
                <input type="month" id="courierMonth" class="form-control" value="{{ date('Y-m') }}">
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-purple"><i class="fa fa-truck"></i></div>
                <div>
                    <p>Courier Charge (Selected Month)</p>
                    <h3 id="courierAmount">₹0</h3>
                </div>
            </div>
        </div>

        <!-- ================= RIGHT COLUMN (DAILY FILTER) ================= -->
        <div class="col-md-6">
            <h4 class="mt-4 mb-3">Order Revenue (Daily Filter)</h4>

            <div class="mb-3">
                <label>Select Date</label>
                <input type="date" id="orderDate" class="form-control" value="{{ date('Y-m-d') }}">
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-success"><i class="fa fa-money-bill-wave"></i></div>
                <div>
                    <p>Order Revenue (Selected Date)</p>
                    <h3 id="orderRevenue">₹0</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= TOP SELLING PRODUCTS ======================= --}}
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h4 class="m-0">Top 5 Selling Products</h4>

        <a class="btn btn-success btn-sm d-flex align-items-center gap-1" href="{{ route('export.product.report') }}">
            <i class="bi bi-download"></i> Export
        </a>
    </div>

    <div class="table-responsive mb-5">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Sold</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->product->product_name ?? 'Unknown' }}</td>
                        <td>{{ $item->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ======================= CHARTS ======================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <canvas id="orderChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="courierChart"></canvas>
        </div>
    </div>
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <canvas id="dailyRevenueChart"></canvas>
        </div>
    </div>

    <div class="row g-4 mb-5"></div>
    <script>
        /* ================= MONTH FILTER AJAX ================== */
        function loadCourierData() {
            let month = document.getElementById('courierMonth').value;
            let url = "{{ url('admin/courier-summary') }}";

            fetch(`${url}?month=${month}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('courierAmount').innerHTML = "₹" + data.totalCourier;
                });
        }

        loadCourierData();
        document.getElementById('courierMonth').addEventListener('change', loadCourierData);


        /* ================= ORDER TYPE CHART ================== */
        new Chart(document.getElementById('orderChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [
                    {
                        label: 'Online Orders',
                        data: {!! json_encode($onlineCounts) !!},
                        backgroundColor: 'rgba(54,162,235,0.7)'
                    },
                    {
                        label: 'COD Orders',
                        data: {!! json_encode($codCounts) !!},
                        backgroundColor: 'rgba(255,99,132,0.7)'
                    }
                ]
            }
        });

        /* ================= COURIER TREND CHART ================== */
        new Chart(document.getElementById('courierChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [
                    {
                        label: 'Courier Charge',
                        data: {!! json_encode($courierTrend) !!},
                        borderColor: '#8e44ad',
                        borderWidth: 3
                    }
                ]
            }
        });

        /* ================= DAILY REVENUE CHART ================== */
        new Chart(document.getElementById('dailyRevenueChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($dailyLabels) !!},        // Example: ["01", "02", "03", ...]
                datasets: [
                    {
                        label: 'Daily Revenue (₹)',
                        data: {!! json_encode($dailyRevenue) !!},   // Example: [1200, 850, 3000, ...]
                        backgroundColor: 'rgba(46, 204, 113, 0.7)'
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₹' + value;
                            }
                        }
                    }
                }
            }
        });

    </script>
    <script>
        document.getElementById("orderDate").addEventListener("change", function () {

            let selectedDate = this.value;
            let url = "{{ url('admin/order-revenue') }}";

            fetch(`${url}?date=${selectedDate}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("orderRevenue").innerText = "₹" + data.amount;
                })
                .catch(() => {
                    document.getElementById("orderRevenue").innerText = "₹0";
                });
        });
    </script>
@endsection
