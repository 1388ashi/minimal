<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Models\Post;
use Modules\Comment\Models\Comment;
use Modules\JobOffer\Models\Resumes;
use Modules\Product\Models\Product;
use Modules\PurchaseAdvisor\Models\PurchaseAdvisor;
use Modules\Ticket\Models\Ticket;

class DashboardController extends Controller
{
    public function index(){

        $weblog = Post::count();
        $commentsCount = Comment::count();
        $products =  Product::count();
        $resumesCount =  Resumes::count();
        $commetns = Comment::take(10)->latest('id')->get();
        $tickets = Ticket::where('status','pending')->take(10)->latest('id')->get();
        $resumes = Resumes::where('status','new')->get();
        $advisor = PurchaseAdvisor::where('status','notcalled')->get();

        return view('admin.pages.dashboard',compact(
            'weblog',
            'commentsCount',
            'products',
            'resumesCount',
            'commetns',
            'tickets',
            'resumes',
            'advisor'
        ));
    }
}
