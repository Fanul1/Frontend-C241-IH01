<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Cloud\Firestore\FirestoreClient;

class FirestoreController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load Firestore client
        $this->firestore = new FirestoreClient([
            'projectId' => 'potcher',
            'keyFilePath' => 'application_default_credentials.json'
        ]);
    }

    public function addData() {
        $postData = $this->input->post();
        if (!empty($postData)) {
            $document = $this->firestore->collection('default')->document($postData['user']);
            $document->set($postData);
            echo 'Data berhasil diunggah ke Firestore';
        } else {
            echo 'Data tidak valid';
        }
    }
}
