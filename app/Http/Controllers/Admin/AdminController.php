<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\BannerImages;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Mail;
use PDF;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{

    public function index()
    {
        // Artisan::call('migrate');
        // TOTALS
        $totalUsers      = User::count();
        $totalProducts   = Product::count();
        $totalOrders     = Order::count();
        $totalCategories = ProductCategory::count();

        // PAYMENT TYPES
        $onlineOrders = Order::where('payment_method', '!=', 'cod')->count();
        $codOrders    = Order::where('payment_method', 'cod')->count();

        // TODAY'S STATS
        $todayOrders   = Order::whereDate('created_at', today())->count();
        $todayRevenue  = Order::whereDate('created_at', today())->sum('total_amount');
        $todayCourier  = Order::whereDate('created_at', today())->sum('shipping_cost');

        // ORDER STATUS
        $pendingOrders   = Order::where('order_status', 0)->count();
        $deliveredOrders = Order::where('order_status', 1)->count();
        $cancelledOrders = Order::where('order_status', 3)->count();
        $returnedOrders  = Order::where('order_status', 4)->count();

        // TOP SELLING PRODUCTS
        $topProducts = OrderDetail::select('product_id')
            ->selectRaw('COUNT(product_id) as total')
            ->groupBy('product_id')
            ->orderBy('total', 'DESC')
            ->take(5)
            ->with('product')
            ->get();

        $startDate = Carbon::now()->subDays(30);

        // Get all orders for last 30 days
        $orders = Order::where('created_at', '>=', $startDate)->get();

        $grouped = $orders->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('Y-m-d');
        });

        $dailyLabels = [];
        $dailyRevenue = [];

        foreach ($grouped as $day => $ordersOnDay) {
            $dailyLabels[] = Carbon::parse($day)->format('d M');
            $dailyRevenue[] = $ordersOnDay->sum('total_amount');
        }

        // MONTHLY CHARTS
        $monthLabels   = [];
        $onlineCounts  = [];
        $codCounts     = [];
        $courierTrend  = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthLabels[] = Carbon::create(null, $i)->format('M');

            $onlineCounts[] = Order::whereMonth('created_at', $i)
                ->where('payment_method', '!=', 'cod')
                ->count();

            $codCounts[] = Order::whereMonth('created_at', $i)
                ->where('payment_method', 'cod')
                ->count();

            $courierTrend[] = Order::whereMonth('created_at', $i)
                ->sum('shipping_cost');
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'totalCategories',
            'onlineOrders',
            'codOrders',
            'todayOrders',
            'todayRevenue',
            'todayCourier',
            'pendingOrders',
            'deliveredOrders',
            'cancelledOrders',
            'returnedOrders',
            'topProducts',
            'monthLabels',
            'onlineCounts',
            'codCounts',
            'courierTrend',
            'dailyLabels',
            'dailyRevenue'
        ));
    }


    // ----------------------------------------------------
    // 📌 AJAX API — Month-wise Courier, COD & Online Orders
    // ----------------------------------------------------
    public function courierSummary(Request $request)
    {
        $month = $request->month ?? date('Y-m');

        $totalCourier = Order::where('created_at', 'like', "$month%")
            ->sum('shipping_cost');

        $cod = Order::where('order_status', 1)
            ->where('payment_method', 'cod')
            ->where('created_at', 'like', "$month%")
            ->count();

        $online = Order::where('order_status', 1)
            ->where('payment_method', '!=', 'cod')
            ->where('created_at', 'like', "$month%")
            ->count();

        return response()->json([
            'totalCourier' => $totalCourier,
            'cod'          => $cod,
            'online'       => $online
        ]);
    }


    // --------------------------------------------
    // 📌 EXPORT EXCEL
    // --------------------------------------------
    // public function exportOrdersExcel()
    // {
    //     return \Excel::download(new \App\Exports\OrdersExport, 'orders.xlsx');
    // }


    // --------------------------------------------
    // 📌 EXPORT PDF
    // --------------------------------------------
    // public function exportOrdersPdf()
    // {
    //     $orders = Order::all();
    //     $pdf = \PDF::loadView('admin.exports.orders_pdf', compact('orders'));
    //     return $pdf->download('orders.pdf');
    // }

    public function admin_login(Request $request)
    {
        $email    = $request->email;
        $password = $request->password;

        $admin          = User::where('email', $email)->where('user_type', 'admin')->first();

        if ($admin) {
            $hashedPassword = $admin->password;
            if (Hash::check($password, $hashedPassword)) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                Auth::login($admin);
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin')->with('error', 'Invalid password.');
            }
        } else {
            return redirect()->route('admin')->with('error', 'User not Found');
        }
    }



    public function adminProfile(Request $request)
    {
        $user = User::where('user_type', 'admin')->where('id', '1')->first();
        return view('admin.profile', compact('user'));
    }


    // public function adminProfileUpdate(Request $request)
    // {
    //     $user = User::where('user_type','admin')->where('id','1')->first();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->phone = $request->phone;

    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $fileName = time().'.'.$image->getClientOriginalExtension();
    //         $image->move(public_path('images'), $fileName);
    //         $user->image_name = $fileName;
    //     }

    //     $user->save();
    //     if($user)
    //     {
    //         return redirect()->route('admin.profile')->with('success', 'Profile has been updated successfully')->with('refresh', true);
    //     }

    // }


    public function adminProfileUpdate(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'phone' => 'required|digits:10',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'email.regex' => 'Email must be a valid @gmail.com address.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',
        ]);

        $user = User::where('user_type', 'admin')->where('id', 1)->firstOrFail();

        $user->name  = $request->name;
        $user->phone = $request->phone;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $user->image_name = $fileName;
        }

        $user->save();

        return redirect()
            ->route('admin.profile')
            ->with('success', 'Profile has been updated successfully');
    }



    public function admin_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin')->with('success', 'You have been logged out.');
    }



    public function bannerImage(Request $request)
    {
        $banner_images = BannerImages::latest()->get();

        return view('admin.banner.index', compact('banner_images'));
    }


    public function bannerImageDelete($id)
    {
        $banner = BannerImages::findOrFail($id);

        $banner->delete();

        return redirect()->back()->with('danger', 'Banner image deleted successfully.');
    }
    public function bannerImageAddPage()
    {
        return view('admin.banner.add');
    }


    // public function bannerImageAdd(Request $request)
    // {
    //     $banner_images = new BannerImages();

    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $fileName = time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('banner_images'), $fileName);
    //         $banner_images->image = 'banner_images/' . $fileName;
    //     } else {
    //         return redirect()->back()->with(['danger' => 'Please upload an image.']);
    //     }

    //     $banner_images->description = $request->description;
    //     $banner_images->title = $request->title;
    //     $banner_images->banner_link = $request->banner_link;
    //     $banner_images->save();

    //     if ($banner_images) {
    //         return redirect()->back()->with(['success' => 'Banner image has been added successfully']);
    //     } else {
    //         return redirect()->back()->with('danger', 'Failed to add banner image.');
    //     }
    // }

    public function bannerImageAdd(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_link' => 'required|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $banner = new BannerImages();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('banner_images'), $fileName);
            $banner->image = 'banner_images/' . $fileName;
        }

        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->banner_link = $request->banner_link;
        $banner->save();

        return redirect()
            ->route('admin.banner.show')
            ->with('success', 'Banner image added successfully');
    }


    public function bannerImageUpdate(Request $request)
    {
        $banner_images = BannerImages::where('id', '1')->first();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('banner_images'), $fileName);
            $banner_images->image = $fileName;
        }

        $banner_images->save();
        if ($banner_images) {
            return redirect()->route('admin.banner.show')->with('success', 'Banner image has been updated successfully')->with('refresh', true);
        }
    }




    public function regUsers(Request $request)
    {
        $users = User::where('user_type', 'user')->get();
        return view('admin.user.index', compact('users'));
    }


    public function regUserPreview($id)
    {
        $user = User::where('user_type', 'user')->where('id', $id)->first();
        return view('admin.user.view', compact('user'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        $from = Carbon::parse($request->from_date)->startOfDay();
        $to   = Carbon::parse($request->to_date)->endOfDay();

        return Excel::download(new OrdersExport($from, $to), 'orders.xlsx');
    }
    public function getBalance()
    {
        $apiKey = "xjhJ1Lc8S+45+WcHaM/jHHVhNVyhXM761VUb5SaNf0E=";
        $clientId = "47aa5f44-a0fe-4783-8e24-3376c2bee2c9";
        $accept = "text/plain";

        $url = "http://139.99.131.165/api/v2/Balance";

        $params = [
            'ApiKey' => $apiKey,
            'ClientId' => $clientId,
            'accept' => $accept
        ];

        $response = Http::get($url, $params);
        return $response->body();
    }
    public function privacyPolicy()
    {
        $privacyPolicy = Setting::where('key', 'privacy_policy')->first();

        return view('admin.privacy_policy', compact('privacyPolicy'));
    }

    public function terms()
    {
        $terms = Setting::where('key', 'terms')->first();

        return view('admin.terms', compact('terms'));
    }
    public function policyStore(Request $request)
    {
        $request->validate([
            '*' => 'required|string',
        ]);

        $data = $request->except('_token');

        $saved = [];

        foreach ($data as $key => $value) {
            $saved[] = Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with([
            'success' => 'Saved successfully',
            'settings' => $data
        ]);
    }
    public function regUserDelete($id)
    {
        $user = User::where('user_type', 'user')->findOrFail($id);

        $user->delete();

        return redirect()
            ->route('admin.users')
            ->with('success', 'User deleted successfully');
    }
}