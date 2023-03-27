<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except('show');
    }

    public function create(){
        return view ('ad.create');
    }

    public function show(Ad $ad)
    {
        return view("ad.show", compact('ad'));
    }

    public function destroy(Ad $ad){
        if (Auth::user()->id = $ad->user->id || Auth::user()->is_admin) {
        $ad->favoritedBy()->detach();  
        $ad->deleteOrFail();
        return redirect()->route('home')->withMessage(['type'=>'danger', 'text'=>'Anuncio eliminado']);
        } else {
            return redirect()->back()->withMessage(['type'=>'danger', 'text'=>'Acción no disponible: Un anuncio solo puede ser borrado por el creador']);
        }
    }

    public function adsByUser(User $user)
    {
        $ads_user = $user->ads()->where('is_accepted', true)->latest()->paginate(16);
        return view('ad.by-user', compact('user','ads_user'));
    } 

    public function adsByFavorite(User $user)
    {
        $ads_user = Auth::user()->favoriteAds;
        return view('ad.by-favorite', compact('user','ads_user'));
    }

    public function acceptAdFavorite (Ad $ad)
    {
        $user = Auth::user();
        
        $favorite_ads = $user->favoriteAds;
                
        foreach ($favorite_ads as $favorite_ad) {
            if ($favorite_ad->id == $ad->id){
                return redirect()->back()->withMessage(['type'=>'warning', 'text'=>'El anuncio ya está añadido a favoritos']);
            }
        }        
        
        $user->favoriteAds()->attach($ad);
        return redirect()->back()->withMessage(['type'=>'success', 'text'=>'Añadido a favoritos']);
        
    }

    public function rejectAdFavorite (Ad $ad)
    {
        $user = Auth::user();
        
        $user->favoriteAds()->detach($ad);
        return redirect()->back()->withMessage(['type'=>'danger', 'text'=>'Eliminado de favoritos']);
    }

    public function userAddCart(Ad $ad)
    {
        $user = Auth::user();

        $user->cartAds()->attach($ad);
        return redirect()->back()->withMessage(['type'=>'success', 'text'=>'Articulo agregado al carrito']);
    }

    public function removeAdCart(Ad $ad)
    {
        $user = Auth::user();
        $user->cartAds()->detach($ad->id);
        return redirect()->back()->withMessage(['type'=>'danger', 'text'=>'Articulo eliminado del carrito']);;
    }
}
