<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    public function home()
    {
        return view('home');
    }

    public function search(Request $request)
    {
        $player = DB::table('user')->where('name', $request->player)->orWhere('name', 'like', '%' . $request->player . '%')->paginate(20);


        return response()->json($player);
    }

    public function showStrafblad(Request $request)
    {
        if ($request->wantsJson()) {

            $uuid = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
            $player = DB::table('user')->where('uuid', $uuid)->first();

            return response()->json(compact('player'));
        } else {
            $uuid = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
            $straffen = DB::table('strafblad')->where('uuid', $uuid)->get();
            return view('strafblad', compact('straffen'));
        }
    }

    public function getStrafblad(Request $request)
    {
        // $uuid = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        // $straffen = DB::table('strafblad')->where('uuid', $uuid)->get();
        return response()->json(compact('request'));
    }

    public function nieuwAccount()
    {
        return view('account.register');
    }

    public function registerAccount(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required']
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        return view('account.success');
    }

    // public function addRapport(Request $request)
    // {


    //     return response()->json($request->data);
    // }

    public function addRapport(Request $request)
    {
        $this->validate($request, [
            'rapport' => 'required|max:255',
        ]);

        ['rapport.max' => 'Het is te lang'];

        $rapport = $request->rapport['rapport'];
        $uuid = $request->player['uuid'];

        /*
          Add mail functionality here.
        */
        // $db = DB::table('strafblad')->insert()

        DB::insert('insert into strafblad (uuid, rapport) values (?, ?)', [$uuid, $rapport]);


        return response()->json(["succes" => true], 200);
    }

    public function allAccounts()
    {

        $accounts = DB::table('users')->get();

        return response()->json($accounts);
    }
}
