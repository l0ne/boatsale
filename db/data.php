<?php
if (!extension_loaded('pdo') ) {
    die('PDO required!');
} elseif (!extension_loaded('pdo_mysql')) {
    die('PDO MySql required!');
}

class Data {

    protected $dbh;

    function __construct($config) {
        $this->dbh = new PDO("mysql:host=" . $config->db->host . ";dbname=" . $config->db->name, $config->db->user, $config->db->pass);
        $this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        ORM::set_db($this->dbh);
    }

    /*
     * Section for boat table
     */
    public function getBoats() {
        return ORM::for_table('boat')->order_by_asc('type')->find_array();
    }

    public function getBoatById($id) {
        return ORM::for_table('boat')->find_one($id);
    }

    public function startBookBoat($boatId, $userId) {
        $boat = ORM::for_table('boat')->find_one($boatId);
        $boat->set('status', 1);
        $boat->set('book_owner', $userId);
        $boat->set('total', $boat->get('price'));
        $boat->save();
    }

    public function acceptBookBoat($boatId, $userId) {
        $boat = ORM::for_table('boat')->find_one($boatId);
        $boat->set('status', 2);
        $boat->save();
    }

    public function canselBookBoat($boatId, $userId) {
        $boat = ORM::for_table('boat')->where('id', $boatId)->where('book_owner', $userId)->find_one();
        $boat->set('status', 0);
        $boat->set('book_owner', null);
        $boat->set('total', 0);
        $boat->save();
    }

    public function updateBoatTotal($id, $data) {
        $boat = ORM::for_table('boat')->find_one((int) $id);
        $boat->set($data);
        $boat->save();
    }

    public function getBoatTypes() {
        return ORM::for_table('boat')->select('type')->group_by('type')->find_array();
    }

    public function getBoatSizes() {
        return ORM::for_table('boat')->select('size')->group_by('size')->find_array();
    }

    /*
     * Section for user table
     */
    public function getUserById($id) {
        return ORM::for_table('user')->find_one((int) $id)->as_array();
    }

    public function getUsers() {
        return ORM::for_table('user')->find_array();
    }

    public function getUserByEmail($email) {
        return ORM::for_table('user')->where('email', $email)->find_one();
    }

    /*
     * Sections for invite table
     */
    public function getInviteByUser($user) {
        return ORM::for_table('invite')->where('user_id', $user)->where('status', 0)->find_array();
    }

    public function addInvite($boat, $owner, $user) {
        $invite = ORM::for_table('invite')
            ->where('boat_id', $boat)
            ->where('book_owner', $owner)
            ->where('user_id', $user)->find_one();

        if ($invite) return false;

        $invite = ORM::for_table('invite')->create();
        $invite->set('boat_id', $boat);
        $invite->set('book_owner', $owner);
        $invite->set('user_id', $user);

        $invite->save();
    }

    public function inviteMe($boat, $user) {
        $invite = ORM::for_table('invite')
            ->where('boat_id', $boat)
            ->where('book_owner', $user)
            ->where('user_id', $user)->find_one();

        if ($invite) return false;

        $invite = ORM::for_table('invite')->create();
        $invite->set('boat_id', $boat);
        $invite->set('book_owner', $user);
        $invite->set('user_id', $user);
        $invite->set('status', 1);

        $invite->save();
    }

    public function canselInvite($boat, $owner) {
        ORM::for_table('invite')->where('boat_id', $boat)->where('book_owner', $owner)->delete_many();
    }

    public function acceptInvite($id, $user) {
        $invite = ORM::for_table('invite')->where('id', $id)->where('user_id', $user)->find_one();

        if (!$invite) {
            return false;
        }

        $boatId = $invite->get('boat_id');

        $invite->set('status', 1);

        $invite->save();

        return $boatId;
    }

    public function countAcceptedInvite($boatId) {
        return ORM::for_table('invite')->where('status', 1)->where('boat_id', $boatId)->count();
    }

    public function declineInvite($id, $user) {
        $invite = ORM::for_table('invite')->where('id', $id)->where('user_id', $user)->find_one();

        if (!$invite) {
            return false;
        }

        $invite->set('status', 2);

        $invite->save();
    }
}