<?php 

trait ResponseTrait {
    public function respond($data) {
        return response()->json($data);
    }
}