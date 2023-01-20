<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ListingController extends Controller
{
    // get and show all listings
    public function index() 
    {
        // dd(request('tag'));

        // listings will be available in the page with the $listings variable
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);

        // can use simplePaginate instead to only show prev and next
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
    public function store(Request $request) {
        
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

        if($request->hasFile('logo')) 
        {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);
 
        // go back to home page with flash message (shows only on that page, once)
        return redirect('/')->with('message', 'Listing created successfully!');
    }

    // show edit form
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    // update listing
    public function update(Request $request, Listing $listing)
    { 
        // make sure logged in user is the owner 
        if($listing->user_id != auth()->id())
        {
            abort(403, 'Unauthorized Action');
        }

        // perform validation on form
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'], // company is required and we have a rule that it must be a unique company entry in the listings table
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'], // is required and must be formatted like an email
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) 
        {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // updating an existing Listing object
        $listing->update($formFields);
 
        // go back with flash message (shows only on that page, once)
        return back()->with('message', 'Listing updated successfully!');

    }

    // delete listing
    public function destroy(Listing $listing)
    {
        // make sure logged in user is the owner 
        if($listing->user_id != auth()->id())
        {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();

        return redirect('/')->with('message', 'Listing Deleted Successfully');
    }

    // manage listings
    public function manage()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
