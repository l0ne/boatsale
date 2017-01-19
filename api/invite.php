<?php

class Invite extends ApiEngine {

    public function _GET_invite() {
        $user = json_decode($_SESSION['user']);

        $invite = $this->data->getInviteByUser($user->id);

        self::returnJson($invite);
    }

    public function _POST_invite($data) {
        if (!isset($data->user) || !isset($data->boat)) {
            self::returnError('Invite error');
        }

        $boat = $this->data->getBoatById($data->boat);

        if (!$boat) {
            self::returnError('Boat not found');
        }

        $user = json_decode($_SESSION['user']);

        if ($boat->book_owner != $user->id) {
            self::returnError('Error permissions invite');
        }

        $this->data->addInvite($boat->id, $boat->book_owner, $data->user);

    }

    public function _POST_invite_accept($data) {

        if (!$data) {
            self::returnJson('Undefined invite');
        }

        $user = json_decode($_SESSION['user']);

        $boatId = $this->data->acceptInvite((int)$data, $user->id);
        $boat = $this->data->getBoatById($boatId);
        $countAccepted = $this->data->countAcceptedInvite($boatId);

        $update = array('total' => $boat->price / $countAccepted);

        if ($countAccepted == $boat->size) {
            $update['status'] = 2;
        }

        $this->data->updateBoatTotal($boatId, $update);

        $this->_GET_invite();
    }

    public function _POST_invite_decline($data) {

        if (!$data) {
            self::returnJson('Undefined invite');
        }

        $user = json_decode($_SESSION['user']);

        $this->data->declineInvite((int)$data, $user->id);

        $this->_GET_invite();
    }

}