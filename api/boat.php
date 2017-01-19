<?php

class Boat extends ApiEngine {

    public function _GET_boat() {
        $boats = $this->data->getBoats();

        self::returnJson($boats);
    }

    public function _GET_boat_types() {
        $types = $this->data->getBoatTypes();
        self::returnJson($types);
    }

    public function _GET_boat_sizes() {
        $sizes = $this->data->getBoatSizes();
        self::returnJson($sizes);
    }

    public function _POST_boat_book_start($id) {
        $user = json_decode($_SESSION['user']);
        $this->data->startBookBoat($id, $user->id);
        $this->data->inviteMe($id, $user->id);

        $this->_GET_boat();
    }

    public function _POST_boat_book_accept($id) {
        $user = json_decode($_SESSION['user']);
        $this->data->acceptBookBoat($id, $user->id);

        $this->_GET_boat();
    }

    public function _POST_boat_book_cansel($id) {
        $user = json_decode($_SESSION['user']);

        $this->data->canselBookBoat($id, $user->id);
        $this->data->canselInvite($id, $user->id);

        $this->_GET_boat();
    }
}