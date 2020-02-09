<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
class TicketsController extends Controller
{
	public $successStatus = 200;

    public function add(Request $request){
    	$ticket = new Ticket;
	    $ticket->id = $request->id;
	    $ticket->ticket_number = $request->ticket_number;
	    $ticket->rate_fare = $request->rate_fare;
	    $ticket->tax_fare = $request->tax_fare;
	    $ticket->types_fees_id = $request->types_fees_id;
	    $ticket->summ_ticket = $request->summ_ticket;
	    $ticket->passengers_id = $request->passengers_id;
	    $ticket->created_id = $request->created_id;
	    $ticket->updated_id = $request->updated_id; 
	    $ticket->types_fees_fare = $request->types_fees_fare;
	    $ticket->save();

	    return response()->json(['ticket' => $ticket], $this->successStatus);   
    
    }
}




