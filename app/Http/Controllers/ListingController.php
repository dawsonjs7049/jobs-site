<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // get and show all listings
    public function index() 
    {
        // dd(request('tag'));

        // listings will be available in the page with the $listings variable
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
        ]);
    }

    // show single listing
    public function show(Listing $listing)
    {
        // eloquent model binding way, automatically will handle a bad listing id passed in
        return view('listings.show', ['listing' => $listing]);
    }

    // show create form
    public function create()
    {
        return view('listings.create');
    }

    // store listing data
    public function store(Request $request)
    {
        // perform validation on form
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')], // company is required and we have a rule that it must be a unique company entry in the listings table
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'], // is required and must be formatted like an email
            'tags' => 'required',
            'description' => 'required'
        ]);

        Listing::create($formFields);

        // go back to home page
        return redirect('/');
    }
}
