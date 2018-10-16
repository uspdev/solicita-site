<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;
use Auth;
use App\Jobs\criaSiteAegir;


class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dnszone = env('DNSZONE');
        $sites = Site::all()->where('owner',\Auth::user()->id)->sortBy('dominio');
        return view('sites/index', compact('sites','dnszone'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dnszone = env('DNSZONE');
        return view('sites/create', ['dnszone'=>$dnszone]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $site = new Site;
      $site->dominio = $request->dominio;
      $site->owner = \Auth::user()->codpes;
      $site->save();

      criaSiteAegir::dispatch();

      $request->session()->flash('alert-info', 'Criação do site em andamento');
      return redirect('/sites');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        return view ('sites/show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        return view('sites/edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        $site->dominio = $request->dominio;
        $site->owner = \Auth::user()->id;
        $site->save();
        return redirect("/sites/$site->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        $site->delete();
        return redirect('/');
    }

    public function Owners(Request $request, $site)
    {
        /*
        if($request->apikey != env('CONSUMER_APIKEY'))
        {
            return response('Unauthorized action.', 403);
        }
        */

        $dominio = str_replace('.fflch.usp.br','',$site);
        $site = Site::where('dominio',$dominio)->first();
        $numeros_usp = $site->owner . ',123445';

        return response()->json($numeros_usp);
    }
}
