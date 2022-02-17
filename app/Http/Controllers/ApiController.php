<?php

namespace App\Http\Controllers;
use App\Models\Trip;
use Response;
use Validator;
use Auth;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index() {
      $trips = Trip::where('user_id', auth()->user()->id)->get();
      return response()->json([
        'success' => true,
        'message' => 'List of your trips',
        'data' => $trips
      ]);
    }

    public function store(Request $request) {
      $data = $request->only('title', 'origin', 'destination', 'start_date', 'end_date', 'type', 'description');
      $validator = Validator::make($data, [
        'title' => 'required',
        'origin' => 'required',
        'destination' => 'required',
        'start_date' => 'required|date|after:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'type' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json(['error' => $validator->messages()], 200);
      }
      $trip = Trip::create([
        'user_id' => auth()->user()->id,
        'title' => $request->title,
        'origin' => $request->origin,
        'destination' => $request->destination,
        'start' => $request->start_date,
        'end' => $request->end_date,
        'type' => $request->type,
        'description' => $request->description
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Trip berhasil ditambahkan',
        'data' => $trip
      ]);
    }

    public function update(Request $request, $id) {
      $trip = Trip::find($id);
      if (!$trip) {
        return response()->json([
          'success' => false,
          'message' => 'Trip tidak ditemukan',
          'data' => ''
        ]);
      }
      foreach ($request->all() as $key => $val) {
        $trip->$key = $val;
      }
      $trip->save();

      return response()->json([
        'success' => true,
        'message' => 'Trip berhasil diupdate',
        'data' => $trip
      ]);
    }

    public function delete($id) {
      $trip = Trip::find($id)->delete();
      return response()->json([
        'success' => true,
        'message' => 'Trip berhasil dihapus',
        'data' => $trip
      ]);
    }
}
