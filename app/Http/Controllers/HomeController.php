<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Operation;
use App\Providers\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stats = DB::table('users')
            ->select('users.name', DB::raw('sum(amount) as sum'))
            ->rightJoin('operations', 'users.id', '=', 'operations.partner')
            ->groupBy('partner')
            ->get();
        $operations = Operation::orderBy('operation_id', 'desc')->paginate(10);

        return view('home')->with([
            'operations' => $operations,
            'stats'      => $stats,
        ]);
    }

    /**
     * Reset operations.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm_reset(Request $request)
    {
        if (Operation::truncate()) {
            Support::alertSuccess($request, 'Registro reseteado.');
        } else {
            Support::alertFail($request, 'Falló el reseteo del registro');
        }

        return response()->redirectTo('/home');
    }

    /**
     * Ask reset and show balance.
     *
     * @return \Illuminate\Http\Response
     */
    public function reset()
    {
        $distribucions = [
            '60', // 60% to user 1
            '40', // 40% to user 2
        ];
        $stats = DB::table('users')
            ->select('users.name', DB::raw('sum(amount) as sum'))
            ->leftJoin('operations', 'users.id', '=', 'operations.partner')
            ->groupBy('partner')
            ->orderBy('id')
            ->get();
        // What partners already have
        $usersHave = [];
        $total = 0;
        foreach ($stats as $stat) {
            $total += $stat->sum;
            $usersHave[] = ['name' => $stat->name, 'sum' => $stat->sum];
        }
        $usersShouldHave = [];
        foreach ($distribucions as $distribucion) {
            $usersShouldHave[] = ($total * $distribucion / 100);
        }
        $message = '<p class="alert alert-info text-center"><b>El balance nos dice que:</b><br> '.$usersHave[0]['name'].' debe ';
        if (bccomp($usersShouldHave[0], $usersHave[0]['sum'], 2)) {
            $message .= 'cobrar a ';
        } else {
            $message .= 'dar a ';
        }
        $diff = abs(bcsub($usersShouldHave[0], $usersHave[0]['sum'], 2));
        $message .= $usersHave[1]['name'].' la cantidad de $'.$diff.'.</p>';

        return view('reset')->with(['stats' =>  $stats, 'usersShouldHave' => $usersShouldHave, 'message'    => $message]);
    }

    /**
     * Create operation.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_operation(Requests\CreateOperationRequest $request)
    {
        $operation = new Operation();
        $operation->amount = $request->amount;
        $operation->partner = Auth::user()->id;
        if ($operation->save()) {
            Support::alertSuccess($request, 'Monto agregado.');

            return redirect()->back();
        } else {
            Support::alertSuccess($request, 'Ocurrió un error desconocido al intentar agregar el monto.');

            return redirect()->back();
        }
    }
}
